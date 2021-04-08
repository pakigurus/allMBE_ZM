@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    App Users
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-header"></div>
        <div class="block-content block-content-full">
            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                <thead>
                <tr>
                    <th class="text-center" style="width: 80px;">Sr #</th>
                    <th class=" d-sm-table-cell" >First Name</th>
                    <th class=" d-sm-table-cell" >Last Name</th>
                    <th class=" d-sm-table-cell" >Email</th>
                    <th class=" d-sm-table-cell" >Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $key=>$user)
                    <tr>
                        <td class="text-center font-size-sm">{{$key+1}}</td>
                        <td class="font-w600  d-sm-table-cell font-size-sm">
                            <em class="text-muted">{{$user->first_name}}</em>
                        </td>
                        <td class=" font-size-sm">{{$user->last_name}}</td>
                        <td class=" d-sm-table-cell">
                            <em class="text-muted">{{$user->email}}</em>
                        </td>


                        <td class=" d-sm-table-cell" style="white-space: nowrap">
                            <a href="{{url('admin/user/'.$user->id.'/edit')}}" class="mx-2" style="color: inherit;" data-toggle="tooltip" data-placement="top" title="edit user" ><i class="fa fa-pencil-alt"></i></a>
                            <a href="{{url('admin/user/'.$user->id)}}"  style="color: inherit;" data-toggle="modal" data-target="#modal-block-slideleft-{{$key+1}}" ><i class="fa fa-trash-alt" data-toggle="tooltip" data-placement="top" title="delete user"></i></a>
                        </td>
                    </tr>
                    <!-- Slide Left Block Modal -->
                    <div class="modal fade" style="border-radius: 10px" id="modal-block-slideleft-{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideleft" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-slideleft modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="block block-themed block-transparent mb-0">
                                    <div class="block-header bg-gradient-indigo">
                                        <h3 class="block-title">Delete User</h3>
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
                                        <form action="{{url('admin/user/'.$user->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button  type="submit" class="btn btn-sm btn-primary" ><i class="fa fa-check mr-1"></i>Ok</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Slide Left Block Modal -->
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
@endsection
