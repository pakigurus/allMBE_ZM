@extends('layouts.master')

@section('content')


        <div class="block block-themed block-rounded">
            <div class="block-header bg-primary">
                <h3 class="block-title">Create Permissions</h3>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{url('admin/permission')}}" method="POST" >
                            @csrf
                            <label for="">Permission Name</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="example-group3-input2" name="permission" placeholder="">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                                @error('permission')
                                <div class="alert alert-danger ">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror


                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

            <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">All Permissions</h3>
                </div>
                <div class="block-content">
                    <div class="row my-5">
                        <div class="col-md-6 text-center offset-3">
                            @foreach($permissions as $key => $permission)
                             <div class="row mt-3">
                                 <div class="col-6">
                                 <span>{{$permission->name}}</span>
                                 </div>
                                 <div class="col-6">
                                 <span class="">
                                     <a href="#" class="mx-3"  style="color: inherit;" data-toggle="modal" data-target="#edit_{{$key+1}}" ><i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="edit permission"></i></a>
                                     <a href="#"  style="color: inherit;" data-toggle="modal" data-target="#modal-block-slideleft-{{$key+1}}" ><i class="fa fa-trash-alt" data-toggle="tooltip" data-placement="top" title="delete permission"></i></a>
                                 </span>
                                 </div>
                             </div>
                                <!-- Slide Left edit Modal -->
                                <div class="modal fade" style="border-radius: 10px" id="edit_{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideleft" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-slideleft modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent mb-0">
                                                <div class="block-header bg-gradient-indigo">
                                                    <h3 class="block-title">Edit Permission</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <form action="{{url('admin/permission/'.$permission->id)}}" method="POST">
                                                    @csrf
                                                    @method('update');
                                                <div class="block-content font-size-sm ">
                                                    <div class="text-center">
                                                        <label for="">Permission Name</label>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" required="" value="{{$permission->name}}" class="form-control" id="example-group3-input2" name="permission" placeholder="">
                                                                <div class="input-group-append">
                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                </div>
                                                            </div>



                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Slide Left edit Modal -->


                                <!-- Slide Left delete Modal -->
                                <div class="modal fade" style="border-radius: 10px" id="modal-block-slideleft-{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideleft" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-slideleft modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent mb-0">
                                                <div class="block-header bg-gradient-indigo">
                                                    <h3 class="block-title">Delete Permission</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="block-content font-size-sm ">
                                                    <div class="text-center">
                                                        <i class="fa fa-exclamation-triangle fa-3x text-warning"></i>
                                                        <h3 class="text-muted mt-2">Are you sure to delete this permission ?</h3>
                                                    </div>
                                                </div>
                                                <div class="block-content block-content-full text-right border-top">
                                                    <form action="{{url('admin/permission/'.$permission->id)}}" method="POST">
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
                        </div>
                    </div>
                </div>
            </div>
@endsection
