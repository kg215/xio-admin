<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>kaxio的后台</title>
    <link rel="icon" href="{{ \Illuminate\Support\Facades\URL::asset('public/images/logo.png') }}" sizes="192x192" type="img/png" />
    <link href="{{ \Illuminate\Support\Facades\URL::asset('public/admin/css/admin.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ \Illuminate\Support\Facades\URL::asset('public/common/css/common.css') }}" rel="stylesheet" type="text/css" />

    <script>
        window.locale = '<?php echo app()->getLocale() ?>';
    </script>
</head>
<body>
<div id="admin"></div>
</body>
<script src="{{ \Illuminate\Support\Facades\URL::asset('public/admin/js/admin.js') }}"></script>
</html>
