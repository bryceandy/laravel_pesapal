<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <style>
        body{padding: 5%;}
        h1{text-align: center;}
        ul li a{text-decoration: none}
        ul li{list-style-type: disc}
    </style>
    <title>Payment Status</title>
</head>
<body>

    <h1>Status of Payment</h1>

    <ul>
        {{--the status change will happen only if you put your IPN settings on the dashboard--}}
        <li>Your payment status is currently {{$status}}</li>
        <li>The merchant reference is {{$pesapalMerchantReference}}</li>
        <li><a href="/callback">REFRESH</a> to reveiew your current payment status!</li>
    </ul>

</body>
</html>