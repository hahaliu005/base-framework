
@include('vendor.header')

<?php
$sidebar = [
        '我的视频' => [
                route('video.getUpload') => '上传视频',
                route('video.list') => '视频列表',
        ],
        '高级管理' => [
        ],
        '配置管理' => [

        ],
        '系统设置' => [
                route('index') => '账号管理',
                route('index') => '角色管理',
                route('index') => '账号管理',
        ]

];
$currentUrl = \Request::url();
?>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">{{\Auth::user()->name}}</a></li>
                <li><a href="{{route('logout')}}">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $groupIndex = 1; ?>
            @foreach($sidebar as $groupName => $navs)
                <?php
                    $collapsed = isset($navs[$currentUrl]) ? false : true;
                        ?>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" class="{{$collapsed ? 'collapsed' : ''}}" href="#collapse{{$groupIndex}}">{{$groupName}}</a>
                            </h4>
                        </div>
                        <div id="collapse{{$groupIndex}}" aria-expanded="{{$collapsed ? 'false' : 'true'}}" class="panel-collapse collapse {{$collapsed ? '' : 'in'}}">
                            <ul class="list-group">
                                @foreach($navs as $navUrl => $navName)
                                    <a href="{{$navUrl}}"><li class="list-group-item {{$currentUrl == $navUrl ? 'active' : ''}}">{{$navName}}</li></a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <?php $groupIndex ++ ?>
            @endforeach
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                @yield('content')
        </div>
    </div>
</div>

@include('vendor.footer')
@yield('footer')
</body>
</html>
