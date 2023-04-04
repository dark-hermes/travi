@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Create Reservation') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('reservations.store-reservation', $tourPackage->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- Date --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label required">{{ __('Date') }}</label>
                                <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date" required value="{{ old('date') }}">
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Price --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">{{ __('Price') }}</label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" disabled value="{{ $tourPackage->price }}" min="1">
                            </div>
                        </div>
                        {{-- Quantity --}}
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="quantity" class="form-label required">{{ __('Quantity') }}</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" required value="{{ old('quantity') }}" min="1">
                                @error('quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Discount --}}
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="discount" class="form-label required">{{ __('Discount') }}</label>
                                <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter Discount" disabled value="{{ $tourPackage->discount }}" min="0" max="100">
                                @error('discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Price After Discount (get value from jQuery) --}}
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="price_after_discount" class="form-label">{{ __('Price After Discount') }}</label>
                                <input type="text" class="form-control" id="price_after_discount" name="price_after_discount" disabled value="Rp{{ number_format($tourPackage->price_after_discount, 0, ',', '.') }}">
                                @error('price_after_discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Back and Create button --}}
                        <div class="d-block text-end mt-3 mb-2">
                            <a href="{{ route('tour-packages.show', $tourPackage->slug) }}" class="btn bg-gradient-secondary w-30 mx-2 mb-2">{{ __('Back') }}</a>
                            <button type="submit" class="btn bg-gradient-primary w-30 mx-2 mb-2">{{ __('Create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
