@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content ">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Edit User
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-header"></div>
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-md-6 offset-3">
                    <form action="{{url('admin/user/'.$users->id)}}"class="js-validation" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="example-ltf-password">First Name <span style="color: red">*</span></label>
                            <input type="text"  class="form-control" value="{{$users->first_name}}" id="example-ltf-password" name="first_name" >
                            @error('first_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Last Name <span style="color: red">*</span></label>
                            <input type="text"  class="form-control" value="{{$users->last_name}}" id="example-ltf-password" name="last_name" >
                            @error('last_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Email <span style="color: red">*</span></label>
                            <input type="email"  class="form-control" value="{{$users->email}}" id="example-ltf-password" name="email" >
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit" >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
@endsection
