@extends('layouts.master')
@section('content')
    <form id="upload-form" action="{{route('video.postUpload')}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="Description">
        </div>
        <ul id="filelist"></ul>
        <br />

        <div class="form-group">
                <a id="browse" href="javascript:;">[Browse...]</a>
                <a id="start-upload" href="javascript:;">[Start Upload]</a>
        </div>
        <hr />
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
@endsection
@section('footer')
    <script src="{{appElixir('plupload/js/plupload.full.min.js')}}"></script>
    <script type="text/javascript">
        var uploader = new plupload.Uploader({
            browse_button: 'browse', // this can be an id of a DOM element or the DOM element itself
            runtimes: 'flash',
            // Flash settings
            flash_swf_url: '/plupload/js/Moxie.swf',
            // Silverlight settings
            silverlight_xap_url: '/plupload/js/Moxie.xap',

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '{{$uploadUrl}}',
            init: {

                FileUploaded: function (up, file, response) {
                    var response = JSON.parse(response.response);
                    var videoId = response.result.video_id;
                    var fileName = response.result.file_name;
                    var videoIdInput = "<input type=hidden name='video_id' value='" + videoId + "' />";
                    var fileNameInput = "<input type=hidden name='file_name' value='" + fileName + "' />";
                    $('#upload-form').append(videoIdInput + fileNameInput);
                },

                QueueChanged: function(up) {
                    if(up.files.length > 1)
                    {
                        up.noAppend = true;
                        up.files.splice(1, up.files.length);

                        alert('You can not add more than one file!');
                    }
                }
            }
        });

        uploader.init();

        uploader.bind('FilesAdded', function(up, files) {
            if (! up.noAppend) {
                var html = '';
                plupload.each(files, function(file) {
                    html += '<li id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></li>';
                });
                document.getElementById('filelist').innerHTML += html;
            }
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
