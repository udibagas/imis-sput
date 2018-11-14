<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Name tag</title>
    </head>
    <style media="all">
        .name-tag-container {
            font-family: 'Arial';
            max-height: 40mm;
            max-width: 120mm;
            min-height: 40mm;
            min-width: 120mm;
            height: 40mm;
            width: 120mm;
            margin: 1mm;
            padding: 2mm;
            border: 2px solid #ccc;
            /* border-radius: 2mm; */
            /* text-align: center; */
            display: inline-block;
        }
    </style>
    <body>
        @foreach ($employees as $e)
        <div class="name-tag-container">
            <div style="display:inline-block;float:left;width:120px;">
                {!!$e->qrCode!!}
                <div style="font-size:16px;font-weight:bold;text-align:center;">{{$e->nrp}}</div>
            </div>
            <div style="font-weight:bold;display:inline-block;margin:20px;text-align:center;">
                <span style="font-size:20px;">FAMILY GATHERING 2018</span> <br>
                PT. KALIMANTAN PRIMA PERSADA <br>
                <div style="font-size:16px;margin-top:25px;">
                    <i>"Bersatu Kita Teguh"</i>
                </div>
            </div>
        </div>
        @endforeach
    </body>
</html>
