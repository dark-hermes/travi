<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use App\Models\Facility;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TourPackageController extends Controller
{
    public $sortable;

    public function __construct()
    {
        $this->middleware('permission:tour-package-list|tour-package-create|tour-package-edit|tour-package-delete', ['only' => ['index', 'show', 'showImage']]);
        $this->middleware('permission:tour-package-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tour-package-edit', ['only' => ['edit', 'update', 'storeImage', 'destroyImage']]);
        $this->middleware('permission:tour-package-delete', ['only' => ['destroy']]);

        $this->sortable = [
            'name',
            'price',
            'updated_at',
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

        $sort = in_array($sort, $this->sortable) ? $sort : 'updated_at';
        $order = ! in_array($order, ['asc', 'desc']) ? 'desc' : $order;

        $tourPackages = TourPackage::orderBy($sort, $order)
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('trixRichText', function ($query) use ($search) {
                        return $query->whereFullText('content', $search);
                    })
                    ->orWhereHas('facility', function ($query) use ($search) {
                        return $query->whereHas('trixRichText', function ($query) use ($search) {
                            return $query->whereFullText('content', $search);
                        });
                    });
            })
            ->paginate(16);

        return view('admin.tour-packages.index', [
            'tourPackages' => $tourPackages,
            'search' => $search,
            'sort' => $sort,
            'order' => $order,
            'sortable' => $this->sortable,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sortable = $this->sortable;
        return view('admin.tour-packages.create', compact('sortable'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:60|unique:tour_packages',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'tourpackage-trixFields' => 'required',
            'facility-trixFields' => 'required',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'tourpackage-trixFields.required' => 'The tour package description field is required.',
            'facility-trixFields.required' => 'The facility description field is required.',
        ]);

        try {
            $tourPackage = TourPackage::create([
                'name' => $request->name,
                'price' => $request->price,
                'discount' => $request->discount,
                'tourpackage-trixFields' => $request->input('tourpackage-trixFields'),
            ]);
            $tourPackage->facility()->create([
                'facility-trixFields' => $request->input('facility-trixFields'),
            ]);

            $dir = 'tour-packages/' . $tourPackage->id;
            foreach ($request->file('images') as $image) {
                Image::store($image, $dir, $tourPackage);
            }

            return redirect()->route('tour-packages.index')
                ->with('success', 'Tour package created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tour-packages.index')
                ->with('error', 'Tour package failed to create.');
        }
    }

    public function storeImage(Request $request, string $id)
    {
        $request->validate([
            'images' => 'required|array|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $tourPackage = TourPackage::findOrFail($id);
            $dir = "tour-packages/{$tourPackage->id}";
            foreach ($request->file('images') as $image) {
                Image::store($image, $dir, $tourPackage);
            }

            return redirect()->back()->with('success', 'Image uploaded successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        try {
            $tourPackage = TourPackage::where('slug', $slug)->firstOrFail();
            return view('admin.tour-packages.show', compact('tourPackage'));
        } catch (\Exception $e) {
            return redirect()->route('tour-packages.index')
                ->with('error', 'Tour package not found.');
        }
    }

    public function showImage(string $slug)
    {
        try {
            $tourPackage = TourPackage::where('slug', $slug)->firstOrFail();
            return view('admin.tour-packages.show-image', compact('tourPackage'));
        } catch (\Exception $e) {
            return redirect()->route('tour-packages.index')
                ->with('error', 'Tour package not found.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        try {
            $tourPackage = TourPackage::where('slug', $slug)->firstOrFail();
            $sortable = $this->sortable;
            return view('admin.tour-packages.edit', compact('tourPackage', 'sortable'));
        } catch (\Exception $e) {
            return redirect()->route('tour-packages.index')
                ->with('error', 'Tour package not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3|max:60|unique:tour_packages,name,' . $id,
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'tourpackage-trixFields' => 'required',
            'facility-trixFields' => 'required',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'tourpackage-trixFields.required' => 'The tour package description field is required.',
            'facility-trixFields.required' => 'The facility description field is required.',
        ]);

        try {
            $tourPackage = TourPackage::findOrFail($id);
            $tourPackage->update([
                'name' => $request->name,
                'price' => $request->price,
                'discount' => $request->discount,
                'tourpackage-trixFields' => $request->input('tourpackage-trixFields'),
            ]);
            $facility = Facility::where('facilityable_type', 'App\Models\TourPackage')
                ->where('facilityable_id', $tourPackage->id)
                ->firstOrFail();
            $facility->update([
                'facility-trixFields' => $request->input('facility-trixFields'),
            ]);
            return redirect()->route('tour-packages.show', $tourPackage->slug)
                ->with('success', 'Tour package updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tour-packages.index')
                ->with('error', 'Tour package failed to update.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tourPackage = TourPackage::findOrFail($id);
            $tourPackage->delete();
            return redirect()->route('tour-packages.index')
                ->with('success', 'Tour package deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tour-packages.index')
                ->with('error', 'Tour package failed to delete.');
        }
    }

    public function destroyImage(string $id)
    {
        try {
            $image = Image::findOrFail($id);
            Image::purge($image);
            return redirect()->back()->with('success', 'Image deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
