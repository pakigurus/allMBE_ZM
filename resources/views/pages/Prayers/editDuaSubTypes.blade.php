@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                   Edit Duaa Sub Type
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <a href="{{ url('admin/dua-sub-type/create') }}" class="btn btn-primary btn-sm">Back</a>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <!-- Add Dua Sub Type Section -->
    <div class="block">
        <div class="block-header"></div>
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-md-6 offset-3">

                    <form class="p-2" action="{{url('admin/dua-sub-type/'.$duaSubTypes->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="dropdown-content-form-email">Select Duaa Type</label>
                            <select class="js-select2 form-control" id="example-select2" name="dua_type"  style="width: 100%;" data-placeholder="Choose one..">
                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach($duaTypes as $duaType)
                                    <option value="{{$duaType->id}}" @if($duaSubTypes->dua_types_id == $duaType->id) selected @endif">{{$duaType->name}}</option>
                                @endforeach
                            </select>
                            @error('dua_type')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dropdown-content-form-password">Sub Type Name</label>
                            <input type="text" class="form-control" value="{{$duaSubTypes->name}}" id="dropdown-content-form-password" name="sub_type_name" placeholder="">
                            @error('sub_type_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="custom-file">
                                <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                <input type="file" class="custom-file-input" data-toggle="custom-file-input" id="example-file-input-custom" name="image">
                                <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                                <input type="hidden" name="hiddenImage" value="{{$duaSubTypes->image}}">
                                @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @if($duaSubTypes->image )
                            <div class="col-md-6  animated fadeIn">
                                <div class="options-container fx-item-rotate-r">
                                    <img class="img-fluid options-item" src="{{asset('images/dua/'.$duaSubTypes->image)}}" alt="">
                                    <div class="options-overlay bg-black-75">
                                        <div class="options-overlay-content">
                                            <a class="btn btn-sm btn-primary img-lightbox" href="{{asset('images/dua/'.$duaSubTypes->image)}}">
                                                <i class="fa fa-search-plus mr-1"></i> View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group mt-5 text-center">
                            <input type="submit" class="btn btn-primary" value="Submit" >
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
    <!-- End Add Dua Sub Type Section -->
@endsection
