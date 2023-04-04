@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Edit Employee') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                {{-- Show image in center and two buttons below for upload and delete image --}}
                <div class="d-flex justify-content-center">
                    <div class="avatar avatar-xl">
                        <img src="{{ $employee->image_path }}" alt="..." class="avatar avatar-xl me-3">
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <div class="btn-group">
                        <form action="{{ route('users.store-image', $employee->id) }}" method="POST" enctype="multipart/form-data">
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
                <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name" class="form-control-label required">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="ex: John Doe" value="{{ $employee->name }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-control-label required">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="ex: johndoe@gmail.com" value="{{ $employee->email }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Roles --}}
                    <div class="form-group">
                        <label for="roles" class="form-control-label required">{{ __('Roles') }}</label>
                        <select name="role" id="role" class="form-control" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $employee->hasRole($role->name) ? 'selected' : '' }}>{{ str()->title($role->name) }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Phone --}}
                    <div class="form-group">
                        <label for="phone" class="form-control-label required">{{ __('Phone') }}</label>
                        <input type="tel" name="phone" id="phone" class="form-control" placeholder="08xxxxxxxxxx" value="{{ $employee->phone }}" minlength="10" maxlength="15">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Address --}}
                    <div class="form-group">
                        <label for="address" class="form-control-label required">{{ __('Address') }}</label>
                        <textarea name="address" id="address" class="form-control" placeholder="ex: Jl. Raya No. 1, Kec. Kecamatan, Kab. Kabupaten, Provinsi" rows="3">{{ $employee->address }}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Back and Update button --}}
                    <div class="d-block text-end">
                        <a href="{{ route('employees.edit-password', $employee->id) }}" class="btn btn-sm btn-link text-primary">{{ __('Click here to change password') }}</a>
                        <a href="{{ route('employees.index') }}" class="btn bg-gradient-dark w-25 mx-2 mb-2">{{ __('Back') }}</a>
                        <button type="submit" class="btn bg-gradient-primary w-25 mx-2 mb-2">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
