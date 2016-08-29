
@include('vendor.header')

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
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse1">Uploads</a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                        <ul class="list-group">
                            <a href="{{route('video.getUpload')}}"><li class="list-group-item active">Upload Video</li></a>
                            <li class="list-group-item">Two</li>
                            <li class="list-group-item">Three</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse2">Collapsible list group</a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <ul class="list-group">
                            <li class="list-group-item">One</li>
                            <li class="list-group-item">Two</li>
                            <li class="list-group-item">Three</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse3">Collapsible list group</a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                        <ul class="list-group">
                            <li class="list-group-item">One</li>
                            <li class="list-group-item">Two</li>
                            <li class="list-group-item">Three</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse4">Collapsible list group</a>
                        </h4>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse">
                        <ul class="list-group">
                            <li class="list-group-item">One</li>
                            <li class="list-group-item">Two</li>
                            <li class="list-group-item">Three</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse5">Collapsible list group</a>
                        </h4>
                    </div>
                    <div id="collapse5" class="panel-collapse collapse">
                        <ul class="list-group">
                            <li class="list-group-item">One</li>
                            <li class="list-group-item">Two</li>
                            <li class="list-group-item">Three</li>
                        </ul>
                    </div>
                </div>
            </div>
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
