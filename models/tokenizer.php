<?php

class SUNRAIL_API_Tokenizer
{


    function SUNRAIL_API_Tokenizer()
    {
        do_action("sunrail_api_{$this->type}_constructor", $this);
    }


    function getToken()
    {

        $token = [];
        $nonce = wp_create_nonce( 'API' );
        $token['result'] = array(token => $nonce);

        return $token;
    }



}


