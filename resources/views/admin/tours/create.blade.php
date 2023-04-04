@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Create Tour Oject') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('tours.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label required">{{ __('Title') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Title" required value="{{ old('name') }}" maxlength="60" minlength="3">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label required">{{ __('Category') }}</label>
                                <select required class="form-select" id="category" name="tour_category_id">
                                    @if (old('tour_category_id') == null)
                                        <option value="" selected disabled>{{ __('Select Category') }}</option>
                                    @endif
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }} @if(old('tour_category_id') == $category->id) selected @endif">{{ $category->name }}</option>
                                    @endforeach
                                </select>
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
                                @trix(\App\Models\Tour::class, 'content', ['hideTools' => ['text-tools', 'file-tools'], 'hideButtonIcons' => ['heading-1', 'quote', 'code', 'decrease-nesting-level', 'increase-nesting-level']])
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
                            <a href="{{ route('tours.index') }}" class="btn bg-gradient-dark w-25 mx-2">{{ __('Back') }}</a>
                            <button type="submit" class="btn bg-gradient-primary w-30 mx-2">{{ __('Create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
