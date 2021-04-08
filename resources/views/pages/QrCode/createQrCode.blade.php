@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Generate QrCode
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-header"></div>
        <div class="block-content block-content-full">
            <form action="{{url('admin/qr-code/generate')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="example-ltf-password">URL<span style="color: red">*</span></label>
                    <input type="text"  class="form-control" name="url" required>
                </div>
                <div class="form-group">
                    <label for="example-ltf-password">Medium<span style="color: red">*</span></label>
                    <select name="media" id="" class="form-control">
                        <option value="icon-app.png">allMasajid</option>
                        <option value="fb-logo.png">facebook</option>
                        <option value="insta-logo.png">instagram</option>
                        <option value="twitter-logo.png">twitter</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit" >
                </div>
            </form>
        </div>
    </div>

@endsection
