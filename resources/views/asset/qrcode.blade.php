<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Asset QR Code</title>
    </head>
    <style media="all">
        .qrcode-container {
            font-family: 'Arial';
            max-height: 40mm;
            max-width: 40mm;
            min-height: 40mm;
            min-width: 40mm;
            height: 40mm;
            width: 40mm;
            margin: 1mm;
            padding: 2mm;
            border: 1px solid #ccc;
            border-radius: 2mm;
            text-align: center;
            display: inline-block;
        }
    </style>
    <body>
        @foreach ($assets as $a)
        <div class="qrcode-container">
            {!!$a->qrCode!!}
            <strong>{{$a->reg_no}}</strong><br>
            <small>{{$a->name}}</small>
        </div>
        @endforeach
    </body>
</html>
