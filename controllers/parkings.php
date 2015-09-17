<?php

/*
Controller name: Parkings
Controller description: Get list of parkings
*/

class SUNRAIL_API_Parkings_Controller
{

    public function get_parkings()
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

                $post = $sunrail_api->introspector->get_current_parkings($limit);
                if ($post) {
                    return $post;

                } else {
                    $sunrail_api->error("Not parking information available.");
                }


            }
        }else{
            $sunrail_api->error("Token required.");

        }

    }

}


