<?php

class SUNRAIL_API_Alert
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

    function SUNRAIL_API_Alert()
    {
        do_action("sunrail_api_{$this->type}_constructor", $this);
    }


    function getAlerts($limit)
    {

        $alerts = new WP_Query(array('post_type' => 'alert', 'posts_per_page' => $limit,  'hide_empty' => 1, 'cache_results' => true, 'post_status'=>'publish'));
        $alertlists = $alerts->posts;
        $alertdata = [];
        for ($i = 0; $i <= count($alertlists); $i++) {
            $alertdetail = get_metadata('post', $alertlists[$i]->ID, '', true);

                $date = new DateTime();
                $validatedate = $date->format('m/d/Y g:i A');

            if (isset($alertlists[$i]) && $alertdetail['alert_enddate'][0] <= $validatedate)
                $alertdata['result'][] = array(id => $alertlists[$i]->ID, title => $alertlists[$i]->post_title,message => $alertlists[$i]->post_content, start_date => $alertdetail['alert_startdate'][0], end_date => $alertdetail['alert_enddate'][0], enabled=> $alertdetail['alert_enabled'][0], currentdate => $validatedate);

        }
        $alertdata['cached'] = true;
        $alertdata['limit'] = $limit;
        $alertdata['total'] = $alerts->found_posts;
        return $alertdata;
    }

}


