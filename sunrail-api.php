<?php
/*
Plugin Name: SUNRAIL API
Description: A RESTful API
Version: 1.0.0
Author: William Diaz
Author URI: http://www.rightbrainmedia.com/
*/

$dir = sunrail_api_dir();
@include_once "$dir/singletons/api.php";
@include_once "$dir/singletons/query.php";
@include_once "$dir/singletons/introspector.php";
@include_once "$dir/singletons/response.php";
@include_once "$dir/models/pois.php";
@include_once "$dir/models/stations.php";
@include_once "$dir/models/parking.php";
@include_once "$dir/models/alerts.php";
@include_once "$dir/models/schedules.php";
@include_once "$dir/models/tokenizer.php";



function sunrail_api_init() {
  global $sunrail_api;
  if (phpversion() < 5) {
    add_action('admin_notices', 'sunrail_api_php_version_warning');
    return;
  }
  if (!class_exists('SUNRAIL_API')) {
    add_action('admin_notices', 'sunrail_api_class_warning');
    return;
  }
  add_filter('rewrite_rules_array', 'sunrail_api_rewrites');
  $sunrail_api = new SUNRAIL_API();
}

function sunrail_api_php_version_warning() {
  echo "<div id=\"sunrail-api-warning\" class=\"updated fade\"><p>Sorry, SUNRAIL API requires PHP version 5.0 or greater.</p></div>";
}

function sunrail_api_class_warning() {
  echo "<div id=\"sunrail-api-warning\" class=\"updated fade\"><p>Oops, SUNRAIL API class not found. If you've defined a SUNRAIL API_DIR constant, double check that the path is correct.</p></div>";
}

function sunrail_api_activation() {
  // Add the rewrite rule on activation
  global $wp_rewrite;
  add_filter('rewrite_rules_array', 'sunrail_api_rewrites');
  $wp_rewrite->flush_rules();
}

function sunrail_api_deactivation() {
  // Remove the rewrite rule on deactivation
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}

function sunrail_api_rewrites($wp_rules) {
  $base = get_option('sunrail_api_base', 'api');
  if (empty($base)) {
    return $wp_rules;
  }
  $sunrail_api_rules = array(
    "$base\$" => 'index.php?json=info',
    "$base/(.+)\$" => 'index.php?json=$matches[1]'
  );
  return array_merge($sunrail_api_rules, $wp_rules);
}

function sunrail_api_dir() {
  if (defined('SUNRAIL_API_DIR') && file_exists(SUNRAIL_API_DIR)) {
    return SUNRAIL_API_DIR;
  } else {
    return dirname(__FILE__);
  }
}

// Add initialization and activation hooks
add_action('init', 'sunrail_api_init');
register_activation_hook("$dir/sunrail-api.php", 'sunrail_api_activation');
register_deactivation_hook("$dir/sunrail-api.php", 'sunrail_api_deactivation');


