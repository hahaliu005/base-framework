<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}"/>
    <script type="text/javascript" href="{{elixir('js/app.js')}}" ></script>
    @yield('header-css')
</head>
<body>
@include('vendor.sidebar')
@include('vendor.header')
@yield('content')
</body>
</html>
