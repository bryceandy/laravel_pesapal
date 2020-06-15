<?php

namespace Bryceandy\Laravel_Pesapal;

use Bryceandy\Laravel_Pesapal\OAuth\OAuthConsumer;
use Bryceandy\Laravel_Pesapal\OAuth\OAuthRequest;
use Bryceandy\Laravel_Pesapal\OAuth\OAuthSignatureMethod_HMAC_SHA1;

class Pesapal
{
    protected string $consumer_key;

    protected string $consumer_secret;

    protected OAuthSignatureMethod_HMAC_SHA1 $signature_method;

    protected string $iframe_link;

    protected string $callback_url;

    /**
     * Pesapal constructor.
     *
     * @param OAuthSignatureMethod_HMAC_SHA1 $signature
     */
    public function __construct(OAuthSignatureMethod_HMAC_SHA1 $signature)
    {
        $this->consumer_key = config('laravel_pesapal.consumer_key');
        $this->consumer_secret = config('laravel_pesapal.consumer_secret');
        $this->signature_method = $signature;
        $this->iframe_link = config('laravel_pesapal.is_live') ?
            'https://www.pesapal.com/api/PostPesapalDirectOrderV4' :
            'https://demo.pesapal.com/api/PostPesapalDirectOrderV4';
        $this->callback_url = config('laravel_pesapal.callback_url');
    }

    public function getIframeSource($request)
    {
        //pesapal params
        $token = $params = NULL;
        $post_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><PesapalDirectOrderInfo xmlns:xsi=\"http://www.w3.org/2001/XMLSchemainstance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" Currency=\"".$request->currency."\" Amount=\"".$request->amount."\" Description=\"".$request->description."\" Type=\"".$request->type."\" Reference=\"".$request->reference."\" FirstName=\"".$request->first_name?:''."\" LastName=\"".$request->last_name?:''."\" Email=\"".$request->email?:''."\" PhoneNumber=\"".$request->phone_number?:''."\" xmlns=\"http://www.pesapal.com\" />";
        $post_xml = htmlentities($post_xml);

        $consumer = new OAuthConsumer($this->consumer_key, $this->consumer_secret);

        //post transaction to pesapal
        $iframe_src = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $this->iframe_link, $params);
        $iframe_src->set_parameter("oauth_callback", $this->callback_url);
        $iframe_src->set_parameter("pesapal_request_data", $post_xml);
        $iframe_src->sign_request($this->signature_method, $consumer, $token);

        return $iframe_src;
    }
}
