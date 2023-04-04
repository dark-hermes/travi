@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Edit Reservation') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        {{-- Date --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label required">{{ __('Date') }}</label>
                                <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date" required value="{{ $reservation->date }}">
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Price --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label required">{{ __('Price') }}</label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" required value="{{ $reservation->price }}" min="1">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Quantity --}}
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="quantity" class="form-label required">{{ __('Quantity') }}</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" required value="{{ $reservation->quantity }}" min="1">
                                @error('quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Discount --}}
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="discount" class="form-label required">{{ __('Discount') }}</label>
                                <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter Discount" required value="{{ $reservation->discount }}" min="0" max="100">
                                @error('discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Price After Discount (get value from jQuery) --}}
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="price_after_discount" class="form-label">{{ __('Price After Discount') }}</label>
                                <input type="text" class="form-control" id="price_after_discount" name="price_after_discount" disabled value="Rp{{ number_format($reservation->total_price, 0, ',', '.') }}">
                                @error('price_after_discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Payment Date --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_date" class="form-label">{{ __('Payment Date') }}</label>
                                <input type="date" class="form-control" id="payment_date" name="payment_date" placeholder="Enter Payment Date" value="{{ $reservation->payment_date }}">
                                @error('payment_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Status Select --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label required">{{ __('Status') }}</label>
                                <select class="form-select" id="status" name="status" required>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}" {{ $reservation->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Payment Evidence Image Show --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_evidence" class="form-label">{{ __('Payment Evidence') }}</label>
                                <div class="card">
                                    <div class="card-body">
                                        <img src="{{ url($reservation->payment_evidence) }}" class="img-fluid" alt="Payment Evidence">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Back and Update button --}}
                        <div class="d-block text-end mt-3 mb-2">
                            <a href="{{ route('reservations.index') }}" class="btn bg-gradient-dark w-25 mx-2 mb-2">{{ __('Back') }}</a>
                            <button type="submit" class="btn bg-gradient-primary w-30 mx-2 mb-2">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
