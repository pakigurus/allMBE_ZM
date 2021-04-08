@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Add FAQ
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <a href="{{ url('admin/faq') }}" class="btn btn-primary btn-sm">Back</a>
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
                    <form action="{{url('admin/faq/'.$faq->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="example-ltf-password">Question</label>
                            <textarea class="js-maxlength form-control" id="example-maxlength10" name="question" rows="5" maxlength="300"  data-always-show="true" style="resize: none">{{$faq->question}}</textarea>

                            @error('question')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Answer</label>
                            <textarea class="js-maxlength form-control" id="example-maxlength10" name="answer" rows="5" maxlength="300"  data-always-show="true" style="resize: none">{{$faq->answer}}</textarea>
                            @error('answer')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Module</label>
                            <select name="module" id="" class="form-control">
                                <option value=""></option>
                                <option value="settings" @if($faq->module == "settings") selected @endif>Settings</option>
                                <option value="dua" @if($faq->module == "dua") selected @endif>Dua</option>
                                <option value="announcement" @if($faq->module == "announcement") selected @endif>Announcements</option>
                                <option value="events" @if($faq->module == "events") selected @endif>Events</option>
                                <option value="iqamah" @if($faq->module == "iqamah") selected @endif>Iqamah</option>
                                <option value="my_masajid" @if($faq->module == "my_masajid") selected @endif>My Masajid</option>
                                <option value="nearby_masajid" @if($faq->module == "nearby_masajid") selected @endif>Masajid Nearby</option>
                                <option value="qibla" @if($faq->module == "qibla") selected @endif>Qiblah Direction</option>
                                <option value="islamic_calendar" @if($faq->module == "islamic_calendar") selected @endif>Islamic Calendar</option>
                                <option value="prayer_timing" @if($faq->module == "prayer_timing") selected @endif>Prayer Timimg</option>
                                <option value="dua_appeals" @if($faq->module == "dua_appeals") selected @endif>Dua Appeals</option>
                                <option value="contribute" @if($faq->module == "contribute") selected @endif>Contribute</option>
                            </select>
                            @error('iqama')
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
