@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    All Duaas
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <!-- All Duas Table -->
    <div class="block">
        <div class="block-header"></div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">Sr #</th>
                        <th class="" >Dua Name</th>
                        <th class="" >Dua</th>
                        <th class="" >Translation</th>
                        <th class="" >Transliteration</th>
                        <th class="" >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($Duas as $key=>$dua)
                        <tr>
                            <td class="text-center font-size-sm">{{$key+1}}</td>
                            <td class=" font-size-sm">{{$dua->name}}</td>
                            <td class="font-w600 font-size-sm">
                                {{$dua->dua}}
                            </td>
                            <td class="">
                                {{$dua->translation}}</em>
                            </td>
                            <td class="">
                                {{$dua->transliteration}}</em>
                            </td>
                            <td class="text-center" style="white-space: nowrap">
                                <a href="{{url('admin/dua/'.$dua->id)}}" class="mr-3" style="color: inherit;" ><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="view linkage"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END All Duas Table -->
@endsection
