@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Create Event
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <button class="btn btn-primary" onclick="toggleMasajid()">Toggle Masajid/Non-Masajid</button>
                    </ol>
                </nav>
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
                    <form action="{{url('admin/events')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group masajid">
                            <label for="example-ltf-email">Select Masjid <span style="color: red">*</span></label>
                            <div class="form-group">
                                <select class="js-select2 form-control" id="example-select1" name="google_masajid_id"  style="width: 100%;" data-placeholder="Choose one..">
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

                        <div class="form-group non-masajid" style="display: none">
                            <label for="example-ltf-email">Select Non-Masjid <span style="color: red">*</span></label>
                            <div class="form-group">
                                <select class="js-select2 form-control" id="example-select2" name=""  style="width: 100%;" data-placeholder="Choose one..">
                                    <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach($non_masajids as $masjid)
                                        <option value="{{$masjid->google_masajid_id}}">{{$masjid->name}}</option>
                                    @endforeach
                                </select>
                                @error('google_masajid_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Event Title <span style="color: red">*</span></label>
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
                        <div class="form-group ">
                                <label for="example-flatpickr-friendly">Date <span style="color: red">*</span></label>
                                <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-friendly" name="date"  data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                                @error('date')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        <div class="form-group ">
                                <label for="example-flatpickr-time-standalone">Time <span style="color: red">*</span></label>
                                <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-time-standalone" name="time" data-enable-time="true" data-no-calendar="true" data-date-format="H:i">
                                @error('time')
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
                            <label for="example-ltf-password">Email <span style="color: red">*</span></label>
                            <input type="email"  class="form-control" value="{{old('email')}}" id="example-ltf-password" name="email" >
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Link </label>
                            <input type="text"  class="form-control" value="{{old('link')}}" id="example-ltf-password" name="link" >
                            @error('link')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Message</label>
                            <textarea name="message" maxlength="100"  class="form-control"  id="" cols="30" rows="2" style="resize: none">{{old('message')}}</textarea>
                            @error('message')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Address <span style="color: red">*</span></label>
                            <textarea name="address" maxlength="150"  class="form-control"  id="" cols="30" rows="2" style="resize: none">{{old('address')}}</textarea>
                            @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
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
