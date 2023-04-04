@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Create User') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name" class="form-control-label required">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-control-label required">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
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
                    {{-- Role --}}
                    <div class="form-group">
                        <label for="role" class="form-control-label required">{{ __('Role') }}</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="" selected disabled>{{ __('Select Role') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ str($role->name)->title() }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Back and Update button --}}
                    <div class="d-block text-end">
                        <a href="{{ route('users.index') }}" class="btn bg-gradient-dark w-25 mx-2 mb-2">{{ __('Back') }}</a>
                        <button type="submit" class="btn bg-gradient-primary w-30 mx-2 mb-2">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

