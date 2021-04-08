@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                  Add Iqamah
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-header"></div>
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-md-6 offset-3">
                    <form action="{{url('admin/iqamah')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="example-ltf-email">Select Masjid <span style="color: red">*</span></label>
                                <div class="form-group">
                                    <select class="js-select2 form-control" id="example-select1" name="google_masajid_id"  style="width: 100%;" data-placeholder="Choose one.." required>
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        @foreach($masajids as $masjid)
                                            <option value="{{$masjid->google_masajid_id}}">{{$masjid->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('google_masajid_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row" id="fajr">
                            <div class="col-md-3">
                                <h3>Fajr</h3>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">Time</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-time-standalone" name="fajr_time" data-enable-time="true" data-no-calendar="true" data-date-format="H:i">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">Start Date</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-friendly" name="fajr_start_date"  data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">End Date</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-friendly" name="fajr_end_date"  data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                                </div>
                            </div>
                        </div>
{{--// Zuhar--}}
                        <div class="row" id="duhr">
                            <div class="col-md-3">
                                <h3>Duhr</h3>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">Time</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-time-standalone" name="duhr_time" data-enable-time="true" data-no-calendar="true" data-date-format="H:i">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">Start Date</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-friendly" name="duhr_start_date"  data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">End Date</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-friendly" name="duhr_end_date"  data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                                </div>
                            </div>
                        </div>

                        <div class="row" id="asr">
                            <div class="col-md-3">
                                <h3>Asr</h3>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">Time</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-time-standalone" name="asr_time" data-enable-time="true" data-no-calendar="true" data-date-format="H:i">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">Start Date</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-friendly" name="asr_start_date"  data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">End Date</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-friendly" name="asr_end_date"  data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                                </div>
                            </div>
                        </div>



                        <div class="row" id="maghrib">
                            <div class="col-md-3">
                                <h3>Maghrib</h3>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="example-ltf-email">Time</label>
                                    <input type="number" class="form-group form-control"  name="maghrib_time">
                                </div>
                            </div>
                        </div>


                        <div class="row" id="isha">
                            <div class="col-md-3">
                                <h3>Isha</h3>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">Time</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-time-standalone" name="isha_time" data-enable-time="true" data-no-calendar="true" data-date-format="H:i">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">Start Date</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-friendly" name="isha_start_date"  data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">End Date</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-friendly" name="isha_end_date"  data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                                </div>
                            </div>
                        </div>


                        <div class="row" id="jumah">
                            <div class="col-md-3">
                                <h3>Jumah</h3>
                            </div>

                            <div class="col-md-6">
                                <label for="example-ltf-password">Module</label>
                                <select name="jumah_type" id="" class="form-control">
                                    <option value=""></option>
                                    <option value="jumah1">Jumah 1</option>
                                    <option value="jumah2">Jumah 2</option>
                                    <option value="jumah3">Jumah 3</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="example-ltf-email">Time</label>
                                    <input type="text" class="js-flatpickr form-control bg-white" id="example-flatpickr-time-standalone" name="jumah_time" data-enable-time="true" data-no-calendar="true" data-date-format="H:i">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" style="width: 100%" value="Submit" >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
@endsection
<script>

    function addfield(element) {
        // $("div[class='fajar']:last").after($('.fajar').clone());
        $('$fajar').append('');
    }

</script>
