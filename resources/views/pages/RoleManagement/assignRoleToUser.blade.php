@extends('layouts.master')

@section('content')
    <!--session data -->
    @php($assignRoles = Session::get('assignRoles'))
    @php($roles = Session::get('roles'))
    @php($userId = Session::get('userId'))

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Assign Role/Permission to User
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
            <div class="row">
                <div class="col-md-6">
                    <form action="{{url('admin/assign-role')}}" method="POST">
                        @csrf
                        <label for="example-ltf-email">Select User <span style="color: red">*</span></label>
                        <div class="form-group">
                            <select class="form-control" id="example-select2" onchange="this.form.submit()" name="user"  style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" @if($userId == $user->id) selected @endif >{{$user->first_name." ".$user->last_name}}</option>
                                @endforeach
                            </select>
                            @error('user')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>

                </div>
            </div>


            <!--Assigned Roles -->
             @isset($assignRoles)
                <form action="{{url('admin/un-assign-role')}}" method="POST">
                    @csrf
                    <input type="hidden" name="userId" value="{{$userId}}">
                    <h3 class="text-muted">Assigned Roles/Permission</h3>
                    <div class="row">
                    @foreach($assignRoles as $role)
                        <div class="col-lg-3 col-10 col-md-4">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" name="AssignedRoles[]" value="{{$role->name}}">
                                <label for="">{{$role->name}}</label>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <input type="submit" class="btn btn-primary btn-sm" value="Un Assign">
                </form>
             @endisset
            <!--End Assigned roles section -->

            <!--unAssigned roles section -->
            @isset($roles)
                <form class="mt-3" action="{{url('admin/assign-role-to-user')}}" method="POST">
                    @csrf
                    <input type="hidden" name="userId" value="{{$userId}}">
                    <h3 class="text-muted">Un Assigned Roles/Permission</h3>
                    <div class="row">
                        @foreach($roles as $rol)
                            <div class="col-lg-3 col-10 col-md-4">
                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" name="unAssignedRoles[]" value="{{$rol->name}}">
                                    <label for="">{{$rol->name}}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type="submit" class="btn btn-primary btn-sm" value="Assign">
                </form>
            @endisset
        </div>
    </div>
@endsection
