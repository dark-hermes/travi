<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Tour;
use App\Models\Image;
use App\Models\TourCategory;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');

        $tours = Tour::orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereRelation('category', 'name', 'like', "%{$search}%")
                    ->orWhereRelation('facilities', 'name', 'like', "%{$search}%")
                    ->orWhereRelation('facilities', 'description', 'like', "%{$search}%");
            })
            ->when($category, function ($query) use ($category) {
                return $query->whereRelation('category', 'name', $category);
            })
            ->paginate(9);

        $categories = Tour::select('tour_category_id')->distinct()->get()->pluck('category.name');
        return view('admin.tours.index', compact('tours', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = TourCategory::orderBy('name')->get();
            return view('admin.tours.create', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:60',
            'tour-trixFields' => 'required',
            'facility-trixFields' => 'required',
            'tour_category_id' => 'required|exists:tour_categories,id',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'tour-trixFields.required' => 'The tour description field is required.',
            'facility-trixFields.required' => 'The facility description field is required.',
        ]);

        try {
            $tour = Tour::create([
                'name' => $request->name,
                'tour_category_id' => $request->tour_category_id,
                'tour-trixFields' => $request->input('tour-trixFields'),
            ]);
            $tour->facility()->create([
                'facility-trixFields' => $request->input('facility-trixFields')
            ]);

            $dir = "tours/{$tour->id}";
            foreach ($request->file('images') as $image) {
                Image::store($image, $dir, $tour);
            }

            return redirect()->route('tours.index')->with('success', 'Tour created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function storeImage(Request $request, string $id)
    {
        $request->validate([
            'images' => 'required|array|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $tour = Tour::findOrFail($id);
            $dir = "tours/{$tour->id}";
            foreach ($request->file('images') as $image) {
                Image::store($image, $dir, $tour);
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
            $tour = Tour::where('slug', $slug)->firstOrFail();
            return view('admin.tours.show', compact('tour'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function showImage(string $slug)
    {
        try {
            $tour = Tour::where('slug', $slug)->firstOrFail();
            return view('admin.tours.show-image', compact('tour'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        try {
            $tour = Tour::where('slug', $slug)->firstOrFail();
            $categories = TourCategory::orderBy('name')->get();
            return view('admin.tours.edit', compact('tour', 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3|max:60',
            'tour-trixFields' => 'required',
            'facility-trixFields' => 'required',
            'tour_category_id' => 'required|exists:tour_categories,id',
        ], [
            'tour-trixFields.required' => 'The tour description field is required.',
            'facility-trixFields.required' => 'The facility description field is required.',
        ]);

        try {
            $tour = Tour::findOrFail($id);
            $tour->update([
                'name' => $request->name,
                'tour_category_id' => $request->tour_category_id,
                'tour-trixFields' => $request->input('tour-trixFields'),
            ]);
            $facility = Facility::where('facilityable_type', 'App\Models\Tour')
                ->where('facilityable_id', $tour->id)
                ->firstOrFail();
            $facility->update([
                'facility-trixFields' => $request->input('facility-trixFields')
            ]);
            return redirect()->route('tours.show', $tour->slug)->with('success', 'Tour updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tour = Tour::findOrFail($id);
            $tour->delete();
            return redirect()->route('tours.index')->with('success', 'Tour deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
