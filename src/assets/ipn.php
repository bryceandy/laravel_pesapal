<?php

use Bryceandy\Laravel_Pesapal\OAuth\CheckStatus;
use Bryceandy\Laravel_Pesapal\Payment;

$checkStatus = new CheckStatus();
$pesapalMerchantReference = $_GET['pesapal_merchant_reference'] ?? null;
$pesapalTrackingId = $_GET['pesapal_transaction_tracking_id'] ?? null;
$pesapalNotification = $_GET['pesapal_notification_type'] ?? null;
$transactionDetails	= $checkStatus->getTransactionDetails($pesapalMerchantReference, $pesapalTrackingId);

//Update database
$value	= [
    "COMPLETED" => "Paid",
    "PENDING" => "Pending",
    "INVALID" => "Cancelled",
    "FAILED" => "Cancelled",
];

$status	= $value[$transactionDetails['status']];

$updateStatus = Payment::modify($transactionDetails);

$dbUpdate = $updateStatus ? "True" : 'False';

//test if IPN runs on status change
$to      = '';
$subject = 'IPN: '.$pesapalNotification;
$message = '<b>Merchant Reference: </b>'.$pesapalMerchantReference.'<br> ';
$message .= '<b>Tracking ID: </b>'.$pesapalTrackingId.'<br> ';
$message .= '<b>Payment Method: </b>'.$transactionDetails['payment_method'].'<br> ';
$message .= '<b>Database update: </b>'.$dbUpdate.'<br> ';
$headers = 'From: ipntester@pesapal.com' . "\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n".
    'Reply-To: '.config('laravel_pesapal.ipn_notifications_email') . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

//If there was a status change and you updated your db successfully && the change is not to a Pending state
if($pesapalNotification == "CHANGE"){

    //Notify me when the IPN for this transaction is killed
    $to      = '';
    $subject = 'IPN Killer';
    $message = '<b>Merchant Reference: </b>'.$pesapalMerchantReference.'<br> ';
    $message .= '<b>Tracking ID: </b>'.$pesapalTrackingId.'<br> ';
    $message .= '<b>Status: </b>'.$status.'<br> ';
    $headers = 'From: ipntester@pesapal.com' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n".
        'Reply-To: '.config('laravel_pesapal.ipn_notifications_email') . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    $resp	= "pesapal_notification_type=$pesapalNotification".
        "&pesapal_transaction_tracking_id=$pesapalTrackingId".
        "&pesapal_merchant_reference=$pesapalMerchantReference";

    ob_start();
    echo $resp;
    ob_flush();
    exit; //this is mandatory. If you dont exit, Pesapal will not get your response.
}
