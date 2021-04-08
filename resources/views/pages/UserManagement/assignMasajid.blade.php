@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content ">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Assign Masajids to User
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-header"></div>
        <div class="block-content block-content-full ml-3">
            <div class="row ">
                <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="select-user">Select User</label>
                                <select class="form-control" id="select-user" name="user" style="width: 100%;"  onchange="getMasajids(this.value)">
                                    <option>--select--</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    @foreach($users as $key=> $user)
                                    <option value="{{$user->id}}">{{$user->first_name}}&nbsp;{{$user->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                </div>
            </div>

            <div id="appendData">

            </div>
        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->

    <script>
        function getMasajids(value) {
            var userId = value;
            $.ajax({
                url:  "get-masajids/"+userId,
                method: 'get',
                success: function(data) {
                    $("#appendData").html(data.options);
                }
            });
        }
    </script>
@endsection
