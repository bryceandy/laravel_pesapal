<?php

namespace Bryceandy\Laravel_Pesapal\Pesapal;

class OAuthConsumer
{
    public string $key;
    public string $secret;
    public string $callback_url;

    function __construct($key, $secret, $callback_url = NULL) {
        $this->key = $key;
        $this->secret = $secret;
        $this->callback_url = $callback_url;
    }

    function __toString() {
        return "OAuthConsumer[key=$this->key,secret=$this->secret]";
    }
}
