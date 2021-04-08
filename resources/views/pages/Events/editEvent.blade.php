@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Edit Event
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <a href="{{ url('admin/events') }}" class="btn btn-primary btn-sm">Back</a>
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
                    <form action="{{url('admin/events/'.$events->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="example-ltf-email">Select Masjid/Non-Masajid <span style="color: red">*</span></label>
                            <div class="form-group">
                                <input type="search"  class="form-control" value="{{ $events->masajid->name}}" id="example-ltf-password" name="masajid"  readonly>
                                <input type="text"  class="form-control" value="{{ $events->masajid->google_masajid_id}}" id="example-ltf-password" name="google_masajid_id"  hidden>
                                @error('google_masajid_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Event Title <span style="color: red">*</span></label>
                            <input type="search"  class="form-control" value="{{old('title') . $events->title, 'Default' }}" id="example-ltf-password" name="title" >
                            @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Description</label>
                            <textarea name="description" maxlength="150"  class="form-control"  id="" cols="30" rows="3" style="resize: none">{{ $events->description}}</textarea>
                            @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="example-flatpickr-friendly">Date <span style="color: red">*</span></label>
                            <input type="text" class="js-flatpickr form-control bg-white" value="{{$events->date}}" id="example-flatpickr-friendly" name="date"  data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                            @error('date')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="example-flatpickr-time-standalone">Time <span style="color: red">*</span></label>
                            <input type="text" class="js-flatpickr form-control bg-white" value="{{$events->time}}" id="example-flatpickr-time-standalone" name="time" data-enable-time="true" data-no-calendar="true" data-date-format="H:i">
                            @error('time')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Contact <span style="color: red">*</span></label>
                            <input type="search"  class="form-control" value="{{$events->contact}}" id="example-ltf-password" name="contact" >
                            @error('contact')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Email <span style="color: red">*</span></label>
                            <input type="email"  class="form-control" value="{{$events->email}}" id="example-ltf-password" name="email" >
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Link </label>
                            <input type="text"  class="form-control" value="{{$events->link}}" id="example-ltf-password" name="link" >
                            @error('link')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Message</label>
                            <textarea name="message" maxlength="100"  class="form-control"  id="" cols="30" rows="2" style="resize: none">{{$events->message}}</textarea>
                            @error('message')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Address <span style="color: red">*</span></label>
                            <textarea name="address" maxlength="150"  class="form-control"  id="" cols="30" rows="2" style="resize: none">{{$events->address}}</textarea>
                            @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
                            <input type="hidden" name="hiddenImage" value="{{$events->image}}">
                        </div>
                        @if($events->image )
                        <div class="col-md-6  animated fadeIn">
                            <div class="options-container fx-item-rotate-r">
                                <img class="img-fluid options-item" src="{{asset('images/events/'.$events->image)}}" alt="">
                                <div class="options-overlay bg-black-75">
                                    <div class="options-overlay-content">
                                        <h3 class="h4 font-w400 text-white mb-1">{{$events->title}}</h3>
                                        <h4 class="h6 font-w400 text-white-75 mb-3">@php($events->date = date('F m Y', strtotime($events->date))){{$events->date}}</h4>
                                        <a class="btn btn-sm btn-primary img-lightbox" href="{{asset('images/events/'.$events->image)}}">
                                            <i class="fa fa-search-plus mr-1"></i> View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group mt-5 text-center">
                            <input type="submit" class="btn btn-primary" value="Submit" >
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
@endsection
