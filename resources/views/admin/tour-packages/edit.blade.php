@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Edit Tour Package') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('tour-packages.update', $tourPackage->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label required">{{ __('Title') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required maxlength="60" minlength="3" value="{{ $tourPackage->name }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Price --}}
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="price" class="form-label required">{{ __('Price') }}</label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" required value="{{ $tourPackage->price }}" min="1">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Discount --}}
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="discount" class="form-label required">{{ __('Discount') }}</label>
                                <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter Discount" required value="{{ $tourPackage->discount }}" min="0" max="100">
                                @error('discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Price After Discount (get value from jQuery) --}}
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="price_after_discount" class="form-label">{{ __('Price After Discount') }}</label>
                                <input type="number" class="form-control" id="price_after_discount" name="price_after_discount" disabled value="Rp {{ number_format($tourPackage->price_after_discount, 0, ',', '.') }}">
                                @error('price_after_discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="facility-trixFields" class="form-label required">{{ __('Facilities') }}</label>
                                @trix($tourPackage->facility, 'content', ['hideTools' => ['text-tools', 'file-tools'], 'hideButtonIcons' => ['heading-1', 'quote', 'code', 'decrease-nesting-level', 'increase-nesting-level']])
                                @error('facility-trixFields')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="tourPackage-trixFields" class="form-label required">{{ __('Description') }}</label>
                                @trix($tourPackage, 'content', ['hideTools' => ['text-tools', 'file-tools'], 'hideButtonIcons' => ['heading-1', 'quote', 'code', 'decrease-nesting-level', 'increase-nesting-level']])
                                @error('tourpackage-trixFields')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Back and Update button --}}
                        <div class="d-block text-end mt-3 mb-2">
                            {{-- Image management link --}}
                            <a href="{{ route('tour-packages.images', $tourPackage->slug) }}" class="btn btn-sm btn-link">{{ __('Manage Images') }}</a>
                            {{-- Back and Update button --}}
                            <a href="{{ route('tour-packages.show', $tourPackage->slug) }}" class="btn bg-gradient-secondary w-25 mx-2">{{ __('Back') }}</a>
                            <button type="submit" class="btn bg-gradient-primary w-30 mx-2">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
