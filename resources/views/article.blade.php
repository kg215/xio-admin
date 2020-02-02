<!DOCTYPE html>
<html lang="en"  lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon " type="images/x-icon" href="/favicon64.ico">
    <title>xio的小破站</title>
    <link href="{{ \Illuminate\Support\Facades\URL::asset('public/web/style/article.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="root"></div>
    <div id="modal"></div>
</body>
<script src="{{ \Illuminate\Support\Facades\URL::asset('public/web/article.js') }}"></script>
</html>
