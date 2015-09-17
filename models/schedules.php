<?php

class SUNRAIL_API_Schedule
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

    function SUNRAIL_API_Schedule()
    {
        do_action("sunrail_api_{$this->type}_constructor", $this);
    }


    function getSchedules($limit)
    {
        $schedules = new WP_Query(array('post_type' => 'schedule', 'posts_per_page' => $limit,  'hide_empty' => 1, 'cache_results' => true, 'post_status'=>'publish'));
        $schedulelists = $schedules->posts;
        $scheduledata = [];
        for ($i = 0; $i <= count($schedulelists); $i++) {
            $scheduledetail = get_metadata('post', $schedulelists[$i]->ID, '', true);
            if (isset($schedulelists[$i]))
                $scheduledata['result'][] = array(

                    id => $schedulelists[$i]->ID,
                    title => $schedulelists[$i]->post_title,

                    northbound => [

                        timelot1 => $scheduledetail['schedule_time_nb_slot1'][0],
                        timelot2 => $scheduledetail['schedule_time_nb_slot2'][0],
                        timelot3 => $scheduledetail['schedule_time_nb_slot3'][0],
                        timelot4 => $scheduledetail['schedule_time_nb_slot4'][0],
                        timelot5 => $scheduledetail['schedule_time_nb_slot5'][0],
                        timelot6 => $scheduledetail['schedule_time_nb_slot6'][0],
                        timelot7 => $scheduledetail['schedule_time_nb_slot7'][0]],


                    southbound => [

                        timelot1 => $scheduledetail['schedule_time_sb_slot1'][0],
                        timelot2 => $scheduledetail['schedule_time_sb_slot2'][0],
                        timelot3 => $scheduledetail['schedule_time_sb_slot3'][0],
                        timelot4 => $scheduledetail['schedule_time_sb_slot4'][0],
                        timelot5 => $scheduledetail['schedule_time_sb_slot5'][0],
                        timelot6 => $scheduledetail['schedule_time_sb_slot6'][0],
                        timelot7 => $scheduledetail['schedule_time_sb_slot7'][0]]


                );

        }
        $scheduledata['cached'] = true;
        $scheduledata['limit'] = $limit;
        $scheduledata['total'] = $schedules->found_posts;
        return $scheduledata;
    }

}


