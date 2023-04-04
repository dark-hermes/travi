@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Edit News') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label required">{{ __('Title') }}</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required maxlength="60" minlength="3" value="{{ $news->title }}">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label required">{{ __('Category') }}</label>
                                <select required class="form-select" id="category" name="news_category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }} " {{ $category->id == $news->news_category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="news-trixFields" class="form-label required">{{ __('Content') }}</label>
                                @trix($news, 'content')
                                @error('news-trixFields')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Back and Update button --}}
                        <div class="d-block text-end mt-3 mb-2">
                            <a href="{{ route('news.show', $news->slug) }}" class="btn bg-gradient-secondary w-25 mx-2">{{ __('Back') }}</a>
                            <button type="submit" class="btn bg-gradient-primary w-25 mx-2">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
