@extends('layouts.master')

@section('content')

    <!-- Stats -->
    <div class="row">
        @can('masajid')
        <div class="col-6 col-md-3 col-lg-6 col-xl-3">
            <a class="block block-rounded block-link-pop border-left border-primary border-4x " style="background-color: #4765ab  !important"  href="{{url('admin/masajid-map-view')}}">
                <div class="block-content block-content-full">
                    <div class="font-size-sm font-w600  text-white">allMasajid</div>
                    <span class="font-size-h2 font-w400 text-white">{{$masajidCount}} <span class="float-right"><i class="fa fa-mosque "></i></span></span>
                </div>
            </a>
        </div>
        @endcan
        @can('announcements')
        <div class="col-6 col-md-3 col-lg-6 col-xl-3">
            <a class="block block-rounded block-link-pop border-left border-primary border-4x" style="background-color: #4765ab  !important"  href="{{url('admin/announcement')}}">
                <div class="block-content block-content-full">
                    <div class="font-size-sm font-w600 text-uppercase text-white">Announcements</div>
                    <div class="font-size-h2 font-w400 text-white">{{$announcementCount}}<span class="float-right"><i class="fa fa-bullhorn "></i></span></div>
                </div>
            </a>
        </div>
        @endcan
        @can('events')
        <div class="col-6 col-md-3 col-lg-6 col-xl-3">
            <a class="block block-rounded block-link-pop border-left border-primary border-4x" style="background-color: #4765ab  !important"  href="{{url('admin/events')}}">
                <div class="block-content block-content-full">
                    <div class="font-size-sm font-w600 text-uppercase text-white">Events</div>
                    <div class="font-size-h2 font-w400 text-white">{{$eventCount}}<span class="float-right"><i class="fa fa-calendar-alt "></i></span></div>
                </div>
            </a>
        </div>
        @endcan
        @can('user management')
        <div class="col-6 col-md-3 col-lg-6 col-xl-3">
            <a class="block block-rounded block-link-pop border-left border-primary border-4x" style="background-color: #4765ab  !important"  href="{{url('admin/user')}}">
                <div class="block-content block-content-full">
                    <div class="font-size-sm font-w600 text-uppercase text-white">Users</div>
                    <div class="font-size-h2 font-w400 text-white">{{$userCount}}<span class="float-right"><i class="fa fa-user "></i></span></div>
                </div>
            </a>
        </div>
        @endcan
{{--        @endhasrole--}}
    </div>
    <!-- END Stats -->

@endsection
