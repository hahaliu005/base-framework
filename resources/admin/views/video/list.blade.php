@extends('layouts.master')
@section('content')
    <hr>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Status</th>
                <th>Created_at</th>
                <th>Operation</th>
            </tr>
        </thead>
        @foreach ($videos as $video)
            <tr>
                <td>{{$video->id}}</td>
                <td>{{$video->title}}</td>
                <td>{{$video->status}}</td>
                <td>{{$video->created_at}}</td>
                <td>
                    <a class="btn btn-primary" href="{{route('video.publish', ['id' => $video->id])}}" role="button">Publish</a>
                    <a class="btn btn-success" href="#" role="button">Edit</a>
                    <a class="btn btn-danger" href="#" role="button">Delete</a>
                </td>
            </tr>
        @endforeach
    </table>
    {{$videos->links()}}
@endsection
@section('footer')
@endsection
