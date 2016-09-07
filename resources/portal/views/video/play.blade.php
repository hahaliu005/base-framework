@extends('layouts.master')

<link href="{{appElixir('css/play.css')}}" rel="stylesheet">

@section('content')
    <div class="container main-play">
        <div class="container main-play-left">
            <div class="container title">
                <h4>title</h4>
            </div>
            <div class="container play-window">
                play-window
            </div>
            <div class="container description">

                description
            </div>
            <div class="container info">
                info
            </div>

        </div>
        <div class="container main-play-recommend">
            recommend
        </div>
    </div>
@endsection

@section('footer')
@endsection
