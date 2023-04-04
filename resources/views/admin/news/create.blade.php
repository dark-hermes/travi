@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Create News') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label required">{{ __('Title') }}</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required value="{{ old('title') }}" maxlength="60" minlength="1">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label required">{{ __('Category') }}</label>
                                <select required class="form-select" id="category" name="news_category_id">
                                    @if (old('news_category_id') == null)
                                        <option value="" selected disabled>{{ __('Select Category') }}</option>
                                    @endif
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }} @if(old('news_category_id') == $category->id) selected @endif">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="news-trixFields" class="form-label required">{{ __('Content') }}</label>
                                @trix(\App\Models\News::class, 'content')
                                @error('news-trixFields')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Back and Update button --}}
                        <div class="d-block text-end mt-3 mb-2">
                            <a href="{{ route('news.index') }}" class="btn bg-gradient-dark w-25 mx-2">{{ __('Back') }}</a>
                            <button type="submit" class="btn bg-gradient-primary w-30 mx-2">{{ __('Create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
