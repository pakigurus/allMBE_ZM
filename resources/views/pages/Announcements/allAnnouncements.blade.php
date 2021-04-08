@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    All Announcements
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <a href="{{ url('admin/home') }}" class="btn btn-primary btn-sm">Back</a>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-header">
            <a href="{{url('admin/csv-export/announcement')}}" class="btn btn-primary btn-sm pull-right">CSV Export</a>
        </div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">Sr #</th>
                        <th class=" d-sm-table-cell" >Masajid Name</th>
                        <th class=" d-sm-table-cell" >Title</th>
                        <th class=" d-sm-table-cell" >Contact</th>
                        <th class=" d-sm-table-cell" >Status</th>
                        <th class=" d-sm-table-cell" >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($announcements as $key=>$announcement)
                        <tr>
                            <td class="text-center font-size-sm">{{$key+1}}</td>
                            <td class=" font-size-sm">{{$announcement->masajid->name}}</td>
                            <td class="font-w600  d-sm-table-cell font-size-sm">
                                <em class="text-muted">{{$announcement->title}}</em>
                            </td>
                            <td class=" d-sm-table-cell">
                                <em class="text-muted">{{$announcement->contact}}</em>
                            </td>
                            <td class=" d-sm-table-cell">
                                <form action="{{url('admin/approve-announcement/'.$announcement->id)}}" method="POST">
                                    @csrf
                                    <div class="custom-control text-center custom-switch custom-control-success mb-1">
                                        <input type="checkbox" class="custom-control-input" id="{{$key+1}}" name="status" @if($announcement->status == 1) checked @endif onchange="mySubmit(this.form)">
                                        <label class="custom-control-label" for="{{$key+1}}"></label>
                                    </div>
                                </form>
                            </td>
                            <td class=" d-sm-table-cell" style="white-space: nowrap">
                                <a href="{{url('admin/announcement/'.$announcement->id)}}" style="color: inherit;" ><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="view announcement"></i></a>
                                <a href="{{url('admin/announcement/'.$announcement->id.'/edit')}}" class="mx-2" style="color: inherit;" ><i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="edit announcement"></i></a>
                                <a href="{{url('admin/announcement/'.$announcement->id)}}"  style="color: inherit;" data-toggle="modal" data-target="#modal-block-slideleft-{{$key+1}}" ><i class="fa fa-trash-alt" data-toggle="tooltip" data-placement="top" title="delete announcement"></i></a>
                            </td>
                        </tr>
                        <!-- Slide Left delete Modal -->
                        <div class="modal fade" style="border-radius: 10px" id="modal-block-slideleft-{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideleft" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-slideleft modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="block block-themed block-transparent mb-0">
                                        <div class="block-header bg-gradient-indigo">
                                            <h3 class="block-title">Delete Announcement</h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                    <i class="fa fa-fw fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content font-size-sm ">
                                            <div class="text-center">
                                                <i class="fa fa-exclamation-triangle fa-3x text-warning"></i>
                                                <h3 class="text-muted mt-2">Are you sure to delete this announcement ?</h3>
                                            </div>
                                        </div>
                                        <div class="block-content block-content-full text-right border-top">
                                            <form action="{{url('admin/announcement/'.$announcement->id)}}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button  type="submit" class="btn btn-sm btn-primary" ><i class="fa fa-check mr-1"></i>Ok</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Slide Left delete Modal -->
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
@endsection
