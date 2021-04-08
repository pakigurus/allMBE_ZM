@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Contribute With Skills
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
                        <th class="" >Name</th>
                        <th class="" >Email</th>
                        <th class="" >Phone</th>
                        <th class="" >Skill</th>
                        <th class="" >Bio</th>
                        <th class="" >Description</th>
                        <th class="" >Time Flag</th>
                        <th class="" >Register User</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i = 1)
                    @foreach($contributeWithSkills as $key => $value)
                        <tr>
                            <td><i class="fas fa-dot-circle" style="color: {{$value->status == 1 ? "green" : "red"}}"></i>{{ ' ' .$i++}}</td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->phone}}</td>
                            <td>{{$value->skill->name ?? "N/A"}}</td>
                            <td>{{$value->bio}}</td>
                            <td>{{$value->description}}</td>
                            <td>{{$value->time_flag}}</td>
                            <td>{{$value->user->full_name ?? "N/A"}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
