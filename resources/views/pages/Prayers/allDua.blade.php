@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    All Duaas
                </h1>
                <a href="{{url('admin/dua-sample-download')}}" class=""><i class="fa fa-question-circle pull-right mt-1" aria-hidden="true"></i> download sample csv</a>

                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <div class="block-header"></div>

                        <div class="block-content block-content-full">
                            <div class="">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-block-slideleft">Add Duaas</button>

                                <!-- Slide Left delete Modal -->
                                <div class="modal fade" style="border-radius: 10px" id="modal-block-slideleft" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideleft" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-slideleft modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent mb-0">
                                                <div class="block-header bg-gradient-indigo">
                                                    <h3 class="block-title">Import File</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="block-content font-size-sm ">
                                                    <form class="p-2" action="{{url('admin/import-dua')}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>CSV File</label>
                                                            <div class="custom-file">
                                                                <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                                                <input type="file" class="custom-file-input" data-toggle="custom-file-input" id="example-file-input-custom" name="file">
                                                                <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                                                                @error('file')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Add</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Slide Left delete Modal -->
                                </div>
                            </div>
                        </div>
                    </ol>
                </nav>
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
                        <th class="" >Duaa English Name</th>
                        <th class="" >Duaa Urdu Name</th>
                        <th class="" >Duaa</th>
                        <th class="" >Translation</th>
                        <th class="" >Urdu Translation</th>
                        <th class="" >Reference</th>
                        <th class="" >Duaa Sub Types</th>
                        <th class="" >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($Duas as $key=>$dua)
                        <tr>
                            <td class="text-center font-size-sm">{{$key+1}}</td>
                            <td class=" font-size-sm">{{$dua->name}}</td>
                            <td class=" font-size-sm">{{$dua->urdu_name}}</td>
                            <td class="font-w600 font-size-sm">
                                {{$dua->dua}}
                            </td>
                            <td class="">
                                {{$dua->translation}}</em>
                            </td>
                            <td class="">
                                {{$dua->urdu_translation}}</em>
                            </td>
                            <td class="">
                                {{$dua->reference}}</em>
                            </td>
                            <td>@foreach($dua->duasubtypes as $duaType) <li>{{$duaType->name}}</li>   @endforeach </td>
                            <td class="text-center" style="white-space: nowrap">
                                <a href="{{url('admin/dua/'.$dua->id)}}" class="mr-3" style="color: inherit;" ><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="view linkage"></i></a>
                                <a href="{{url("admin/dua/{$dua->id}/edit")}}" class="mr-3" style="color: inherit;" ><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                                <a href=""   class="mr-3" style="color: inherit;" data-toggle="modal" data-target="#modal-block-slideleft-{{$key+1}}"><i class="fa fa-trash-alt" data-toggle="tooltip" data-placement="top" title="delete"></i></a>
                            </td>
                        </tr>

                        <!-- Slide Left delete Modal -->
                        <div class="modal fade" style="border-radius: 10px" id="modal-block-slideleft-{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideleft" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-slideleft modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="block block-themed block-transparent mb-0">
                                        <div class="block-header bg-gradient-indigo">
                                            <h3 class="block-title">Delete Duaa</h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                    <i class="fa fa-fw fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content font-size-sm ">
                                            <div class="text-center">
                                                <i class="fa fa-exclamation-triangle fa-3x text-warning"></i>
                                                <h3 class="text-muted mt-2">Are you sure to delete this duaa ?</h3>
                                            </div>
                                        </div>
                                        <div class="block-content block-content-full text-right border-top">
                                            <form action="{{url('admin/dua/'.$dua->id)}}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button  type="submit" class="btn btn-sm btn-primary" ><i class="fa fa-check mr-1"></i>Ok</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Slide Left delete Modal -->
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END All Duas Table -->
@endsection
