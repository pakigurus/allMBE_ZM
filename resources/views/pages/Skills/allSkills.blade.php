@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    All Skills
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <!-- All Duas Table -->
    <div class="block">
        <div class="block-content block-content-full">
            <button class="btn btn-primary mb-1" data-toggle="modal" data-target="#modal-block-slideleft">Add Skills/Interest</button>
            <!-- Slide Left delete Modal -->
            <div class="modal fade" style="border-radius: 10px" id="modal-block-slideleft" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideleft" aria-hidden="true">
                <div class="modal-dialog modal-dialog-slideleft modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-gradient-indigo">
                                <h3 class="block-title">Add Skill/Interest</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content font-size-sm ">
                                <form class="p-2" action="{{url('admin/skills')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="dropdown-content-form-password">Name</label>
                                            <input type="text" class="form-control" id="dropdown-content-form-password" name="name" placeholder="" required>
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="dropdown-content-form-password">Display Name</label>
                                            <input type="text" class="form-control" id="dropdown-content-form-password" name="display_name" placeholder="" required>
                                            @error('display_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="dropdown-content-form-email">Select Skills Type</label>
                                            <select class="js-select2 form-control" id="example-select2" name="type"  style="width: 100%;" data-placeholder="Choose one.." required>
                                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                    <option value="0">Skills</option>
                                                    <option value="1">Interest</option>
                                            </select>
                                            @error('type')
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

            <div class="row">
                <div class="col-md-6">
                    <h1>Skills</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">Sr #</th>
                                <th class="" >Name</th>
                                <th class="" >Display Name</th>
                                <th class="" >Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($skills as $key=>$skill)
                                @if($skill->type == 0)
                                <tr>
                                    <td class="text-center font-size-sm">{{$i++}}</td>
                                    <td class=" font-size-sm">{{$skill->name}}</td>
                                    <td class="font-w600 font-size-sm">
                                        {{$skill->display_name}}
                                    </td>
                                    <td class="text-center" style="white-space: nowrap">
                                        @if($skill->name !== 'others')
                                        <a href="{{url('admin/skills/'.$skill->id)}}" class="mr-3" style="color: inherit;" ><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="view linkage"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <h1>Interests</h1>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">Sr #</th>
                                <th class="" >Name</th>
                                <th class="" >Display Name</th>
                                <th class="" >Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($skills as $key=>$skill)
                                @if($skill->type == 1)
                                <tr>
                                    <td class="text-center font-size-sm">{{$i++}}</td>
                                    <td class=" font-size-sm">{{$skill->name}}</td>
                                    <td class="font-w600 font-size-sm">
                                        {{$skill->display_name}}
                                    </td>
                                    <td>
                                    @if($skill->name !== 'others')
                                            <a href="{{url('admin/skills/'.$skill->id)}}" class="mr-3" data-method="delete" style="color: inherit;" ><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                    @endif
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END All Duas Table -->
@endsection
