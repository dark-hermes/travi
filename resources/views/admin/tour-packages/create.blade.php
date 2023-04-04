@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Create Tour Package') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('tour-packages.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- Name --}}
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label required">{{ __('Name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Title" required value="{{ old('name') }}" maxlength="60" minlength="3">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Price --}}
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="price" class="form-label required">{{ __('Price') }}</label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" required value="{{ old('price') }}" min="1">
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Discount --}}
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="discount" class="form-label required">{{ __('Discount') }}</label>
                                <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter Discount" required value="{{ old('discount') }}" min="0" max="100">
                                @error('discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Price After Discount (get value from jQuery) --}}
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="price_after_discount" class="form-label">{{ __('Price After Discount') }}</label>
                                <input type="text" class="form-control" id="price_after_discount" name="price_after_discount" disabled value="Rp0">
                                @error('price_after_discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                {{-- Use trix editor and show only bullet numbering and history button --}}
                                <label for="facility" class="form-label required">{{ __('Facilities') }}</label>
                                @trix(\App\Models\Facility::class, 'content', ['hideTools' => ['text-tools', 'file-tools'], 'hideButtonIcons' => ['heading-1', 'quote', 'code', 'decrease-nesting-level', 'increase-nesting-level']])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                {{-- Use trix editor and show only bullet numbering and history button --}}
                                <label for="description" class="form-label required">{{ __('Description') }}</label>
                                @trix(\App\Models\TourPackage::class, 'content', ['hideTools' => ['text-tools', 'file-tools'], 'hideButtonIcons' => ['heading-1', 'quote', 'code', 'decrease-nesting-level', 'increase-nesting-level']])
                            </div>
                        </div>
                        {{-- Image Input --}}
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="images" class="form-label required">{{ __('Images') }}</label>
                                <input type="file" class="form-control" id="images" name="images[]" required multiple accept="image/*">
                                @error('images')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Back and Update button --}}
                        <div class="d-block text-end mt-3 mb-2">
                            <a href="{{ route('tour-packages.index') }}" class="btn bg-gradient-dark w-25 mx-2">{{ __('Back') }}</a>
                            <button type="submit" class="btn bg-gradient-primary w-30 mx-2">{{ __('Create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
