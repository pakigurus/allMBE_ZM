@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    All Masajids
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <a href="{{ url('/admin/home') }}" class="btn btn-primary btn-sm">Back</a>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-header">
            <a href="{{url('admin/csv-export/masajid')}}" class="btn btn-primary btn-sm pull-right">CSV Export</a>
        </div>
        <div class="block-content block-content-full">
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#btabs-animated-slideright-home">All Masajid</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideright-profile">Ban Places</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideright-duplicate">Duplicate Masajids</a>
                    </li>
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane fade fade-right show active" id="btabs-animated-slideright-home" role="tabpanel">
                        <!-- Dynamic Table Full Pagination -->
                        <div class="block">
                            <div class="block-content block-content-full">
                                <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination table-responsive">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width: 80px;">Sr #</th>
                                        <th class="text-center">Surrogate #</th>
                                        <th class="d-none d-sm-table-cell" >Name</th>
                                        <th class="d-none d-sm-table-cell" >Google Masajid ID</th>
                                        <th class="d-none d-sm-table-cell" >city</th>
                                        <th class="d-none d-sm-table-cell" >state</th>
                                        <th class="d-none d-sm-table-cell" >country</th>
                                        <th class="d-none d-sm-table-cell" >Events</th>
                                        <th class="d-none d-sm-table-cell" >Announcements</th>
                                        <th class="d-none d-sm-table-cell" >Users</th>
                                        <th class="d-none d-sm-table-cell" >Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($i = 1)
                                    @foreach($AllMasajid as $key=>$masjid)
                                        <tr>
                                            <td class="text-center font-size-sm">{{$i++}}</td>

                                            <td class="d-none d-sm-table-cell">
                                                <em class="text-muted">{{$masjid->surrogate_id}}</em>
                                            </td>
                                            <td class="font-w600 font-size-sm">{{$masjid->name}}</td>
                                            <td class="d-none d-sm-table-cell font-size-sm">
                                                <em class="text-muted">{{$masjid->google_masajid_id}}</em>
                                            </td>
                                            <td class="d-none d-sm-table-cell">
                                                <em class="text-muted">{{$masjid->city}}</em>
                                            </td>
                                            <td class="d-none d-sm-table-cell">
                                                <em class="text-muted">{{$masjid->state}}</em>
                                            </td>
                                            <td class="d-none d-sm-table-cell">
                                                <em class="text-muted">{{$masjid->country}}</em>
                                            </td>
                                            <td class="d-none d-sm-table-cell">
                                                <a href="{{url('admin/masajid/'.$masjid->id)}}">
                                                    <em class="">{{$masjid->event_count}}</em>
                                                </a>

                                            </td>
                                            <td class="d-none d-sm-table-cell">
                                                <a href="{{url('admin/masajid/'.$masjid->id)}}">
                                                    <em class="">{{$masjid->announcement_count}}</em>
                                                </a>
                                            </td>
                                            <td class="d-none d-sm-table-cell">
                                                <a href="{{url('admin/masajid/'.$masjid->id)}}">
                                                    <em class="">{{$masjid->user_count}}</em>
                                                </a>
                                            </td>
                                            <td class="d-none d-sm-table-cell" style="white-space: nowrap">
                                                <a href="{{url('admin/masajid/'.$masjid->id)}}" style="color: inherit;" ><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="view masajid" ></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Dynamic Table Full Pagination -->
                    </div>
                    <div class="tab-pane fade fade-right" id="btabs-animated-slideright-profile" role="tabpanel">
                        <!-- Dynamic Table Full Pagination -->
                        <div class="block">
                            <div class="block-content block-content-full">
                                <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination table-responsive">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width: 80px;">Sr #</th>
                                        <th class="text-center">Surrogate #</th>
                                        <th class="d-none d-sm-table-cell" >Name</th>
                                        <th class="d-none d-sm-table-cell" >Google Masajid ID</th>
                                        <th class="d-none d-sm-table-cell" >city</th>
                                        <th class="d-none d-sm-table-cell" >state</th>
                                        <th class="d-none d-sm-table-cell" >country</th>
                                        <th class="d-none d-sm-table-cell" >Events</th>
                                        <th class="d-none d-sm-table-cell" >Announcements</th>
                                        <th class="d-none d-sm-table-cell" >Users</th>
                                        <th class="d-none d-sm-table-cell" >Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($i = 1)
                                    @foreach($BanPlaces as $key=>$masjid)
                                            <tr>
                                                <td class="text-center font-size-sm">{{$i++}}</td>

                                                <td class="d-none d-sm-table-cell">
                                                    <em class="text-muted">{{$masjid->surrogate_id}}</em>
                                                </td>
                                                <td class="font-w600 font-size-sm">{{$masjid->name}}</td>
                                                <td class="d-none d-sm-table-cell font-size-sm">
                                                    <em class="text-muted">{{$masjid->google_masajid_id}}</em>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <em class="text-muted">{{$masjid->city}}</em>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <em class="text-muted">{{$masjid->state}}</em>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <em class="text-muted">{{$masjid->country}}</em>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <a href="{{url('admin/masajid/'.$masjid->id)}}">
                                                        <em class="">{{$masjid->event_count}}</em>
                                                    </a>

                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <a href="{{url('admin/masajid/'.$masjid->id)}}">
                                                        <em class="">{{$masjid->announcement_count}}</em>
                                                    </a>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <a href="{{url('admin/masajid/'.$masjid->id)}}">
                                                        <em class="">{{$masjid->user_count}}</em>
                                                    </a>
                                                </td>
                                                <td class="d-none d-sm-table-cell" style="white-space: nowrap">
                                                    <a href="{{url('admin/masajid/'.$masjid->id)}}" style="color: inherit;" ><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="view masajid" ></i></a>
                                                </td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Dynamic Table Full Pagination -->
                    </div>
                    <div class="tab-pane fade fade-right" id="btabs-animated-slideright-duplicate" role="tabpanel">
                        <!-- Dynamic Table Full Pagination -->
                        <div class="block">
                            <div class="block-content block-content-full">
                                <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination table-responsive">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width: 80px;">Sr #</th>
                                        <th class="text-center">Surrogate #</th>
                                        <th class="d-none d-sm-table-cell" >Name</th>
                                        <th class="d-none d-sm-table-cell" >Google Masajid ID</th>
                                        <th class="d-none d-sm-table-cell" >city</th>
                                        <th class="d-none d-sm-table-cell" >state</th>
                                        <th class="d-none d-sm-table-cell" >country</th>
                                        <th class="d-none d-sm-table-cell" >Events</th>
                                        <th class="d-none d-sm-table-cell" >Announcements</th>
                                        <th class="d-none d-sm-table-cell" >Users</th>
                                        <th class="d-none d-sm-table-cell" >Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($i = 1)
                                    @foreach($MasajidDuplicate as $key=>$masjid)
                                            <tr>
                                                <td class="text-center font-size-sm">{{$i++}}</td>

                                                <td class="d-none d-sm-table-cell">
                                                    <em class="text-muted">{{$masjid->surrogate_id}}</em>
                                                </td>
                                                <td class="font-w600 font-size-sm">{{$masjid->name}}</td>
                                                <td class="d-none d-sm-table-cell font-size-sm">
                                                    <em class="text-muted">{{$masjid->google_masajid_id}}</em>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <em class="text-muted">{{$masjid->city}}</em>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <em class="text-muted">{{$masjid->state}}</em>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <em class="text-muted">{{$masjid->country}}</em>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <a href="{{url('admin/masajid/'.$masjid->id)}}">
                                                        <em class="">{{$masjid->event_count}}</em>
                                                    </a>

                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <a href="{{url('admin/masajid/'.$masjid->id)}}">
                                                        <em class="">{{$masjid->announcement_count}}</em>
                                                    </a>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <a href="{{url('admin/masajid/'.$masjid->id)}}">
                                                        <em class="">{{$masjid->user_count}}</em>
                                                    </a>
                                                </td>
                                                <td class="d-none d-sm-table-cell" style="white-space: nowrap">
                                                    <a href="{{url('admin/masajid/'.$masjid->id)}}" style="color: inherit;" ><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="view masajid" ></i></a>
                                                </td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Dynamic Table Full Pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
@endsection
