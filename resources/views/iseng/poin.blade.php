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
        @foreach ($poins as $p)
        <div class="name-tag-container">
            {!!$p!!}
        </div>
        @endforeach
    </body>
</html>
