@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Assign Permissions to Role
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-md-6">
                    <label for="example-ltf-email">Select Role <span style="color: red">*</span></label>
                    <div class="form-group">
                        <select class="form-control" id="example-select2" onchange="getAllPermissions(this.value)" name="role"  style="width: 100%;" data-placeholder="Choose one..">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        @error('role')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="appendData">
            </div>

        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
    <script>
        function getAllPermissions(value) {
            var id_role = value;
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "<?php echo route('select-ajax') ?>",
                method: 'POST',
                data: {id_role:id_role, _token:token},
                success: function(data) {

                    $("#appendData").html(data.options);
                }
            });
        }
    </script>
@endsection
