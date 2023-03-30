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
                    @if($errors->any())
                        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            {{$errors->first()}}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name" class="form-control-label">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-control-label">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password" class="form-control-label">{{ __('Password') }}</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" value="{{ old('password') }}" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Confirm Password --}}
                    <div class="form-group">
                        <label for="password_confirmation" class="form-control-label">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}" value="{{ old('password_confirmation') }}" required>
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Role --}}
                    <div class="form-group">
                        <label for="role" class="form-control-label">{{ __('Role') }}</label>
                        <select name="role" id="role" class="form-control" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ str($role->name)->title() }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark mt-4 mb-0">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

