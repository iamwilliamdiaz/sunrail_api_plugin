<?php

/*
Controller name: Schedules
Controller description: Get a list of schedules
*/

class SUNRAIL_API_Schedules_Controller
{

    public function get_schedules()
    {

        global $sunrail_api, $post;

        if (isset($sunrail_api->query->token)) {

            if ( ! wp_verify_nonce( $sunrail_api->query->token, 'API' ) ) {
                // This nonce is not valid.
                $sunrail_api->error("Invalid token.");
            } else {


                if (isset($sunrail_api->query->limit)) {
                    $limit = $sunrail_api->query->limit;
                } else {
                    $limit = 25;
                }

                $post = $sunrail_api->introspector->get_current_schedules($limit);
                if ($post) {
                    return $post;

                } else {
                    $sunrail_api->error("Not schedules information available.");
                }


            }
        }else{
            $sunrail_api->error("Token required.");

        }



    }

}


