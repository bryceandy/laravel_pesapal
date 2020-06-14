<?php

namespace Bryceandy\Laravel_Pesapal\OAuth;

class OAuthSignatureMethod_PLAINTEXT extends OAuthSignatureMethod
{
    public function get_name()
    {
        return "PLAINTEXT";
    }

    public function build_signature($request, $consumer, $token)
    {
        $sig = array(
            OAuthUtil::urlencode_rfc3986($consumer->secret)
        );

        $token ?
            array_push($sig, OAuthUtil::urlencode_rfc3986($token->secret)) :
            array_push($sig, '');

        $raw = implode("&", $sig);
        // for debug purposes
        $request->base_string = $raw;

        return OAuthUtil::urlencode_rfc3986($raw);
    }
}
