<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReservationsExport;
use App\Models\Image;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public $sortable;
    public $statuses;

    public function __construct()
    {
        $this->middleware('permission:reservation-list|reservation-create|reservation-edit|reservation-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:reservation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:reservation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:reservation-delete', ['only' => ['destroy']]);

        $this->sortable = [
            'date',
            'quantity',
            'price',
            'discount',
        ];

        $this->statuses = [
            'pending',
            'paid',
            'canceled',
            'finished',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sort = $request->query('sort');
        $order = $request->query('order');
        $status = $request->query('status');
        $export = $request->query('export');

        $sort = in_array($sort, $this->sortable) ? $sort : 'updated_at';
        $order = ! in_array($order, ['asc', 'desc']) ? 'desc' : $order;
        $status = in_array($status, $this->statuses) ? $status : null;
        $export = $export === 'true' ? true : false;

        $isCustomer = auth()->user()->hasRole('customer');

        $reservations = Reservation::orderBy($sort, $order)
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereRelation('tourPackage', 'name', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($query) use ($search) {
                        return $query->whereHas('user', function ($query) use ($search) {
                            return $query->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->orWhereHas('customer', function ($query) use ($search) {
                        return $query->whereHas('user', function ($query) use ($search) {
                            return $query->where('email', 'like', "%{$search}%");
                        });
                    })
                    ->orWhereHas('customer', function ($query) use ($search) {
                        return $query->whereHas('user', function ($query) use ($search) {
                            return $query->where('phone', 'like', "%{$search}%");
                        });
                    })
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhere('discount', 'like', "%{$search}%")
                    ->orWhere('quantity', 'like', "%{$search}%");
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($isCustomer, function ($query) {
                return $query->whereHas('customer', function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                });
            });
            // ->when($export, function ($query) {
            //     dd('export');
            //     $reservationsQuery = $query->get();
            //     $reservationsExport = new ReservationsExport($reservationsQuery);

            //     return $reservationsExport->download('reservations_ ' . date('Y-m-d H:i:s') . '.xlsx');
            // })

        if ($export) {
            $reservationsQuery = $reservations->get();
            $reservationsExport = new ReservationsExport($reservationsQuery);

            return $reservationsExport->download('reservations_ ' . date('Y-m-d H:i:s') . '.xlsx');
        }

        $reservations = $reservations->paginate(15);

        return view('admin.reservations.index', [
            'reservations' => $reservations,
            'sortable' => $this->sortable,
            'statuses' => $this->statuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $reservation = Reservation::findOrFail($id);

            return view('admin.reservations.show', [
                'reservation' => $reservation,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('reservations.index')->with('error', 'Reservation not found.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $reservation = Reservation::findOrFail($id);

            return view('admin.reservations.edit', [
                'reservation' => $reservation,
                'statuses' => $this->statuses,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('reservations.index')->with('error', 'Reservation not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            'payment_evidence' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'payment_date' => 'nullable|date|after_or_equal:today',
            'discount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,canceled,finished',
        ]);

        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->update($request->all());
            return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('reservations.index')->with('error', 'Reservation not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();
            return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('reservations.index')->with('error', 'Reservation not found.');
        }
    }

    public function uploadPayment(Request $request, string $id)
    {
        $request->validate([
            'payment_evidence' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $reservation = Reservation::findOrFail($id);
            $file = $request->file('payment_evidence');
            $newName = time() . str()->random(8) . $id  . '.' . $file->getClientOriginalExtension();

            while (Image::where('path', $newName)->exists()) {
                $newName = time() . str()->random(8) . $id  . '.' . $file->getClientOriginalExtension();
            }

            $dir = "payment_evidences/{$id}";
            $file->move(storage_path('app/public/' . $dir), $newName);
            $reservation->update([
                'payment_evidence' => 'storage/' . $dir . '/' . $newName,
                'payment_date' => now()->format('Y-m-d H:i:s'),
                'status' => 'paid',
            ]);
            return redirect()->back()->with('success', 'Payment evidence uploaded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Reservation not found.');
        }
    }

    public function cancelReservation(string $id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->update([
                'status' => 'canceled',
            ]);
            return redirect()->back()->with('success', 'Reservation canceled successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Reservation not found.');
        }
    }

    public function createReservation(string $tourPackageId)
    {
        try {
            $tourPackage = TourPackage::findOrFail($tourPackageId);
            return view('admin.reservations.create', [
                'tourPackage' => $tourPackage,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('tour-packages.index')->with('error', 'Tour package not found.');
        }
    }

    public function storeReservation(Request $request, string $tourPackageId)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'quantity' => 'required|numeric|min:1',
        ]);

        try {
            $tourPackage = TourPackage::findOrFail($request->tour_package_id);
            $customer = Customer::where('user_id', auth()->user()->id)->firstOrFail();

            $reservation = Reservation::create([
                'customer_id' => $customer->id,
                'tour_package_id' => $tourPackage->id,
                'date' => $request->date,
                'quantity' => $request->quantity,
                'price' => $tourPackage->price,
                'discount' => $tourPackage->discount,
                'status' => 'pending',
            ]);

            return redirect()->route('reservations.index')->with('success', 'Reservation created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tour-packages.show', $tourPackageId)->with('error', 'Tour package not found.');
        }
    }
}
