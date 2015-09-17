<?php

class SUNRAIL_API_Station
{

    // Note:
    //   SUNRAIL_API_Station objects must be instantiated within The Loop.

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

    function SUNRAIL_API_Station()
    {
        do_action("sunrail_api_{$this->type}_constructor", $this);
    }


    function getStations($limit)
    {
        $stations = new WP_Query(array('post_type' => 'station', 'posts_per_page' => $limit,  'hide_empty' => 1, 'cache_results' => true, 'post_status'=>'publish'));
        $stationlists = $stations->posts;
        $stationdata = [];
        for ($i = 0; $i <= count($stationlists); $i++) {
            $stationdetail = get_metadata('post', $stationlists[$i]->ID, '', true);
            if (isset($stationlists[$i]))
                $stationdata['result'][] = array(id => $stationlists[$i]->ID, title => $stationlists[$i]->post_title, address => $stationdetail['station_address'][0], phone => $stationdetail['station_phonenumber'][0], latt => $stationdetail['station_latitude'][0], long => $stationdetail['station_longitude'][0]);

        }

        $stationdata['cached'] = true;
        $stationdata['limit'] = $limit;
        $stationdata['total'] = $stations->found_posts;
        return $stationdata;
    }



}


