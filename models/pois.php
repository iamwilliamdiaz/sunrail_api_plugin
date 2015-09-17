<?php

class SUNRAIL_API_Poi
{

    // Note:
    //   SUNRAIL_API_POI objects must be instantiated within The Loop.

    var $id; // Integer
    var $type; // String
    var $slug; // String
    var $url; // String
    var $status; // String ("draft", "published", or "pending")
    var $title; // String
    var $title_plain; // String
    var $content; // String (modified by read_more query var)
    var $excerpt; // String
    var $date; // String (modified by date_format query var)
    var $modified; // String (modified by date_format query var)
    var $categories; // Array of objects
    var $tags; // Array of objects
    var $author; // Object
    var $comments; // Array of objects
    var $attachments; // Array of objects
    var $comment_count; // Integer
    var $comment_status; // String ("open" or "closed")
    var $thumbnail; // String
    var $custom_fields; // Object (included by using custom_fields query var)

    function SUNRAIL_API_Poi()
    {
        do_action("sunrail_api_{$this->type}_constructor", $this);
    }


    function getPOIs($limit)
    {
        $pois = new WP_Query(array('post_type' => 'poi', 'posts_per_page' => $limit,  'hide_empty' => 1, 'cache_results' => true, 'post_status'=>'publish'));
        $poilists = $pois->posts;
        $poidata = [];
        for ($i = 0; $i <= count($poilists); $i++) {
            $poidetail = get_metadata('post', $poilists[$i]->ID, '', true);
            if (isset($poilists[$i]))
                $poidata['result'][] = array(id => $poilists[$i]->ID, title => $poilists[$i]->post_title,description => $poilists[$i]->post_content, address => $poidetail['poi_address'][0], phone => $poidetail['poi_phone'][0],website => $poidetail['poi_website'][0], latt => $poidetail['poi_latitude'][0], long => $poidetail['poi_longitude'][0]);

        }
        $poidata['cached'] = true;
        $poidata['limit'] = $limit;
        $poidata['total'] = $pois->found_posts;
        return $poidata;
    }

}


