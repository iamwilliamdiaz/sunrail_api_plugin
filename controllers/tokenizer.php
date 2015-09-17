<?php

/*
Controller name: Tokenizer
Controller description: Generate a Wordpress nounce token
*/

class SUNRAIL_API_Tokenizer_Controller
{

    public function get_token()
    {
        global $sunrail_api, $post;

        $post = $sunrail_api->introspector->get_current_token();
        if ($post) {
            return $post;

        } else {
            $sunrail_api->error("Your're not authorized to get a token.");
        }

    }

}


