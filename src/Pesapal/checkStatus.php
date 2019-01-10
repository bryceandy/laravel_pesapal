<?php

namespace Bryceandy\Laravel_Pesapal\Pesapal;


class pesapalCheckStatus {

    var $token;
    var $params;
    var $signature_method;

    var $QueryPaymentStatus;
    var $QueryPaymentStatusByMerchantRef;
    var $querypaymentdetails;

    public function __construct(){

        $this->token = $this->params	= NULL;
        $consumer_key 		= config('laravel_pesapal.consumer_key');
        $consumer_secret 	= config('laravel_pesapal.consumer_key');

        $this->signature_method			= new OAuthSignatureMethod_HMAC_SHA1();
        $this->consumer 				= new OAuthConsumer($consumer_key, $consumer_secret);

        $isDemo =false;  // i confirm the key above belong to a DEMO merchant
        if($isDemo)
            $api = 'https://demo.pesapal.com';
        else
            $api = 'https://www.pesapal.com';

        $this->QueryPaymentStatus 				= 	$api.'/API/QueryPaymentStatus';
        $this->QueryPaymentStatusByMerchantRef	= 	$api.'/API/QueryPaymentStatusByMerchantRef';
        $this->querypaymentdetails 				= 	$api.'/API/querypaymentdetails';
    }

    function checkStatusUsingTrackingIdandMerchantRef($pesapalMerchantReference,$pesapalTrackingId){

        //get transaction status
        $request_status = OAuthRequest::from_consumer_and_token(
            $this->consumer,
            $this->token,
            "GET",
            $this->QueryPaymentStatus,
            $this->params
        );
        $request_status->set_parameter("pesapal_merchant_reference", $pesapalMerchantReference);
        $request_status->set_parameter("pesapal_transaction_tracking_id",$pesapalTrackingId);
        $request_status->sign_request($this->signature_method, $this->consumer, $this->token);

        $status = $this->curlRequest($request_status);

        return $status;
    }

    function getTransactionDetails($pesapalMerchantReference,$pesapalTrackingId){

        $request_status = OAuthRequest::from_consumer_and_token(
            $this->consumer,
            $this->token,
            "GET",
            $this->querypaymentdetails,
            $this->params
        );
        $request_status->set_parameter("pesapal_merchant_reference", $pesapalMerchantReference);
        $request_status->set_parameter("pesapal_transaction_tracking_id",$pesapalTrackingId);
        $request_status->sign_request($this->signature_method, $this->consumer, $this->token);

        $responseData = $this->curlRequest($request_status);

        $pesapalResponse = explode(",", $responseData);
        $pesapalResponseArray=array('pesapal_transaction_tracking_id'=>$pesapalResponse[0],
            'payment_method'=>$pesapalResponse[1],
            'status'=>$pesapalResponse[2],
            'pesapal_merchant_reference'=>$pesapalResponse[3]);

        return $pesapalResponseArray;
    }
    function checkStatusByMerchantRef($pesapalMerchantReference){

        $request_status = OAuthRequest::from_consumer_and_token(
            $this->consumer,
            $this->token,
            "GET",
            $this->QueryPaymentStatusByMerchantRef,
            $this->params
        );
        $request_status->set_parameter("pesapal_merchant_reference", $pesapalMerchantReference);
        $request_status->sign_request($this->signature_method, $this->consumer, $this->token);

        $status = $this->curlRequest($request_status);

        return $status;
    }

    function curlRequest($request_status){

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

        $response 					= curl_exec($ch);
        $header_size 				= curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $raw_header  				= substr($response, 0, $header_size - 4);
        $headerArray 				= explode("\r\n\r\n", $raw_header);
        $header 					= $headerArray[count($headerArray) - 1];

        //transaction status
        $elements = preg_split("/=/",substr($response, $header_size));
        $pesapal_response_data = $elements[1];

        return $pesapal_response_data;
    }
}
?>