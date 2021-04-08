@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Add FAQ
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
                    <form action="{{url('admin/faq')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="example-ltf-password">Question</label>
                            <textarea class="js-maxlength form-control" id="example-maxlength10" name="question" rows="5" maxlength="300"  data-always-show="true" style="resize: none"></textarea>

                            @error('question')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Answer</label>
                            <textarea class="js-maxlength form-control" id="example-maxlength10" name="answer" rows="5" maxlength="300"  data-always-show="true" style="resize: none"></textarea>
                            @error('answer')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="example-ltf-password">Module</label>
                            <select name="module" id="" class="form-control">
                                <option value=""></option>
                                <option value="settings">Settings</option>
                                <option value="dua">Dua</option>
                                <option value="announcement">Announcements</option>
                                <option value="events">Events</option>
                                <option value="iqamah">Iqamah</option>
                                <option value="my_masajid">My Masajid</option>
                                <option value="nearby_masajid">Masajid Nearby</option>
                                <option value="qibla">Qiblah Direction</option>
                                <option value="islamic_calendar">Islamic Calendar</option>
                                <option value="prayer_timing">Prayer Timing</option>
                                <option value="dua_appeals">Dua Appeals</option>
                                <option value="contribute">Contribute</option>
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
