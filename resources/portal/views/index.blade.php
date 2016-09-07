@extends('layouts.master')

<link href="{{appElixir('css/index.css')}}" rel="stylesheet">

@section('content')
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1" class=""></li>
            <li data-target="#myCarousel" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Example headline.</h1>
                        <p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p>
                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Another example headline.</h1>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>One more for good measure.</h1>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
                    </div>
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="container video-list">
        <h3>New videos</h3>
        <hr>
        <ul>
            @foreach($newVideos as $video)
                <li>
                    <dl>
                        <dt>
                            <a href="{{route('video.play', [$video->id])}}">
                                <img src="{{$video->thumbHref()}}">
                            </a>
                            <div class="mask-layer">
                                <div class="mask-layer-left">
                                    {{$video->created_at}}
                                </div>
                                <div class="mask-layer-right">
                                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                    {{$video->durationReadable()}}
                                </div>
                            </div>
                        </dt>
                        <dd><a>{{$video->title}}</a></dd>
                    </dl>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="container video-list">
        <h3>New videos</h3>
        <hr>
        <ul>
            @foreach($newVideos as $video)
                <li>
                    <dl>
                        <dt>
                            <a href="#">
                                <img src="{{$video->thumbHref()}}">
                            </a>
                        <div class="mask-layer">
                            <div class="mask-layer-left">
                                {{$video->created_at}}
                            </div>
                            <div class="mask-layer-right">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                {{$video->durationReadable()}}
                            </div>
                        </div>
                        </dt>
                        <dd><a>{{$video->title}}</a></dd>
                    </dl>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

@section('footer')
@endsection
