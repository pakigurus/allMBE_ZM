@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    All FAQ's
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-header"></div>
        <div class="block-content block-content-full">
           <div class="table-responsive">
               <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
               <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                   <thead>
                   <tr>
                       <th class="text-center" style="width: 80px;">Sr #</th>
                       <th class=" d-sm-table-cell" >Question</th>
                       <th class=" d-sm-table-cell" >Answer</th>
                       <th class=" d-sm-table-cell" >Module</th>
                       <th class=" d-sm-table-cell" >Action</th>
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($faqs as $key=>$faq)
                       <tr>
                           <td class="text-center font-size-sm">{{$key+1}}</td>
                           <td class="font-w600  d-sm-table-cell font-size-sm " style="text-align: justify" >
                               <em class="text-muted"> {{$faq->question}}</em>
                           </td>
                           <td class=" d-sm-table-cell font-size-sm" style="text-align: justify">
                              {{$faq->answer}}
                           </td>
                           <td class="d-sm-table-cell">
                               <em class="text-muted">{{$faq->module}}</em>
                           </td>
                           <td class=" d-sm-table-cell" style="white-space: nowrap">
                               <a href="{{url('admin/faq/'.$faq->id.'/edit')}}" class="mx-2" style="color: inherit;" ><i class="fa fa-pencil-alt" data-toggle="tooltip" data-placement="top" title="edit faq"></i></a>
                               <a href="{{url('admin/faq/'.$faq->id)}}"  style="color: inherit;" data-toggle="modal" data-target="#modal-block-slideleft-{{$key+1}}" ><i class="fa fa-trash-alt" data-toggle="tooltip" data-placement="top" title="delete faq"></i></a>
                           </td>
                       </tr>
                       <!-- Slide Left delete Modal -->
                       <div class="modal fade" style="border-radius: 10px" id="modal-block-slideleft-{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideleft" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-slideleft modal-dialog-centered" role="document">
                               <div class="modal-content">
                                   <div class="block block-themed block-transparent mb-0">
                                       <div class="block-header bg-gradient-indigo">
                                           <h3 class="block-title">Delete FAQ</h3>
                                           <div class="block-options">
                                               <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                   <i class="fa fa-fw fa-times"></i>
                                               </button>
                                           </div>
                                       </div>
                                       <div class="block-content font-size-sm ">
                                           <div class="text-center">
                                               <i class="fa fa-exclamation-triangle fa-3x text-warning"></i>
                                               <h3 class="text-muted mt-2">Are you sure to delete this faq ?</h3>
                                           </div>
                                       </div>
                                       <div class="block-content block-content-full text-right border-top">
                                           <form action="{{url('admin/faq/'.$faq->id)}}" method="POST">
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
    <!-- END Dynamic Table Full Pagination -->
@endsection
