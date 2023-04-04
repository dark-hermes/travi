@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Reservations</h5>
                        </div>
                    </div>
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
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Date
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tour Package
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Cust Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Price
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Qty
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Discount
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Total
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Paid At
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
                                @foreach ($reservations as $reservation)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $reservation->id }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            {{-- Upload Payment Evidence --}}
                                            @can('reservation-payment')
                                                @if ($reservation->status == 'pending')
                                                    <form action={{ route('reservations.upload-payment', $reservation->id) }} method="POST" class="d-inline" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="file" name="payment_evidence" id="payment_evidence" class="d-none" accept="image/*" onchange="document.getElementById('upload').click()">
                                                        <button type="button" class="btn btn-link text-info px-3 mb-0" data-bs-toggle="tooltip" title="Upload Payment Evidence" onclick="document.getElementById('payment_evidence').click()"><i class="bx bx-upload fs-5"></i></button>
                                                        <button type="submit" class="d-none" id="upload">
                                                            {{ __('Upload') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
                                            @can('reservation-cancel')
                                                @if ($reservation->status == 'pending')
                                                    <form action={{ route('reservations.cancel-reservation', $reservation->id) }} method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-link text-danger px-3 mb-0 cancel-confirm" data-bs-toggle="tooltip" title="Cancel"><i class="bx bx-x fs-5"></i></button>
                                                    </form>
                                                @endif
                                            @endcan
                                            @can('reservation-edit')
                                                <a href={{ route('reservations.edit', $reservation->id) }} class="btn btn-link text-info px-3 mb-0" data-bs-toggle="tooltip" title="Edit"><i class="bx bx-edit fs-5"></i></a>
                                            @endcan
                                            @can('reservation-delete')
                                                <form action={{ route('reservations.destroy', $reservation->id) }} method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-link text-danger px-3 mb-0 delete-confirm" data-bs-toggle="tooltip" title="Delete"><i class="bx bx-trash fs-5"></i></button>
                                                </form>
                                            @endcan
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($reservation->status == 'pending')
                                                <span class="badge badge-sm bg-gradient-warning">{{ $reservation->status }}</span>
                                            @elseif ($reservation->status == 'paid')
                                                <span class="badge badge-sm bg-gradient-success">{{ $reservation->status }}</span>
                                            @elseif ($reservation->status == 'canceled')
                                                <span class="badge badge-sm bg-gradient-danger">{{ $reservation->status }}</span>
                                            @elseif ($reservation->status == 'finished')
                                                <span class="badge badge-sm bg-gradient-info">{{ $reservation->status }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $reservation->date }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $reservation->tourPackage->name }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $reservation->customer->user->name }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-secondary text-xs font-weight-bold">Rp {{ number_format($reservation->price, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $reservation->quantity }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $reservation->discount }}%</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $reservation->payment_date }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $reservation->created_at }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $reservation->updated_at }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Pagination to the right --}}
                <div class="d-flex justify-content-end mx-4">
                    {{ $reservations->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection
