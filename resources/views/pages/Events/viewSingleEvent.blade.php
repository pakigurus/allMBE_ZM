@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic font-w600">
                   {{$event->masajid->name}}
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <a href="{{ url('admin/events') }}" class="btn btn-primary btn-sm">Back</a>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
        <!-- Bordered Table -->
        <div class="block ">
            <div class="block-header">
                <h3 class="block-title"> Event Name :{{$event->title}}</h3>
            </div>
            <div class="block-content ">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter">
                        <tbody>
                        <tr>
                            <td class="font-w600 ">
                                Title
                            </td>
                            <td class=" d-sm-table-cell">
                                {{$event->title}}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 ">
                                Description
                            </td>
                            <td class=" d-sm-table-cell">
                                {{$event->description}}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 ">
                                Link
                            </td>
                            <td class="d-sm-table-cell">
                                {{$event->link}}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 ">
                                Email
                            </td>
                            <td class=" d-sm-table-cell">
                                {{$event->email}}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 ">
                                Contact
                            </td>
                            <td class=" d-sm-table-cell">
                                {{$event->contact}}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 ">
                                Address
                            </td>
                            <td class=" d-sm-table-cell">
                                {{$event->address}}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 ">
                                Message
                            </td>
                            <td class="d-sm-table-cell">
                                {{$event->message}}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 ">
                                Event Date
                            </td>
                            <td class="d-sm-table-cell">
                                {{$event->date}}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 ">
                                Event Time
                            </td>
                            <td class="d-sm-table-cell">
                                {{$event->time}}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-w600 ">
                                Status
                            </td>
                            <td class="d-sm-table-cell">
                                <form action="{{url('admin/approve-event/'.$event->id)}}" method="POST">
                                    @csrf
                                    <div class="custom-control custom-switch custom-control-success mb-1">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" @if($event->status == 1) checked @endif onchange="mySubmit(this.form)">
                                        <label class="custom-control-label" for="status"></label>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END Bordered Table -->

@endsection
