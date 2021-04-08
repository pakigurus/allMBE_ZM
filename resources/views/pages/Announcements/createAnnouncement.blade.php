@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Add Announcement
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
                    <form action="{{url('admin/announcement')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="example-ltf-email">Select Masjid <span style="color: red">*</span></label>
                            <div class="form-group">
                                <select class="js-select2 form-control" id="example-select2" name="google_masajid_id"  style="width: 100%;" data-placeholder="Choose one..">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach($masajids as $masjid)
                                        <option value="{{$masjid->google_masajid_id}}">{{$masjid->name}}</option>
                                    @endforeach
                                </select>
                                @error('google_masajid_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Title <span style="color: red">*</span></label>
                            <input type="text"  class="form-control" value="{{old('title')}}" id="example-ltf-password" name="title" >
                            @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Description</label>
                            <textarea name="description" maxlength="150"  class="form-control"  id="" cols="30" rows="3" style="resize: none">{{old('description')}}</textarea>
                            @error('description')
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

                        <div class="form-group">
                            <label for="example-ltf-password">Contact <span style="color: red">*</span></label>
                            <input type="text"  class="form-control" value="{{old('contact')}}" id="example-ltf-password" name="contact" >
                            @error('contact')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="custom-file">
                                <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                <input type="file" class="custom-file-input" data-toggle="custom-file-input" id="example-file-input-custom" name="image">
                                <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                            </div>
                        </div>
                        @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

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
