@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Dua Appeals
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="block">
        <div class="block-header"></div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 30px;">Sr #</th>
                        <th class="" >Title</th>
                        <th class="" >Name</th>
                        <th class="" >Email</th>
                        <th class="" >Phone</th>
                        <th class="" >Appeal</th>
                        <th class="" >Location</th>
                        <th class="" >Ip</th>
                        <th class="" >Register User</th>
                        <th class="" >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i = 1)
                    @foreach($rForDua as $key => $value)
                        <tr>
                            <td><i class="fas fa-dot-circle" style="color: {{$value->status == 1 ? "green" : "red"}}"></i>{{ ' ' .$i++}}</td>
                            <td>{{$value->title}}</td>
                            <td>{{$value->user_name}}</td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->contact_no}}</td>
                            <td>{{$value->appeal}}</td>
                            <td>{{$value->location}}</td>
                            <td>{{$value->ip}}</td>
                            <td>{{$value->user->full_name ?? "N/A"}}</td>

                            <td>
                                <a href="{{url('admin/dua-appeal/delete/'.$value->id)}}" class="mr-3" data-method="delete" style="color: inherit;" ><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
