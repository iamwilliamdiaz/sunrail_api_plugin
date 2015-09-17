<?php

class SUNRAIL_API_Parking
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

    function SUNRAIL_API_Parking()
    {
        do_action("sunrail_api_{$this->type}_constructor", $this);
    }

    function getParkings($limit)
    {

        $parkings = new WP_Query(array('post_type' => 'parking', 'posts_per_page' => $limit,  'hide_empty' => 1, 'cache_results' => true, 'post_status'=>'publish'));
        $parkinglists = $parkings->posts;
        $parkingdata = [];
        for ($i = 0; $i <= count($parkinglists); $i++) {
            $parkingdetail = get_metadata('post', $parkinglists[$i]->ID, '', true);
            if (isset($parkinglists[$i]))
                $parkingdata['result'][] = array(id => $parkinglists[$i]->ID, title => $parkinglists[$i]->post_title, address => $parkingdetail['parking_address'][0], pricing => $parkingdetail['parking_price'][0], type => $parkingdetail['parking_typeofparking'][0], latt => $parkingdetail['parking_latitude'][0], long => $parkingdetail['parking_longitude'][0]);

        }
        $parkingdata['cached'] = true;
        $parkingdata['limit'] = $limit;
        $parkingdata['total'] = $parkings->found_posts;

        return $parkingdata;
    }

}


