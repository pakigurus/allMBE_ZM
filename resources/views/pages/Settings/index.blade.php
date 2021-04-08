@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Settings
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">Back</a>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-content block-content-full">
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#btabs-animated-slideright-home">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideright-profile">Terms and Conditions</a>
                    </li>
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane fade fade-right show active" id="btabs-animated-slideright-home" role="tabpanel">
                        <!-- Dynamic Table Full Pagination -->
                        <div class="block">
                            <div class="block-content block-content-full">
                                <form action="{{url('admin/settings/add-about-us')}}" method="POST">
                                    @csrf
                                    <textarea name="about_us" id="about-us" cols="30" rows="10">{{$setting->about_us ?? "About Us"}}</textarea>
                                    <input type="submit" class="btn btn-primary btn-sm" value="Submit">
                                </form>
                            </div>
                        </div>
                        <!-- END Dynamic Table Full Pagination -->
                    </div>
                    <div class="tab-pane fade fade-right" id="btabs-animated-slideright-profile" role="tabpanel">
                        <!-- Dynamic Table Full Pagination -->
                        <div class="block">
                            <div class="block-content block-content-full">
                                <form action="{{url('admin/settings/add-terms-and-conditions')}}" method="POST">
                                    @csrf
                                    <textarea name="terms_and_conditions" id="about-us" cols="30" rows="10">{{$setting->terms_and_conditions ?? "Terms and Conditions"}}</textarea>
                                    <input type="submit" class="btn btn-primary btn-sm" value="Submit">
                                </form>
                            </div>
                        </div>
                        <!-- END Dynamic Table Full Pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
@endsection
