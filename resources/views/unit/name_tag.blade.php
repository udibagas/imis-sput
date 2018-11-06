<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Unit Name Tag</title>
    </head>
    <style media="all">
        .name-tag-container {
            font-family: 'Arial';
            max-height: 60mm;
            max-width: 60mm;
            min-height: 60mm;
            min-width: 60mm;
            height: 60mm;
            width: 60mm;
            margin: 1mm;
            padding: 2mm;
            border: 1px solid #ccc;
            border-radius: 2mm;
            text-align: center;
            display: inline-block;
        }
    </style>
    <body>
        @foreach ($units as $e)
        <div class="name-tag-container">

            <!-- <img src="{{asset("img/logo.png")}}" alt="" style="width:30mm;display:block;margin:3mm auto 2mm;">

            <div style="font-size:11px;font-weight:bold;">PT KALIMANTAN PRIMA PERSADA</div>
            <div style="font-size:12px;">DISTRIK SUNGAI PUTING</div> -->

            {!!$e->qrCode!!}

            <div style="font-size:14px;">{{$e->nrp}}</div>

            <div>
                <div style="font-size:16px;font-weight:bold;">{{$e->name}}</div>
                <div style="font-size:10px;font-weight:bold;">
                    {{$e->egi->name}}
                </div>
            </div>

        </div>
        @endforeach
    </body>
</html>
