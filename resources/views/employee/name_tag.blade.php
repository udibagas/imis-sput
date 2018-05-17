<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Name tag</title>
    </head>
    <style media="all">
        .name-tag-container {
            font-family: 'Arial';
            max-height: 85.60mm;
            max-width: 53.98mm;
            min-height: 85.60mm;
            min-width: 53.98mm;
            height: 85.60mm;
            width: 53.98mm;
            margin: 1mm;
            padding: 2mm;
            border: 1px solid #ccc;
            border-radius: 2mm;
            text-align: center;
            display: inline-block;
        }
    </style>
    <body>
        @foreach ($employees as $e)
        <div class="name-tag-container">

            <img src="{{asset("img/logo.png")}}" alt="" style="width:30mm;display:block;margin:3mm auto 2mm;">

            <div style="font-size:11px;font-weight:bold;">PT KALIMANTAN PRIMA PERSADA</div>
            <div style="font-size:12px;">DISTRIK SUNGAI PUTING</div>

            {!!$e->qrCode!!}

            <div style="font-size:14px;">{{$e->nrp}}</div>

            <div style="margin-top:2mm;">
                <div style="font-size:16px;font-weight:bold;">{{$e->name}}</div>
            </div>

            <div style="margin:5mm 0;">
                <div style="font-size:10px;font-weight:bold;">
                    {{$e->position->name}}
                </div>
                <div style="font-size:11px;">
                    DEPT: {{strtoupper($e->department->name)}}
                </div>
                <!-- <div style="font-size:10px;margin-top:2mm;color:red;">
                    VALID UNTIL: 20-OCT-2065
                </div> -->
            </div>

        </div>
        @endforeach
    </body>
</html>
