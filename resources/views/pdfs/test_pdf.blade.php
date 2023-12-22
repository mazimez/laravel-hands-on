<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test PDF</title>
</head>
<style>
    .page-break {
        page-break-after: always;
    }
    </style>
<body>
<h1>Page 1</h1>
    <p>This is test PDF generated with <b>barryvdh/laravel-dompdf</b></p>
    <p>This is custome data <b>{{ $data }}</b></p>
<div class="page-break"></div>
<h1>Page 2</h1>
    <p>this is data for page-2</p>
</body>
</html>
