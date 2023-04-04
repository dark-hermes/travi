@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Create Role') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name" class="form-control-label required">{{ __('Role Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Permissions Checkboxes --}}
                    <label for="permissions" class="form-control-label">{{ __('Permissions') }}</label>
                    <div class="form-group">
                        @foreach($permissions as $permission)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}">
                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    {{-- Back and Update button --}}
                    <div class="d-block text-end">
                        <a href="{{ route('roles.index') }}" class="btn bg-gradient-dark w-25 mx-2 mb-2">{{ __('Back') }}</a>
                        <button type="submit" class="btn bg-gradient-primary w-30 mx-2 mb-2">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
