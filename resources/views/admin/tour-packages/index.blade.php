@extends('layouts.user_type.auth')

@section('content')
<div class="main-content bg-gray-100 h-100">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-between">
            <div>
                <h5 class="mb-0">All Tour Packages</h5>
            </div>
            @can('tour-package-create')
                <a href={{ route('tour-packages.create') }} class="btn bg-gradient-primary btn-sm">+&nbsp;Add</a>
            @endcan
        </div>
        <form action="{{ route('tour-packages.index', ['sort' => request()->query('sort'), 'order' => request()->query('order')]) }}" method="GET">
            <div class="input-group-sm">
                {{-- Submit when enter pressed --}}
                <input type="text" name="search" class="form-control" placeholder="Search . . ." value="{{ request()->query('search') }}" onkeypress="if(event.keyCode == 13) { event.preventDefault(); this.form.submit(); }">
                <button type="submit" class="d-none"></button>
            </div>
        </form>
        <div class="d-block mt-2">
            {{-- Sort --}}
            <div class="dropdown d-inline-block me-2">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ request()->query('sort') ? request()->query('sort') : 'Sort' }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach ($sortable as $sort)
                        <li><a class="dropdown-item" href="{{ route('tour-packages.index', ['sort' => $sort, 'order' => request()->query('order'), 'search' => request()->query('search')]) }}">{{ $sort }}</a></li>
                    @endforeach
                </ul>
            </div>
            {{-- asc or desc --}}
            <div class="dropdown d-inline-block">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ request()->query('order') ? request()->query('order') : 'Order' }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li class="dropdown-item" onclick="window.location='{{ route('tour-packages.index', ['order' => 'asc', 'sort' => request()->query('sort'), 'search' => request()->query('search')]) }}'"><i class="bx bx-down-arrow-alt"></i></li>
                    <li class="dropdown-item" onclick="window.location='{{ route('tour-packages.index', ['order' => 'desc', 'sort' => request()->query('sort'), 'search' => request()->query('search')]) }}'"><i class="bx bx-up-arrow-alt"></i></li>
                </ul>
            </div>
        </div>
        <div class="row">
            @foreach ($tourPackages as $tourPackage)
                <div class="col-12 col-xl-3 mt-3">
                    <div class="card card-hover h-100" onclick="window.location='{{ route('tour-packages.show', $tourPackage->slug) }}'" style="cursor: pointer;">
                        {{-- Position fixed at the top of card --}}
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="d-flex align-items-center">
                                    {{-- Fixed size image to prevent layout shift --}}
                                    <img src="{{ $tourPackage->thumbnail }}" alt="img-blur-shadow" class="img-fluid border-radius-lg" style="width: 100%; height: 200px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <h5 class="mb-0 text-dark text-sm">{{ $tourPackage->name }}</h5>
                            <div class="text-sm font-weight-bold text-primary">
                                Rp {{ number_format($tourPackage->price_after_discount, 0, ',', '.') }}
                            </div>
                            @if ($tourPackage->discount > 0)
                                <div class="mb-1 text-xs">
                                    <del>Rp {{number_format($tourPackage->price, 0, ',', '.') }}</del>
                                </div>
                            @endif
                            <div class="mb-1 text-xs text-secondary">
                                {{ $tourPackage->visitors }} traviers have been here
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-end mx-4 my-4">
        {{ $tourPackages->links('vendor.pagination.bootstrap-5') }}
</div>

@endsection
