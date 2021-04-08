@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Iqamah
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
                <div class="col-md-8">
                    <form action="{{url('admin/iqamah/view')}}" method="post">
                        @csrf
                    <label for="example-ltf-email">Select Masjid <span style="color: red">*</span></label>
                    <div class="form-group">
                        <select class="js-select2 form-control" id="example-select1" name="google_masajid_id"  style="width: 100%;" data-placeholder="Choose one.." required  onchange="this.form.submit()">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            @foreach($masajids as $masjid)
                                <option value="{{$masjid->google_masajid_id}}">{{$masjid->name}}</option>
                            @endforeach
                        </select>
                        @error('google_masajid_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    </form>
                </div>
                @if(isset($iqamah))
                    <div class="col-md-4">
                        <a href="{{url('/admin/iqamah/delete-all/'.$iqamah->google_masajid_id)}}" class="btn btn-danger" style="width: 100%">Delete all Iqamah Records</a>
                    </div>
                @endif

        </div>
        <div class="block-content block-content-full">
            <div class="block">
                <div class="block-content tab-content overflow-hidden">

               </div>
            </div>
        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
@endsection
