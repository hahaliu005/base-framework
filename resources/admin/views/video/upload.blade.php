@extends('layouts.master')
@section('content')
    <ul id="filelist"></ul>
    <br />

    <div id="container">
        <a id="browse" href="javascript:;">[Browse...]</a>
        <a id="start-upload" href="javascript:;">[Start Upload]</a>
    </div>

    <br />
    <pre id="console"></pre>
@endsection
@section('footer')
    <script src="{{appElixir('plupload/js/plupload.full.min.js')}}"></script>
    <script type="text/javascript">
        var uploader = new plupload.Uploader({
            browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '{{route('video.uploading')}}'
        });

        uploader.init();

        uploader.bind('FilesAdded', function(up, files) {
            var html = '';
            plupload.each(files, function(file) {
                html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
            });
            document.getElementById('filelist').innerHTML += html;
        });

        uploader.bind('UploadProgress', function(up, file) {
            document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        });

        uploader.bind('Error', function(up, err) {
            document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
        });

        document.getElementById('start-upload').onclick = function() {
            uploader.start();
        };
    </script>
@endsection
