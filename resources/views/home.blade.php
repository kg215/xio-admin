<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>说好的惊喜呢</title>
    <link href="https://cdn.bootcss.com/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="{{ \Illuminate\Support\Facades\URL::asset('public/images/logo.png') }}" sizes="192x192" type="img/png" />
    <link href="{{ \Illuminate\Support\Facades\URL::asset('public/home/css/home.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="home"></div>
</body>

<script src="{{ \Illuminate\Support\Facades\URL::asset('public/home/js/home.js') }}"></script>
</html>
