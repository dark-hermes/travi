@extends('layouts.user_type.auth')

@section('content')
<div class="main-content bg-gray-100 h-100">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-between">
            <div>
                <h5 class="mb-0">Manage {{ $tour->name }} Images</h5>
            </div>
            {{-- Back Button --}}

            <form action="{{ route('tours.store-image', $tour->id) }}" method="POST" enctype="multipart/form-data">
                <a href="{{ route('tours.edit', $tour->slug) }}" class="btn bg-gradient-secondary btn-sm mx-2">
                    {{ __('Back') }}
                </a>
                @csrf
                <input type="file" name="images[]" id="images" class="d-none" accept="image/*" multiple onchange="document.getElementById('upload').click()">
                {{-- Upload button --}}
                <button type="button" class="btn btn-sm bg-gradient-primary" onclick="document.getElementById('images').click()">
                    {{ __('+ New Images') }}
                </button>
                {{-- Disable until image inputed --}}
                <button type="submit" class="d-none" id="upload">
                    {{ __('Upload') }}
                </button>
            </form>
        </div>
        <hr class="my-4" />
        <div class="row">
            @foreach ($tour->images as $image)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{ url($image->path) }}" alt="" class="img-fluid" style="height: 200px; width: 100%; object-fit: cover; border-radius: 5px;">
                        </div>
                        <div class="card-footer text-center">
                            <form action="{{ route('tours.destroy-image', $image->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm bg-gradient-danger">{{ __('Delete') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
