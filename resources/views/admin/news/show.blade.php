@extends('layouts.user_type.auth')

@section('content')
{{-- Back button --}}
<a href="{{ route('news.index') }}" class="btn btn-link text-dark p-0 m-0 align-baseline fs-3">
    <i class="bx bx-left-arrow-alt"></i>
</a>
<div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 d-flex">
    <div class="container-fluid">
        <div class="row">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="d-flex align-items-center">
                            <h3 class="mb-0">{{ $news->title }}</h3>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <a href="{{ route('news.edit', $news->slug) }}" class="btn btn-sm bg-gradient-info">{{ __('Edit') }}</a>
                            {{ __('|') }}
                            <form action="{{ route('news.destroy', $news->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm bg-gradient-danger delete-confirm mx-2">{{ __('Delete') }}</button>
                            </form>
                        </div>
                        <p class="text-sm mb-0 mt-3">
                            <i class="bx bx-calendar"></i>
                            {{ $news->created_at->format('d M Y H:i') }}
                        </p>
                        <a href="{{ route('news.index', ['category' => $news->category->id]) }}" class="text-sm mb-0 mt-3">
                            <i class="bx bx-tag"></i>
                            {{ $news->category->name }}
                        </a>
                    </div>
                </div>
                <div class="card-body p-3">
                    {!! $news->trixRichText->first()->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
