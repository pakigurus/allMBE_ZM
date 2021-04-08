@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                  Create Masjid
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
                    <form action="{{url('admin/masajid')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="example-ltf-email">Google Masjid ID</label>
                            <input type="text" required class="form-control" value="{{old('google_masajid_id')}}" id="example-ltf-email" name="google_masajid_id" >
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Masjid Name</label>
                            <input type="text" required class="form-control" value="{{old('name')}}" id="example-ltf-password" name="name" >
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Masjid Address</label>
                            <input type="text" required class="form-control" value="{{old('address')}}" id="example-ltf-password" name="address" >
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Masjid lat</label>
                            <input type="text" required class="form-control" value="{{old('lat')}}" id="example-ltf-password" name="lat" >
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Masjid lon</label>
                            <input type="text" required class="form-control" value="{{old('long')}}" id="example-ltf-password" name="long" >
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
