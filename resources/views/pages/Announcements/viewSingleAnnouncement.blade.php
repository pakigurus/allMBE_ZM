@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    {{$announcement->masajid->name}}
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <a href="{{ url('/admin/announcement') }}" class="btn btn-primary btn-sm">Back</a>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Bordered Table -->
    <div class="block">
        <div class="block-header">
            <h3 class="block-title">{{$announcement->title}}</h3>
        </div>
        <div class="block-content ">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <tbody>
                    <tr>
                        <td class="font-w600 font-size-lg">
                            Title
                        </td>
                        <td class=" d-sm-table-cell">
                            {{$announcement->title}}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-w600 font-size-lg">
                            Description
                        </td>
                        <td class=" d-sm-table-cell">
                            {{$announcement->description}}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-w600 font-size-lg">
                            Email
                        </td>
                        <td class=" d-sm-table-cell">
                            {{$announcement->email}}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-w600 font-size-lg">
                            Contact
                        </td>
                        <td class=" d-sm-table-cell">
                            {{$announcement->contact}}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-w600 font-size-lg">
                           Status
                        </td>
                        <td class=" d-sm-table-cell">
                            <form action="{{url('admin/approve-announcement/'.$announcement->id)}}" method="POST">
                                @csrf
                                <div class="custom-control  custom-switch custom-control-success mb-1">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" @if($announcement->status == 1) checked @endif onchange="mySubmit(this.form)">
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
