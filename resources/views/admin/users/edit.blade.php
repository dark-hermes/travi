@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Edit User') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                {{-- Show image in center and two buttons below for upload and delete image --}}
                <div class="d-flex justify-content-center">
                    <div class="avatar avatar-xl">
                        <img src="{{ $user->image_path }}" alt="..." class="avatar avatar-xl me-3">
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <div class="btn-group">
                        <form action="{{ route('users.store-image', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="image" id="image" class="d-none" accept="image/*" onchange="document.getElementById('upload').click()">
                            {{-- Upload button --}}
                            <button type="button" class="btn btn-sm btn-link" onclick="document.getElementById('image').click()">
                                {{ __('Change Avatar') }}
                            </button>

                            {{-- Disable until image inputed --}}
                            <button type="submit" class="d-none" id="upload">
                                {{ __('Upload') }}
                            </button>
                        </form>
                    </div>
                </div>

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ $user->name }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-control-label">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ $user->email }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Roles --}}
                    <div class="form-group">
                        <label for="roles" class="form-control-label">{{ __('Roles') }}</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="" selected disabled>{{ __('Select Role') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ str()->title($role->name) }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Back and Update button --}}
                    <div class="d-block text-end">
                        <a href="{{ route('users.index') }}" class="btn bg-gradient-dark w-25 mx-2 mb-2">{{ __('Back') }}</a>
                        <button type="submit" class="btn bg-gradient-primary w-25 mx-2 mb-2">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
