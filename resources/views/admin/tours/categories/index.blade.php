@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Tour Categories</h5>
                        </div>
                        <a href={{ route('tour-categories.create') }} class="btn bg-gradient-primary btn-sm">+&nbsp;Add</a>
                    </div>
                    <form action="{{ route('tour-categories.index') }}" method="GET">
                        <div class="input-group-sm">
                            {{-- Submit when enter pressed --}}
                            <input type="text" name="search" class="form-control" placeholder="Search . . ." value="{{ request()->query('search') }}" onkeypress="if(event.keyCode == 13) { event.preventDefault(); this.form.submit(); }">
                        </div>
                    </form>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table table-hover align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Category
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Created At
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Updated At
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tourCategories as $tourCategory)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $tourCategory->id }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href={{ route('tour-categories.edit', $tourCategory->id) }} class="btn btn-link text-info px-3 mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="bx bx-edit fs-5"></i></a>
                                            <form action={{ route('tour-categories.destroy', $tourCategory->id) }} method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-link text-danger px-3 mb-0 delete-confirm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bx bx-trash fs-5"></i></button>
                                            </form>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-secondary text-xs font-weight-bold">{{ str()->title($tourCategory->name) }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $tourCategory->created_at }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $tourCategory->updated_at }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Pagination to the right --}}
                <div class="d-flex justify-content-end mx-4">
                    {{ $tourCategories->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection
