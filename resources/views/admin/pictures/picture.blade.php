@extends('base')

@section('content')

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="title" style="float:left;">
                            
                            <h2 class="text-left">{{ $property->title }}y</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.picture.store', $property) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="mb-1">Image</label>
                                        <input type="file" name="image[]" multiple class="form-control" value="{{ old('image') }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <div class="d-flex">
                @foreach ( $propertyPictures as $image )
                    <img class="border p-2 m-2" src="{{ asset($image->image) }}" alt="image" style="width:400px;height:275px">
                    <a href="{{ route('admin.picture.destroy', $image->id) }}">Delete</a>
                @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
