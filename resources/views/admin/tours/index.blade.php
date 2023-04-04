@extends('layouts.user_type.auth')

@section('content')
<div class="main-content bg-gray-100 h-100">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-between">
            <div>
                <h5 class="mb-0">All Tour Objects</h5>
            </div>
            @can('tour-create')
                <a href={{ route('tours.create') }} class="btn bg-gradient-primary btn-sm">+&nbsp;Add</a>
            @endcan
        </div>
        <form action="{{ route('tours.index') }}" method="GET">
            <div class="input-group-sm">
                {{-- Submit when enter pressed --}}
                <input type="text" name="search" class="form-control" placeholder="Search . . ." value="{{ request()->query('search') }}" onkeypress="if(event.keyCode == 13) { event.preventDefault(); this.form.submit(); }">
            </div>
        </form>
        <div class="dropdown mt-2">
            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                {{ request()->query('category') ? request()->query('category') : 'All Categories' }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="{{ route('tours.index') }}">All Categories</a></li>
                @foreach ($categories as $category)
                    <li><a class="dropdown-item" href="{{ route('tours.index', ['category' => $category]) }}">{{ $category }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="row">
            @foreach ($tours as $tour)
                <div class="col-12 col-xl-3 mt-3">
                    <div class="card card-hover h-100" onclick="window.location='{{ route('tours.show', $tour->slug) }}'" style="cursor: pointer;">
                        {{-- Position fixed at the top of card --}}
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="d-flex align-items-center">
                                    {{-- Fixed size image to prevent layout shift --}}
                                    <img src="{{ $tour->thumbnail }}" alt="img-blur-shadow" class="img-fluid border-radius-lg" style="width: 100%; height: 200px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <a href="{{ route('tours.index', ['category' => $tour->category->name]) }}" class="text-info text-sm font-weight-bold mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="View all {{ $tour->category->name }} tours">
                                {{ $tour->category->name }}
                            </a>
                            <h5 class="mb-0 text-dark text-sm">{{ $tour->name }}</h5>
                            <p class="mb-1 text-xxs">
                                <span class="text-secondary text-sm">{{ $tour->updated_at->diffForHumans() }}</span>
                            </p>
                            <p class="mb-2 text-sm">
                                {{ $tour->short_description }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-end mx-4 my-4">
        {{ $tours->links('vendor.pagination.bootstrap-5') }}
</div>

@endsection
