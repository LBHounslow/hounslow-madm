@extends('layouts/app')

@section('title')
    Upload Data File
@endsection

@section('content')

    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="/upload/store">
        {{ csrf_field() }}


        <div class="form-group{{ $errors->has('fileType') ? ' has-error' : '' }}">
            <label for="fileType" class="col-md-4 control-label">File Type</label>

            <div class="col-md-6">
                <select class="form-control" name="fileType" id="fileType" required>
                    @foreach($fileTypes as $fileType)
                        @if(in_array($fileType->code, Auth::user()->getAllowedFileTypes()))
                            <option value="{{ $fileType->code }}">{{ $fileType->display_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <hr>
        <div class="form-group">
            <label for="uploadFile" class="col-md-4 control-label">File input</label>
            <div class="col-md-6">
                <input type="file" id="uploadFile" name="uploadFile" required>
                <p class="help-block">Upload data file</p>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">

                <button type="submit" class="btn btn-primary">
                    Upload
                </button>

                <a href="/">
                    <button type="button" class="btn btn-default">Cancel</button>
                </a>

            </div>
        </div>
    </form>

@endsection
