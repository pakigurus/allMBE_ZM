@if($roles->name)
    <div class="mx-5 my-5">
        <h4>UnAssigned Permissions</h4>
        <form action="{{url('admin/assign-permission-to-role')}}" method="POST">
            @csrf
            <input type="hidden" name="unassigned_role" value="{{$role_id}}">
            <div class="row">
                @foreach($permissions as $data)
                    <div class="col-lg-3 col-10 col-md-4">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" value="{{$data->id}}" id="{{$data->id}}" name="permissions[]" >
                            <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">

                <button type="submit"  class="btn btn-primary">Assign</button>

            </div>

        </form>
    </div>


    <hr style="color: green;">


    <div class="mx-5 my-5">
        <h4>Assigned Permissions</h4>
        <form action="{{url('admin/assign-permission-to-role')}}" method="POST">
            @csrf
            <input type="hidden" name="assigned_role" value="{{$role_id}}">
            <div class="row">
                @foreach($assignPermission as $data)
                    <div class="col-lg-3 col-10 col-md-4">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" value="{{$data->id}}" id="{{$data->id}}" name="permissions[]" >
                            <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">

                <button type="submit"  class="btn btn-primary">UnAssign</button>

            </div>
        </form>
    </div>
@endif
