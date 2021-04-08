@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                    Feedback
                </h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="block">
        <div class="block-header"></div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 30px;">Sr #</th>
                        <th class="" >Email</th>
                        <th class="" >Phone</th>
                        <th class="" >Message</th>
                        <th class="" >Device</th>
                        <th class="" >Rating</th>
                        <th class="" >Stars</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($feedback as $key => $value)
                        <?php

                        ?>
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->contact}}</td>
                            <td>{{$value->message}}</td>
                            <td>{{$value->device == 1 ? "Android" : "Iphone"}}</td>
                            <td>{{$value->rating}}</td>
                            <td>@for($i = 1 ; $i <= $value->rating ; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
