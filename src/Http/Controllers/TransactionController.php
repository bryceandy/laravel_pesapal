<?php
namespace Bryceandy\Laravel_Pesapal\Http\Controllers;

use App\Http\Controllers\Controller;
use Bryceandy\Laravel_Pesapal\Pesapal\pesapalCheckStatus;
use Bryceandy\Laravel_Pesapal\Models\Transaction;
use Bryceandy\Laravel_Pesapal\Pesapal\OAuthSignatureMethod_HMAC_SHA1;
use Bryceandy\Laravel_Pesapal\Pesapal\OAuthConsumer;
use Bryceandy\Laravel_Pesapal\Pesapal\OAuthRequest;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function details()
    {
        return view ('laravel_pesapal::details');
    }

    public function payment(Request $request)
    {
        //pesapal params
        $token = $params = NULL;
        $consumer_key 		= env('PESAPAL_KEY');
        $consumer_secret 	= env('PESAPAL_SECRET');

        $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

        if(config('laravel_pesapal.is_key') == 'true')
        {
            $iframelink = 'https://www.pesapal.com/api/PostPesapalDirectOrderV4';
        }
        else
        {
            $iframelink = 'https://demo.pesapal.com/api/PostPesapalDirectOrderV4';
        }

        //get form details
        $amount = intval(number_format($request->amount, 0));
        $currency = $request->currency;
        $desc = $request->description;
        $type = $request->type;
        $reference = $request->reference;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $phonenumber = $request->phone;

        $callback_url = config('laravel_pesapal.callback_url');

        //storing into the database
        Transaction::make($first_name, $last_name, $email, $amount, $currency, $desc, $reference, $phonenumber);

        /*Do not touch this xml variable in any way as it is the source of errors when you try
        to be clever and add extra spaces inside it*/
        $post_xml	= "<?xml version=\"1.0\" encoding=\"utf-8\"?>
				   <PesapalDirectOrderInfo 
						xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" 
					  	xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" 
					  	Currency=\"".$currency."\" 
					  	Amount=\"".$amount."\" 
					  	Description=\"".$desc."\" 
					  	Type=\"".$type."\" 
					  	Reference=\"".$reference."\" 
					  	FirstName=\"".$first_name."\" 
					  	LastName=\"".$last_name."\" 
					  	Email=\"".$email."\" 
					  	PhoneNumber=\"".$phonenumber."\" 
					  	xmlns=\"http://www.pesapal.com\" />";
        $post_xml = htmlentities($post_xml);

        $consumer = new OAuthConsumer($consumer_key, $consumer_secret);

        //post transaction to pesapal
        $iframe_src = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $iframelink, $params);
        $iframe_src->set_parameter("oauth_callback", $callback_url);
        $iframe_src->set_parameter("pesapal_request_data", $post_xml);
        $iframe_src->sign_request($signature_method, $consumer, $token);

        return view ('laravel_pesapal::iframe', compact('iframe_src'));
    }

    public function callback()
    {
        $pesapalMerchantReference	= null;
        $pesapalTrackingId 		    = null;
        $checkStatus 				= new pesapalCheckStatus();

        if(isset($_GET['pesapal_merchant_reference']))
            $pesapalMerchantReference = $_GET['pesapal_merchant_reference'];

        if(isset($_GET['pesapal_transaction_tracking_id']))
            $pesapalTrackingId = $_GET['pesapal_transaction_tracking_id'];

        //obtaining the payment status after a payment
        $status = $checkStatus->checkStatusUsingTrackingIdandMerchantRef($pesapalMerchantReference,$pesapalTrackingId);

        //display the reference and payment status on the callback page
        return view ('laravel_pesapal::callback_example', compact('pesapalMerchantReference', 'status'));
    }
}
