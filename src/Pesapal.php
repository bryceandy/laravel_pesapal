<?php

namespace Bryceandy\Laravel_Pesapal;

use Bryceandy\Laravel_Pesapal\OAuth\OAuthConsumer;
use Bryceandy\Laravel_Pesapal\OAuth\OAuthRequest;
use Bryceandy\Laravel_Pesapal\OAuth\OAuthSignatureMethod_HMAC_SHA1;
use Illuminate\Config\Repository;

class Pesapal
{
    private $token;

    private $params;

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
     * @var string
     */
    private string $serverURL;

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
        $this->token = NULL;
        $this->params = NULL;
        $this->consumerKey = config('pesapal.consumer_key');
        $this->consumerSecret = config('pesapal.consumer_secret');
        $this->consumer = new OAuthConsumer($this->consumerKey, $this->consumerSecret);
        $this->signatureMethod = $signature;
        $this->serverURL = config('pesapal.is_live')
            ? 'https://www.pesapal.com'
            : 'https://demo.pesapal.com';
        $this->iframeLink = $this->serverURL . '/api/PostPesapalDirectOrderV4';
        $this->callbackUrl = config('pesapal.callback_url');
    }

    /**
     * Fetches the iframe source after passing payment parameters
     *
     * @param $request
     * @return OAuthRequest
     */
    public function getIframeSource($request)
    {
        $parameterizedValue = "";
        // Pesapal params
        isset($request['first_name']) ? $parameterizedValue .= "\" FirstName=\"".$request['first_name'] : null;
        isset($request['last_name']) ? $parameterizedValue .= "\" LastName=\"".$request['last_name'] : null;
        isset($request['email']) ? $parameterizedValue .= "\" Email=\"".$request['email'] : null;
        isset($request['phone_number']) ? $parameterizedValue .= "\" PhoneNumber=\"".$request['phone_number'] : null;

        $postXml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><PesapalDirectOrderInfo xmlns:xsi=\"http://www.w3.org/2001/XMLSchemainstance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" Currency=\"".$request['currency']."\" Amount=\"".number_format($request['amount'], 2)."\" Description=\"".$request['description']."\" Type=\"".$request['type']."\" Reference=\"".$request['reference'].$parameterizedValue."\" xmlns=\"http://www.pesapal.com\" />";
        $postXml = htmlentities($postXml);

        // Post transaction to PesaPal
        $iframeSrc = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, "GET", $this->iframeLink, $this->params);
        $iframeSrc->set_parameter("oauth_callback", $this->callbackUrl);
        $iframeSrc->set_parameter("pesapal_request_data", $postXml);
        $iframeSrc->sign_request($this->signatureMethod, $this->consumer, $this->token);
        // Retrieve iframe source
        return $iframeSrc;
    }

    public function getTransactionDetails($merchantRef, $trackingId)
    {
        $url = $this->serverURL . '/API/QueryPaymentDetails';

        $responseData = $this->getResponseData($merchantRef, $trackingId, $url);

        $pesapalResponse = explode(",", $responseData);

        return [
            'pesapal_transaction_tracking_id' => $pesapalResponse[0],
            'payment_method' => $pesapalResponse[1],
            'status' => $pesapalResponse[2],
            'pesapal_merchant_reference' => $pesapalResponse[3],
        ];
    }

    /**
     * Get payment status by merchant reference and tracking id
     *
     * @param $merchantRef
     * @param $trackingId
     * @return mixed|string
     */
    public function statusByTrackingIdAndMerchantRef($merchantRef, $trackingId)
    {
        $url = $this->serverURL . '/API/QueryPaymentStatus';

        return $this->getResponseData($merchantRef, $trackingId, $url);
    }

    /**
     * Get payment status by merchant reference
     *
     * @param $merchantReference
     * @return mixed|string
     */
    public function statusByMerchantRef($merchantReference){

        $url = $this->serverURL.'/API/QueryPaymentStatusByMerchantRef';

        $requestStatus = $this->initRequestStatus($url);
        $requestStatus->set_parameter("pesapal_merchant_reference", $merchantReference);
        $requestStatus->sign_request($this->signatureMethod, $this->consumer, $this->token);

        return $this->curlRequest($requestStatus);
    }

    /**
     * Returns the response data when checking status or fetching payment details
     *
     * @param string $merchantReference
     * @param $trackingId
     * @param string $url
     * @return mixed|string
     */
    private function getResponseData(string $merchantReference, $trackingId, string $url)
    {
        $requestStatus = $this->initRequestStatus($url);

        $requestStatus->set_parameter("pesapal_merchant_reference", $merchantReference);
        $requestStatus->set_parameter("pesapal_transaction_tracking_id",$trackingId);
        $requestStatus->sign_request($this->signatureMethod, $this->consumer, $this->token);

        return $this->curlRequest($requestStatus);
    }

    /**
     * Initialize request status
     *
     * @param $url
     * @return OAuthRequest
     */
    private function initRequestStatus($url)
    {
        return OAuthRequest::from_consumer_and_token(
            $this->consumer,
            $this->token,
            'GET',
            $url,
            $this->params
        );
    }

    /**
     * Perform curl request to get the payment status
     *
     * @param $request_status
     * @return mixed|string
     */
    private function curlRequest($request_status)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_status);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if(defined('CURL_PROXY_REQUIRED')) if (CURL_PROXY_REQUIRED == 'True'){
            $proxy_tunnel_flag = (
                defined('CURL_PROXY_TUNNEL_FLAG')
                && strtoupper(CURL_PROXY_TUNNEL_FLAG) == 'FALSE'
            ) ? false : true;
            curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, $proxy_tunnel_flag);
            curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            curl_setopt ($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
        }

        $response 	  = curl_exec($ch);
        $header_size  = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $raw_header   = substr($response, 0, $header_size - 4);
        $headerArray  = explode("\r\n\r\n", $raw_header);
        $header 	  = $headerArray[count($headerArray) - 1];

        // Payment status
        $elements = preg_split("/=/",substr($response, $header_size));

        curl_close($ch);
        return $elements[1];
    }
}
