<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{appElixir('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{appElixir('css/bootstrap-theme.min.css')}}"/>
    <script type="text/javascript" href="{{appElixir('js/jquery.min.js')}}" ></script>
    <script type="text/javascript" href="{{appElixir('js/bootstrap.min.js')}}" ></script>
    <link rel="stylesheet" href="{{appElixir('css/app.css')}}"/>
    @yield('header-css')
</head>
<body>
    <div id="header">
        @include('vendor.header')
    </div>
    <div class="container-fluid">
        <div class="row">
            <div id="sidebar" class="col-sm-3 col-md-2 sidebar">
                @include('vendor.sidebar')
            </div>
            <div id="content" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
