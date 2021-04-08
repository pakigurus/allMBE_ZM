@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Link Duaa to Sub Types
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <a href="{{ url('admin/dua') }}" class="btn btn-primary btn-sm">Back</a>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-header"><h4 class="text-muted text-uppercase">{{$Dua->name}}</h4></div>
        <div class="block-content block-content-full">
            <form action="{{url('admin/dua')}}" method="POST">
                @csrf
                <input type="hidden" name="duaId" value="{{$Dua->id}}">

                <h5 class="text-muted">Un Linked Sub Types</h5>
                <div class="row ml-3">
                    @foreach($DuaSubType as $unlinked)
                    <div class="col-md-3 my-2">
                        <input type="checkbox" name="unlinked[]" value="{{$unlinked->id}}">&nbsp; {{$unlinked->name}}
                    </div>
                    @endforeach
                </div>
                <div class="my-5">
                    <input type="submit" class="btn btn-primary btn-sm" value="Link">

                </div>
            </form>
            <form action="{{url('admin/dua')}}" method="POST">
                @csrf
                <input type="hidden" name="duaId" value="{{$Dua->id}}">

                <h5 class="text-muted">Linked Sub Types</h5>
                <div class="row ml-3">
                    @foreach($Dua_dua_sub_types as $types)
                    <div class="col-md-3 my-2">
                        <input type="checkbox" name="linked[]"  value="{{$types->id}}">&nbsp; {{$types->duasubtype->name}}
                    </div>
                    @endforeach
                </div>
                <div class="mt-5">
                    <input type="submit" class="btn btn-primary btn-sm" value="Unlink">

                </div>
            </form>
        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
@endsection
