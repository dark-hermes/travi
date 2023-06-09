@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Edit News Category') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('news-categories.update', $newsCategory->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name" class="form-control-label required">{{ __('Category') }}</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Category Name') }}" value="{{ $newsCategory->name }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Back and Update button --}}
                    <div class="d-block text-end">
                        <a href="{{ route('news-categories.index') }}" class="btn bg-gradient-dark w-25 mx-2 mb-2">{{ __('Back') }}</a>
                        <button type="submit" class="btn bg-gradient-primary w-30 mx-2 mb-2">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
