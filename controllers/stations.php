<?php

/*
Controller name: Stations
Controller description: Get a list of stations
*/

class SUNRAIL_API_Stations_Controller
{

    public function get_stations()
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

                $post = $sunrail_api->introspector->get_current_stations($limit);
                if ($post) {
                    return $post;

                } else {
                    $sunrail_api->error("Not station information available.");
                }


            }
        }else{
            $sunrail_api->error("Token required.");

        }



    }



}


