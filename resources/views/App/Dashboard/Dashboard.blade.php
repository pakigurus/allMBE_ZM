@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="d-flex bd-highlight">
            <div class="flex-grow-1 bd-highlight">
                <h3>
                    {{\Carbon\Carbon::parse($wfd['today']->gregorian->date)->format('d-M-Y')}} /
                    {{$wfd['today']->hijri->day.' '.$wfd['today']->hijri->month->ar}}
                </h3>
            </div>
            <div class="bd-highlight">
                <h3>
                WhiteFasting Days :
                    @foreach($wfd['wfd'] as $key => $val)
                        {{' '.$val->gregorian->day . ' '. $val->gregorian->month->en }}
                        {{($key < count($wfd['wfd'])-1) ? ',' : ""}}
                    @endforeach
                </h3>
            </div>
        </div>
    </div>

    <div class="row">
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x " style="background-color: #4765ab  !important"  href="{{url('')}}">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600  text-white">Prayer Times</div>
                        <span class="font-size-h2 font-w400 text-white">.<span class="float-right"><i class="fa fa-clock "></i></span></span>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" style="background-color: #4765ab  !important"  href="{{url('')}}">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-white">Masajid NearBy</div>
                        <div class="font-size-h2 font-w400 text-white">.<span class="float-right"><i class="fa fa-mosque "></i></span></div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" style="background-color: #4765ab  !important"  href="{{url('')}}">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-white">Iqamah</div>
                        <div class="font-size-h2 font-w400 text-white">.<span class="float-right"><i class="fa fa-pray "></i></span></div>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" style="background-color: #4765ab  !important"  href="{{url('')}}">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-white">Events</div>
                        <div class="font-size-h2 font-w400 text-white">.<span class="float-right"><i class="fa fa-calendar-alt "></i></span></div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" style="background-color: #4765ab  !important"  href="{{url('')}}">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-white">Announcements</div>
                        <div class="font-size-h2 font-w400 text-white">.<span class="float-right"><i class="fa fa-calendar-alt"></i></span></div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" style="background-color: #4765ab  !important"  href="{{url('')}}">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-white">Islamic Calendar</div>
                        <div class="font-size-h2 font-w400 text-white">.<span class="float-right"><i class="fa fa-calendar-alt"></i></span></div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" style="background-color: #4765ab  !important"  href="{{url('')}}">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-white">Supplications</div>
                        <div class="font-size-h2 font-w400 text-white">.<span class="float-right"><i class="fa fa-praying-hands "></i></span></div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" style="background-color: #4765ab  !important"  href="{{url('')}}">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-white">Contribute</div>
                        <div class="font-size-h2 font-w400 text-white">.<span class="float-right"><i class="fa fa-donate "></i></span></div>
                    </div>
                </a>
            </div>
    </div>

@endsection
