@extends('layouts.master')

@section('content')

    <style type="texhttps://stackoverflow.com/questions/24917483/get-utc-time-and-local-time-from-nsdate-objectt/css">
        #mymap {
            border:1px solid white;
            width: 100%;
            height: 500px;
        }
    </style>

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic font-w600">
                   {{$masajid->status == 0 ? $masajid->name." (Ban Place)" : $masajid->name." (Masajid) " . $masajid->surrogate_id}}
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th style="width: 30%;">Google Masjid ID</th>
                        <th style="width: 15%;">Address</th>
                        <th style="width: 15%;">city</th>
                        <th style="width: 15%;">state</th>
                        <th style="width: 15%;">country</th>
                        <th class="text-center" style="width: 100px;">Lat</th>
                        <th class="text-center" style="width: 100px;">Long</th>
                        <th class="text-center" style="width: 100px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">
                           {{$masajid->name}}
                        </td>
                        <td class="font-w600 font-size-sm">
                            {{$masajid->google_masajid_id}}
                        </td>
                        <td class="font-size-sm">{{$masajid->address}}</td>
                        <td class="font-size-sm">{{$masajid->city}}</td>
                        <td class="font-size-sm">{{$masajid->state}}</td>
                        <td class="font-size-sm">{{$masajid->country}}</td>
                        <td>
                            {{$masajid->lat}}
                        </td>
                        <td class="text-center">
                            {{$masajid->long}}
                        </td>
                        <td class="text-center">
                            <div class="row">
                                <div class="col-6 float-right">
                                    <a href="{{url('admin/masajid/'.$masajid->id."/edit")}}" ><i class="fa fa-pencil-alt text-muted"></i></a>
                                    <a href="{{url('admin/report-masajid/'.$masajid->id)}}" ><i class="fa fa-ban text-muted"></i></a>
                                </div>
                                <div class="col-6 float-left">
                                    <form action="{{url('admin/masajid/'.$masajid->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button style="border: none;background-color: #F9F9F9" type="submit" class="fa fa-trash-alt text-muted" > </button>
                                    </form>
{{--                                    <a href="{{url('admin/report-masajid/'.$masajid->id)}}" ><i class="fa fa-undo text-muted"></i></a>--}}
                                    <a href="{{url('admin/feed-a-need-masajid/'.$masajid->id)}} "  style="color: {{$masajid->feed_need == 1 ? "green" : "red"}}"><i class="fa fa-donate"></i></a>
                                </div>


                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Full Table -->
        <!-- Block Tabs Animated Slide Right -->
        <div class="block">
            <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#btabs-animated-slideright-home">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#btabs-animated-slideright-profile">Announcements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#btabs-animated-slideright-user">Users</a>
                </li>
            </ul>
            <div class="block-content tab-content overflow-hidden">
                <div class="tab-pane fade fade-right show active" id="btabs-animated-slideright-home" role="tabpanel">
                    <!-- Dynamic Table Full Pagination -->
                    <div class="block">
                        <div class="block-content block-content-full">
                            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 80px;">Sr #</th>
                                    <th class="d-none d-sm-table-cell" >Title</th>
                                    <th class="d-none d-sm-table-cell" >Description</th>
                                    <th class="d-none d-sm-table-cell" >Email</th>
                                    <th class="d-none d-sm-table-cell" >Contact</th>
                                    <th class="d-none d-sm-table-cell" >Address</th>
                                    <th class="d-none d-sm-table-cell" >Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($masajid->event as $key=>$event)
                                    <tr>
                                        <td class="text-center font-size-sm">{{$key+1}}</td>
                                        <td class="font-w600 font-size-sm">{{$event->title}}</td>
                                        <td class="d-none d-sm-table-cell font-size-sm">
                                            <em class="text-muted">{{$event->description}}</em>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <em class="text-muted">{{$event->email}}</em>
                                        </td>
                                        <td class="d-none d-sm-table-cell">

                                                <em class="text-muted">{{$event->contact}}</em>

                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                                <em class="text-muted">{{$event->address}}</em>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <a href="{{url('admin/events/'.$event->id)}}" class="btn btn-sm btn-primary push">View</a>
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
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 80px;">Sr #</th>
                                    <th class="d-none d-sm-table-cell" >Title</th>
                                    <th class="d-none d-sm-table-cell" >Description</th>
                                    <th class="d-none d-sm-table-cell" >Email</th>
                                    <th class="d-none d-sm-table-cell" >Contact</th>
                                    <th class="d-none d-sm-table-cell" >Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($masajid->announcement as $key=>$announcement)
                                    <tr>
                                        <form action="" method="PUT"></form>
                                        <td class="text-center font-size-sm">{{$key+1}}</td>
                                        <td class="font-w600 font-size-sm">{{$announcement->title}}</td>
                                        <td class="d-none d-sm-table-cell font-size-sm">
                                            <em class="text-muted">{{$announcement->description}}</em>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <em class="text-muted">{{$announcement->email}}</em>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <em class="text-muted">{{$announcement->contact}}</em>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <a href="{{url('admin/announcement/'.$announcement->id)}}" class="btn btn-sm btn-primary push">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END Dynamic Table Full Pagination -->
                </div>
                <div class="tab-pane fade fade-right" id="btabs-animated-slideright-user" role="tabpanel">
                    <!-- Dynamic Table Full Pagination -->
                    <div class="block">
                        <div class="block-content block-content-full">
                            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 80px;">Sr #</th>
                                    <th class="d-none d-sm-table-cell" >Name</th>
                                    <th class="d-none d-sm-table-cell" >Email</th>
                                    <th class="d-none d-sm-table-cell" >Contact</th>
                                    <th class="d-none d-sm-table-cell" >Verification Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($masajid->user as $key=>$user)
                                    <tr>
                                        <form action="" method="PUT"></form>
                                        <td class="text-center font-size-sm">{{$key+1}}</td>
                                        <td class="d-none d-sm-table-cell font-size-sm">
                                            <em class="text-muted">{{$user->first_name.' '.$user->last_name}}</em>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <em class="text-muted">{{$user->email}}</em>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <em class="text-muted">{{$user->userProfile->contact ? $user->userProfile->contact : "none"}}</em>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <em class="d-none d-sm-table-cell"> {{$user->userProfile->email_verification_status ? 'Verified' : 'Non-Verified' }}</em>
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
        <!-- END Block Tabs Animated Slide Right -->

    <div id="mymap"></div>

    <script>
        var locations = <?php print_r(json_encode($masajid)) ?>;

        var mymap = new GMaps({
            el: '#mymap',
            lat: locations.lat,
            lng: locations.long,
            zoom:10
        });


            mymap.addMarker({
                lat: locations.lat,
                lng: locations.long,
                title: locations.address,
                click: function(e) {
                    alert('This is '+locations.name+' Masajid , from '+locations.address+'.');
                }
        });

    </script>

@endsection
