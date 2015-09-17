<?php

/*
Controller name: Pois
Controller description: Get list of point of interest
*/

class SUNRAIL_API_Pois_Controller
{

    public function get_point_of_interest()
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

                $post = $sunrail_api->introspector->get_current_pointofinterest($limit);
                if ($post) {
                    return $post;

                } else {
                    $sunrail_api->error("Not point of interest information available.");
                }


            }
        }else{
            $sunrail_api->error("Token required.");

        }


    }

}


