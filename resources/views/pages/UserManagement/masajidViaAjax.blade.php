<h4>Assigned Masajids</h4>
<form action="{{url('admin/un-assign-masajid')}}" method="POST">
    @csrf
    <input type="hidden" name="userId" value="{{$userId}}">
    <div class="row">
        @foreach($assignedMasajid as $data)
            <div class=" mx-3">
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" value="{{$data->id}}" id="{{$data->id}}" name="masajids[]" >
                    <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                </div>
            </div>
        @endforeach
    </div>
    <div class="my-3">

        <button type="submit"  class="btn btn-primary">Un Assign</button>

    </div>

</form>

<h4 class="mt-3">Un Assigned Masajids</h4>
<form action="{{url('admin/assign-masajid')}}" method="POST">
    @csrf
    <input type="hidden" name="userId" value="{{$userId}}">
    <div class="row">
        @foreach($unassigned as $data)
            <div class=" mx-3">
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" value="{{$data->id}}" id="{{$data->id}}" name="masajids[]" >
                    <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-3">

        <button type="submit"  class="btn btn-primary">Assign</button>

    </div>

</form>
