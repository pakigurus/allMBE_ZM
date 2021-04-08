@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content ">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                   Add User
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
                    <form action="{{url('admin/user')}}" class="js-validation" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="example-ltf-password">First Name <span style="color: red">*</span></label>
                            <input type="text"  class="form-control" value="{{old('first_name')}}" id="example-ltf-password" name="first_name" >
                            @error('first_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Last Name <span style="color: red">*</span></label>
                            <input type="text"  class="form-control" value="{{old('last_name')}}" id="example-ltf-password" name="last_name" >
                            @error('last_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Email <span style="color: red">*</span></label>
                            <input type="email"  class="form-control" value="{{old('email')}}" id="example-ltf-password" name="email" >
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="custom-control custom-checkbox custom-control-success custom-control-lg mb-3">
                            <input type="checkbox" class="custom-control-input" id="example-cb-custom-success-lg1" name="is_masajid">
                            <label class="custom-control-label" for="example-cb-custom-success-lg1">Masajid User</label>
                        </div>
                        <div class="form-group">
                            <label for="val-password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="val-password" name="val-password" placeholder="Choose a safe one..">
                        </div>
                        <div class="form-group">
                            <label for="val-confirm-password">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="val-confirm-password" name="val-confirm-password" placeholder="..and confirm it!">
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
