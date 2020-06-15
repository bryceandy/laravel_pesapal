<?php

namespace Bryceandy\Laravel_Pesapal;

use Bryceandy\Laravel_Pesapal\OAuth\OAuthConsumer;
use Bryceandy\Laravel_Pesapal\OAuth\OAuthRequest;
use Bryceandy\Laravel_Pesapal\OAuth\OAuthSignatureMethod_HMAC_SHA1;
use Illuminate\Config\Repository;

class Pesapal
{
    /**
     * @var Repository|mixed|string 
     */
    private string $consumerKey;

    /**
     * @var Repository|mixed|string
     */
    private string $consumerSecret;

    /**
     * @var OAuthSignatureMethod_HMAC_SHA1
     */
    private OAuthSignatureMethod_HMAC_SHA1 $signatureMethod;

    /**
     * @var string
     */
    private string $iframeLink;

    /**
     * @var Repository|mixed|string
     */
    private string $callbackUrl;

    /**
     * @var OAuthConsumer
     */
    private OAuthConsumer $consumer;

    /**
     * Pesapal constructor.
     *
     * @param OAuthSignatureMethod_HMAC_SHA1 $signature
     */
    public function __construct(OAuthSignatureMethod_HMAC_SHA1 $signature)
    {
        $this->consumerKey = config('laravel_pesapal.consumer_key');
        $this->consumerSecret = config('laravel_pesapal.consumer_secret');
        $this->consumer = new OAuthConsumer($this->consumerKey, $this->consumerSecret);
        $this->signatureMethod = $signature;
        $this->iframeLink = config('laravel_pesapal.is_live') ?
            'https://www.pesapal.com/api/PostPesapalDirectOrderV4' :
            'https://demo.pesapal.com/api/PostPesapalDirectOrderV4';
        $this->callbackUrl = config('laravel_pesapal.callback_url');
    }

    /**
     * Fetches the iframe source after passing payment parameters
     *
     * @param $request
     * @return OAuthRequest
     */
    public function getIframeSource($request)
    {
        // Pesapal params
        $token = $params = NULL;
        $postXml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><PesapalDirectOrderInfo xmlns:xsi=\"http://www.w3.org/2001/XMLSchemainstance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" Currency=\"".$request->currency."\" Amount=\"".$request->amount."\" Description=\"".$request->description."\" Type=\"".$request->type."\" Reference=\"".$request->reference."\" FirstName=\"".$request->first_name?:''."\" LastName=\"".$request->last_name?:''."\" Email=\"".$request->email?:''."\" PhoneNumber=\"".$request->phone_number?:''."\" xmlns=\"http://www.pesapal.com\" />";
        $postXml = htmlentities($postXml);

        $consumer = new OAuthConsumer($this->consumerKey, $this->consumerSecret);

        // Post transaction to pesapal
        $iframeSrc = OAuthRequest::from_consumer_and_token($this->consumer, $token, "GET", $this->iframeLink, $params);
        $iframeSrc->set_parameter("oauth_callback", $this->callbackUrl);
        $iframeSrc->set_parameter("pesapal_request_data", $postXml);
        $iframeSrc->sign_request($this->signatureMethod, $this->consumer, $token);
        // Retrieve iframe source
        return $iframeSrc;
    }

    public function statusByTrackingIdAndMerchantRef($merchantRef, $tracking_id)
    {
        $requestStatus = OAuthRequest::from_consumer_and_token(
            $this->consumer,
        );
    }
}
