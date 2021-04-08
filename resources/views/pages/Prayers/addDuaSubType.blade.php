@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Duaa Sub Types
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <!-- Add Dua Sub Type Section -->
    <div class="block">
        <div class="block-header"></div>
        <div class="block-content block-content-full">
          <div class="">
              <button class="btn btn-primary" data-toggle="modal" data-target="#modal-block-slideleft">Add Duaa Sub Type</button>
                  <!-- Slide Left delete Modal -->
                  <div class="modal fade" style="border-radius: 10px" id="modal-block-slideleft" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideleft" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-slideleft modal-dialog-centered" role="document">
                          <div class="modal-content">
                              <div class="block block-themed block-transparent mb-0">
                                  <div class="block-header bg-gradient-indigo">
                                      <h3 class="block-title">Add Duaa Sub Type</h3>
                                      <div class="block-options">
                                          <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                              <i class="fa fa-fw fa-times"></i>
                                          </button>
                                      </div>
                                  </div>
                                  <div class="block-content font-size-sm ">
                                      <form class="p-2" action="{{url('admin/dua-sub-type')}}" method="POST" enctype="multipart/form-data">
                                          @csrf
                                          <div class="form-group">
                                              <label for="dropdown-content-form-email">Select Duaa Type</label>
                                              <select class="js-select2 form-control" id="example-select2" name="dua_type"  style="width: 100%;" data-placeholder="Choose one..">
                                                  <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                  @foreach($duaTypes as $duaType)
                                                      <option value="{{$duaType->id}}">{{$duaType->name}}</option>
                                                  @endforeach
                                              </select>
                                              @error('dua_type')
                                              <div class="alert alert-danger">{{ $message }}</div>
                                              @enderror
                                          </div>
                                          <div class="form-group">
                                              <label for="dropdown-content-form-password">Sub Type Name</label>
                                              <input type="text" class="form-control" id="dropdown-content-form-password" name="sub_type_name" placeholder="">
                                              @error('sub_type_name')
                                              <div class="alert alert-danger">{{ $message }}</div>
                                              @enderror
                                          </div>
                                          <div class="form-group">
                                              <label>Image</label>
                                              <div class="custom-file">
                                                  <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                                  <input type="file" class="custom-file-input" data-toggle="custom-file-input" id="example-file-input-custom" name="image">
                                                  <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                                                  @error('image')
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
    <!-- End Add Dua Sub Type Section -->

    <!-- All Dua Sub types section -->
    <div class="block">
        <div class="block-header"><h3 class="text-muted">All Duaa Sub Types</h3></div>
        <div class="block-content block-content-full">
            <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">Sr #</th>
                        <th class="" >Name</th>
                        <th class=" " >Duaa Type</th>
                        <th class=" " >Image</th>
                        <th class=" " >Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($duaSubTypes as $key=>$duaSubType)
                        <tr>
                            <td class="text-center font-size-sm">{{$key+1}}</td>
                            <td class=" font-size-sm">{{$duaSubType->name}}</td>
                            <td class="font-w600  font-size-sm">
                                <em class="text-muted">{{$duaSubType->duaTypes->name}}</em>
                            </td>
                            <td class="">
                                @if($duaSubType->image)
                                    <div class="col-md-6  animated fadeIn">
                                        <div class="options-container fx-item-rotate-r">
                                            <img class="img-fluid options-item" style="max-width: 100px" src="{{$duaSubType->image}}" alt="">
                                            <div class="options-overlay bg-black-75">
                                                <div class="options-overlay-content">
                                                    <h3 class="h4 font-w400 text-white mb-1"></h3>
                                                    <a class=" img-lightbox" style="color: white" href="{{$duaSubType->image}}">
                                                        <i class="fa fa-eye mr-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center" style="white-space: nowrap">
                                <a href="{{url('admin/dua-sub-type/'.$duaSubType->id.'/edit')}}" class="mr-3" style="color: inherit;" ><i class="fa fa-pencil-alt " data-toggle="tooltip" data-placement="top" title="edit " ></i></a>
                                <a href="{{url('admin/events/'.$duaSubType->id)}}"  style="color: inherit;" data-toggle="modal" data-target="#modal-block-slideleft-{{$key+1}}" ><i class="fa fa-trash-alt" data-toggle="tooltip" data-placement="top" title="delete "></i></a>
                            </td>
                        </tr>
                        <!-- Delete Modal -->
                             <div class="modal fade" style="border-radius: 10px" id="modal-block-slideleft-{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideleft" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-slideleft modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="block block-themed block-transparent mb-0">
                                                            <div class="block-header bg-gradient-indigo">
                                                                <h3 class="block-title">Delete Duaa Sub Type</h3>
                                                                <div class="block-options">
                                                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                                        <i class="fa fa-fw fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="block-content font-size-sm ">
                                                                <div class="text-center">
                                                                    <i class="fa fa-exclamation-triangle fa-3x text-warning"></i>
                                                                    <h3 class="text-muted mt-2">Are you sure to delete this subtype ?</h3>
                                                                </div>
                                                            </div>
                                                            <div class="block-content block-content-full text-right border-top">
                                                                <form action="{{url('admin/dua-sub-type/'.$duaSubType->id)}}" method="POST">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button  type="submit" class="btn btn-sm btn-primary" ><i class="fa fa-check mr-1"></i>Ok</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                        <!-- END Delete Modal -->
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END All Dua Sub types section -->
@endsection
