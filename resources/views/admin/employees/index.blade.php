@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Employees</h5>
                        </div>
                        <a href={{ route('employees.create') }} class="btn bg-gradient-primary btn-sm">+&nbsp;Add</a>
                    </div>
                    <form action="{{ route('employees.index') }}" method="GET">
                        <div class="input-group-sm">
                            {{-- Submit when enter pressed --}}
                            <input type="text" name="search" class="form-control" placeholder="Search . . ." value="{{ request()->query('search') }}" onkeypress="if(event.keyCode == 13) { event.preventDefault(); this.form.submit(); }">
                        </div>
                    </form>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Photo
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Phone
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Role
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Created At
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                <tr>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{ $employee->id }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="d-flex flex-row justify-content-center">
                                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-link text-info px-3 mb-0">
                                                <i class="bx bx-edit-alt fs-5"></i>
                                            </a>
                                            <form action="{{ route('employees.switch-status', $employee->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                @if ($employee->is_active)
                                                    <button class="btn btn-link text-warning px-3 mb-0" type="submit">
                                                        <i class="bx bx-toggle-right fs-5"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-link text-success px-3 mb-0" type="submit">
                                                        <i class="bx bx-toggle-left fs-5"></i>
                                                    </button>
                                                @endif
                                            </form>
                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-link text-danger px-2 mb-0" type="submit">
                                                    <i class="bx bx-trash fs-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ $employee->image_path }}" class="avatar avatar-sm me-3">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="mb-0 text-sm">{{ $employee->name }}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $employee->email }}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $employee->phone }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ str($employee->getRoleNames()[0])->title() }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($employee->is_active)
                                            <span class="badge badge-sm bg-gradient-success">Active</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $employee->created_at }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Pagination to the right --}}
                <div class="d-flex justify-content-end mx-4">
                    {{ $employees->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection
