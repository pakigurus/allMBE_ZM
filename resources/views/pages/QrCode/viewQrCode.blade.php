@extends('layouts.master')

@section('content')
    <style>
        @media print {
            .print {
                background-color: white;
                height: 100%;
                width: 100%;
                position: fixed;
                top: 0;
                left: 0;
                margin: 0;
                padding: 15px;
                font-size: 14px;
                line-height: 18px;
            }
        }
    </style>
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    View QrCode (just press "ctrl+p" to print the QrCode)
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Dynamic Table Full Pagination -->
    <div class="block ">
        <div class="block-header">
            <h1>Link : {{$data->url}}</h1> <a class="btn btn-sm btn-primary" href="{{url('admin/qr-code/download')}}" >Download</a>
        </div>
        <div class="block-content block-content-full">
            <div class="m-5 print">
                <img src="{{asset('images/qrcode.png')}}" alt="">
            </div>
        </div>
    </div>
@endsection
