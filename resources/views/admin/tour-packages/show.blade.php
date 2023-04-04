@extends('layouts.user_type.auth')

@section('content')
{{-- Back button --}}
<a href="{{ route('tour-packages.index') }}" class="btn btn-link text-dark p-0 m-0 align-baseline fs-3">
    <i class="bx bx-left-arrow-alt"></i>
</a>
<div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 d-flex">
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex align-items-center mt-2">
                @can('tour-package-edit')
                    <a href="{{ route('tour-packages.edit', $tourPackage->slug) }}" class="btn btn-sm bg-gradient-info">{{ __('Edit') }}</a>
                @endcan
                @can('tour-package-delete')
                    <form action="{{ route('tour-packages.destroy', $tourPackage->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm bg-gradient-danger delete-confirm mx-2">{{ __('Delete') }}</button>
                    </form>
                @endcan
            </div>
            <div class="card h-100 mb-8">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        {{-- Carousel --}}
                        <div id="carouselExampleControls" class="carousel slide w-100 border-radius-lg" data-bs-ride="carousel" style="background-color: rgba(0, 0, 0, 0.08);">
                            {{-- Carousel items --}}
                            <div class="carousel-inner">
                                @foreach ($tourPackage->images as $image)
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
                                @foreach ($tourPackage->images as $image)
                                    <button type="button" data-bs-target="#carouselExampleControls" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $loop->index }}"></button>
                                @endforeach
                            </div>
                        </div>
                        {{-- Name and Price --}}
                        <div class="font-weight-bolder text-dark fs-3">
                            {{ $tourPackage->name }}
                        </div>
                        <div class="font-weight-bolder text-primary fs-4">
                            Rp {{ number_format($tourPackage->price_after_discount, 0, ',', '.') }}
                        </div>
                        @if ($tourPackage->discount > 0)
                            <div class="text-sm text-danger ms-2">
                                <del>Rp {{ number_format($tourPackage->price, 0, ',', '.') }}</del>
                            </div>
                        @endif
                        @can ('reservation-create')
                            <div class="d-flex align-items-center mt-2">
                                <a href="{{ route('reservations.create-reservation', $tourPackage->id) }}" class="btn btn-sm bg-gradient-success ms-auto">{{ __('Book Now') }}</a>
                            </div>
                        @endcan

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
                        <div class="tab-content" id="desc-content">
                            <div class="tab-pane fade show active" id="facility" role="tabpanel" aria-labelledby="facility-tab">
                                {!! $tourPackage->facility->trixRichText->first()->content !!}
                            </div>
                            <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
                                {!! $tourPackage->trixRichText->first()->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
