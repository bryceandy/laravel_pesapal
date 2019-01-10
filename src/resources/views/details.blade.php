<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <style>
        body{padding-top: 5%;}
        .ui.form{ max-width: 60%!important; margin-left: 20%!important;}
        h1{text-align: center}
        .ui.form .fields{display: block!important;}
        .field .inl{display: inline!important; width: 49.5%!important;}
    </style>

    <title>Payment Details</title>
</head>
<body>

<h1>Payment Details Form</h1>

<form action="/iframe" method="post">
    {{csrf_field()}}

    <div class="ui form">
        <div class="fields">
            <div class="field">
                <label>First name</label>
                <input type="text" name="first_name" required>
            </div>

            <div class="field">
                <label>Last name</label>
                <input type="text" name="last_name" required>
            </div>

            <div class="field">
                <label>Email</label>
                <input type="text" name="email" required>
            </div>

            <div class="field">
                <label>Amount</label>
                <input type="number" name="amount" class="inl" required>
                <select name="currency" id="currency" class="ui search dropdown inl">
                    <option value="TZS">Tanzanian Shillings</option>
                    <option value="KES">Kenyan Shillings</option>
                    <option value="UGX">Ugandan Shillings</option>
                    <option value="USD">US Dollars</option>
                </select>
            </div>

            <div class="field">
                <label>Description</label>
                <input type="text" name="description" required>
            </div>

            <div class="field">
                <label>Reference</label>
                {{--You will need to make this automatically generated for each payment don't use the same value--}}
                <input type="text" name="reference" required>
            </div>

            <div class="field">
                <label>Phone Number</label>
                {{--It is required to begin automatically with the country code i.e 254, 255 or 256--}}
                <input type="text" name="phone" placeholder="example...255784100200" required>
            </div>

            {{--Do not change this MERCHANT value--}}
            <input type="hidden" name="type" value="MERCHANT" readonly="readonly" /><br>

            <button class="ui animated button" type="submit" tabindex="0">
                <span class="visible content">Next</span>
                <span class="hidden content">
                    <i class="right arrow icon"></i>
                </span>
            </button>
        </div>
    </div>

</form>

<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
</body>
</html>