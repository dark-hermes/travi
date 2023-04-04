@extends('layouts.user_type.auth')

@section('content')
<div class="main-content bg-gray-100 h-100">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-between">
            <div>
                <h5 class="mb-0">All Available Lodges</h5>
            </div>
            <form action="{{ route('tours.index') }}" method="GET">
                <div class="input-group-sm">
                    {{-- Submit when enter pressed --}}
                    <input type="text" name="search" class="form-control" placeholder="Search . . ." value="{{ request()->query('search') }}" onkeypress="if(event.keyCode == 13) { event.preventDefault(); this.form.submit(); }">
                </div>
            </form>
            @can('lodge-create')
                <a href={{ route('lodges.create') }} class="btn bg-gradient-primary btn-sm">+&nbsp;Add Lodge</a>
            @endcan
        </div>

        <div class="row">
            @foreach ($lodges as $lodge)
                <div class="col-12 col-xl-3 mt-3">
                    <div class="card card-hover h-100" onclick="window.location='{{ route('lodges.show', $lodge->slug) }}'" style="cursor: pointer;">
                        {{-- Position fixed at the top of card --}}
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="d-flex align-items-center">
                                    {{-- Fixed size image to prevent layout shift --}}
                                    <img src="{{ $lodge->thumbnail }}" alt="img-blur-shadow" class="img-fluid border-radius-lg" style="width: 100%; height: 200px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <h5 class="mb-0 text-dark text-sm">{{ $lodge->name }}</h5>
                            <p class="mb-1 text-xxs">
                                <span class="text-secondary text-sm">{{ $lodge->updated_at->diffForHumans() }}</span>
                            </p>
                            <p class="mb-2 text-sm">
                                {{ $lodge->short_description }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-end mx-4 my-4">
        {{ $lodges->links('vendor.pagination.bootstrap-5') }}
</div>

@endsection
