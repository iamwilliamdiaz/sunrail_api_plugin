<?php

/*
Controller name: Alerts
Controller description: List of Alerts
*/

class SUNRAIL_API_Alerts_Controller
{

    public function get_alerts()
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

                $post = $sunrail_api->introspector->get_current_alerts($limit);
                if ($post) {
                    return $post;

                } else {
                    $sunrail_api->error("Not alerts information available.");
                }


            }
        }else{
            $sunrail_api->error("Token required.");

        }



    }

}


