@extends('layouts.user_type.auth')

@section('content')
{{-- Back button --}}
<a href="{{ route('tours.index') }}" class="btn btn-link text-dark p-0 m-0 align-baseline fs-3">
    <i class="bx bx-left-arrow-alt"></i>
</a>
<div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 d-flex">
    <div class="container-fluid">
        <div class="row">
            <div class="card h-100 mb-8">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0">{{ $tour->name }}</h4>
                        </div>
                        {{-- Updated at --}}
                        <div class="d-flex align-items-center">
                            <p class="text-sm mt-1">
                                <i class="bx bx-calendar"></i>
                                {{ $tour->updated_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        {{-- Category --}}
                        <div class="d-flex align-items-center">
                            <a href="{{ route('tour-categories.index') }}" class="text-sm mb-0">
                                <i class="bx bx-tag"></i>
                                {{ $tour->category->name }}
                            </a>
                        </div>
                        {{-- Edit and delete --}}
                        <div class="d-flex align-items-center mt-2">
                            @can('tour-edit')
                                <a href="{{ route('tours.edit', $tour->slug) }}" class="btn btn-sm bg-gradient-info">{{ __('Edit') }}</a>
                            @endcan
                            @can('tour-delete')
                                <form action="{{ route('tours.destroy', $tour->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm bg-gradient-danger delete-confirm mx-2">{{ __('Delete') }}</button>
                                </form>
                            @endcan
                        </div>
                        <hr class="dark mt-2 mb-4">
                        {{-- Carousel --}}
                        <div id="carouselExampleControls" class="carousel slide w-100 border-radius-lg" data-bs-ride="carousel" style="background-color: rgba(0, 0, 0, 0.08);">
                            {{-- Carousel items --}}
                            <div class="carousel-inner">
                                @foreach ($tour->images as $image)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ url($image->path) }}" class="d-block w-100" alt="..." style="height: 24rem; object-fit: scale-down;">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark border-radius-md" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-dark border-radius-md" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>

                            <div class="carousel-indicators">
                                @foreach ($tour->images as $image)
                                    <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $loop->index }}"></button>
                                @endforeach
                            </div>
                        </div>
                        {{-- Nav tabs for facility and description (default is facility) --}}
                        <ul class="nav nav-tabs mt-4" id="desc" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="facility-tab" data-bs-toggle="tab" data-bs-target="#facility" type="button" role="tab" aria-controls="facility" aria-selected="true">Facility</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="false">Description</button>
                            </li>
                        </ul>
                        {{-- Tab contents --}}
                        <div class="tab-content pt-3" id="desc-content">
                            <div class="tab-pane fade show active" id="facility" role="tabpanel" aria-labelledby="facility-tab">
                                {!! $tour->facility->trixRichText->first()->content !!}
                            </div>
                            <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
                                {!! $tour->trixRichText->first()->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
