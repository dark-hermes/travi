@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Edit Password') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('employees.update-password', $employee->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password" class="form-control-label required">{{ __('Password') }}</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" value="{{ old('password') }}" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Confirm Password --}}
                    <div class="form-group">
                        <label for="password_confirmation" class="form-control-label required">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}" value="{{ old('password_confirmation') }}" required>
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Back and Update button --}}
                    <div class="d-block text-end">
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn bg-gradient-dark w-25 mx-2 mb-2">{{ __('Back') }}</a>
                        <button type="submit" class="btn bg-gradient-primary w-25 mx-2 mb-2">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

