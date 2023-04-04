@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Edit Tour Object') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label required">{{ __('Title') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Title" required maxlength="60" minlength="3" value="{{ $tour->name }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label required">{{ __('Category') }}</label>
                                <select required class="form-select" id="category" name="tour_category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }} " {{ $category->id == $tour->tour_category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="facility-trixFields" class="form-label required">{{ __('Facilities') }}</label>
                                @trix($tour->facility, 'content', ['hideTools' => ['text-tools', 'file-tools'], 'hideButtonIcons' => ['heading-1', 'quote', 'code', 'decrease-nesting-level', 'increase-nesting-level']])
                                @error('facility-trixFields')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="tour-trixFields" class="form-label required">{{ __('Description') }}</label>
                                @trix($tour, 'content', ['hideTools' => ['text-tools', 'file-tools'], 'hideButtonIcons' => ['heading-1', 'quote', 'code', 'decrease-nesting-level', 'increase-nesting-level']])
                                @error('tour-trixFields')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Image management link --}}
                        <div class="col-md-12">
                            <div class="mb-3">
                                <a href="{{ route('tours.images', $tour->slug) }}" class="btn btn-sm bg-gradient-primary">{{ __('Manage Images') }}</a>
                            </div>
                        </div>
                        {{-- Back and Update button --}}
                        <div class="d-block text-end mt-3 mb-2">
                            {{-- Back and Update button --}}
                            <a href="{{ route('tours.show', $tour->slug) }}" class="btn bg-gradient-secondary w-25 mx-2">{{ __('Back') }}</a>
                            <button type="submit" class="btn bg-gradient-primary w-30 mx-2">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
