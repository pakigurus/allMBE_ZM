@extends('layouts.master')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2 text-muted font-italic">
                   Edit Duaa
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
                    <form class="p-2" action="{{url("admin/dua/{$dua->id}")}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="dropdown-content-form-password">Duaa Name</label>
                            <input type="text" class="form-control" id="dropdown-content-form-password" name="name" placeholder="" value="{{$dua->name}}" required>
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dropdown-content-form-password">Duaa Urdu Name</label>
                            <input type="text" class="form-control" id="dropdown-content-form-password" name="urdu_name" value="{{$dua->urdu_name}}" placeholder="">
                            @error('urdu_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dropdown-content-form-password">Duaa</label>
                            <textarea type="text" class="form-control" id="dropdown-content-form-password" name="dua" cols="30" rows="5" placeholder="" required>{{$dua->dua}}</textarea>
                            @error('dua')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dropdown-content-form-password">Translation</label>
                            <textarea name="translation" class="form-control" id="dropdown-content-form-password" cols="30" rows="5" required>{{$dua->translation}}</textarea>
                            @error('translation')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dropdown-content-form-password">Urdu Translation</label>
                            <textarea name="urdu_translation" class="form-control" cols="30" rows="5" required>{{$dua->urdu_translation}}</textarea>
                            @error('urdu_translation')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dropdown-content-form-password">Transliteration</label>
                            <textarea name="transliteration" class="form-control"  cols="30" rows="5" required>{{$dua->transliteration}}</textarea>
                            @error('transliteration')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dropdown-content-form-password">Reference</label>
                            <textarea name="reference" class="form-control" cols="30" rows="5" required>{{$dua->reference}}</textarea>
                            @error('reference')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
@endsection
