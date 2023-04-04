@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Edit Lodge') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('lodges.update', $lodge->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label required">{{ __('Name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required maxlength="60" minlength="3" value="{{ $lodge->name }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="facility-trixFields" class="form-label required">{{ __('Facilities') }}</label>
                                @trix($lodge->facility, 'content', ['hideTools' => ['text-tools', 'file-tools'], 'hideButtonIcons' => ['heading-1', 'quote', 'code', 'decrease-nesting-level', 'increase-nesting-level']])
                                @error('facility-trixFields')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="lodge-trixFields" class="form-label required">{{ __('Description') }}</label>
                                @trix($lodge, 'content', ['hideTools' => ['text-tools', 'file-tools'], 'hideButtonIcons' => ['heading-1', 'quote', 'code', 'decrease-nesting-level', 'increase-nesting-level']])
                                @error('lodge-trixFields')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Back and Update button --}}
                        <div class="d-block text-end mt-3 mb-2">
                            {{-- Image management link --}}
                            <a href="{{ route('lodges.images', $lodge->slug) }}" class="btn btn-sm btn-link">{{ __('Manage Images') }}</a>
                            {{-- Back and Update button --}}
                            <a href="{{ route('lodges.show', $lodge->slug) }}" class="btn bg-gradient-secondary w-25 mx-2">{{ __('Back') }}</a>
                            <button type="submit" class="btn bg-gradient-primary w-30 mx-2">{{ __('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
