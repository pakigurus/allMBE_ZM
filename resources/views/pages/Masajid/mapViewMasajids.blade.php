@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <style type="text/css">
        #mymap {
            border:1px solid white;
            width: 100%;
            height: 500px;
        }
    </style>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    All Masajids
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
            <a href="{{url('admin/csv-export/masajid')}}" class="btn btn-primary btn-sm pull-right">CSV Export</a>
        </div>
        <div class="block-content block-content-full">
            <div id="mymap"></div>
        </div>
    </div>
    <script>

       var locations = <?php print_r(json_encode($AllMasajid)) ?>;

        var mymap = new GMaps({
            el: '#mymap',
            lat: 31.5646781,
            lng: 74.2989358,
            zoom:5
        });

        locations.forEach(element => {
            mymap.addMarker({
                lat: element.lat,
                lng: element.long,
                title: element.address,
                click: function(e) {
                    alert('This is '+element.name+' Masajid , from '+element.address+'.');
                }
            });
        });

    </script>

@endsection
