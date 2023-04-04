<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use App\Models\Lodge;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LodgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $lodges = Lodge::orderBy('updated_at', 'desc')
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
            ->paginate(8);

        return view('admin.lodges.index', compact('lodges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.lodges.create');
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
            'lodge-trixFields' => 'required',
            'facility-trixFields' => 'required',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'lodge-trixFields.required' => 'The lodge description field is required.',
            'facility-trixFields.required' => 'The facility description field is required.',
        ]);

        try {
            $lodge = Lodge::create([
                'name' => $request->name,
                'lodge-trixFields' => $request->input('lodge-trixFields'),
            ]);
            $lodge->facility()->create([
                'facility-trixFields' => $request->input('facility-trixFields'),
            ]);

            $dir = "lodges/{$lodge->id}";
            foreach ($request->file('images') as $image) {
                Image::store($image, $dir, $lodge);
            }

            return redirect()->route('lodges.index')->with('success', 'Lodge created successfully.');
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
            $lodge = Lodge::findOrFail($id);
            $dir = "lodge/{$lodge->id}";
            foreach ($request->file('images') as $image) {
                Image::store($image, $dir, $lodge);
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
            $lodge = Lodge::where('slug', $slug)->firstOrFail();
            return view('admin.lodges.show', compact('lodge'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function showImage(string $slug)
    {
        try {
            $lodge = Lodge::where('slug', $slug)->firstOrFail();
            return view('admin.lodges.show-image', compact('lodge'));
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
            $lodge = Lodge::where('slug', $slug)->firstOrFail();
            return view('admin.lodges.edit', compact('lodge'));
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
            'lodge-trixFields' => 'required',
            'facility-trixFields' => 'required',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'lodge-trixFields.required' => 'The lodge description field is required.',
            'facility-trixFields.required' => 'The facility description field is required.',
        ]);

        try {
            $lodge = Lodge::findOrFail($id);
            $lodge->update([
                'name' => $request->name,
                'lodge-trixFields' => $request->input('lodge-trixFields'),
            ]);
            $facility = Facility::where('facilityable_type', 'App\Models\Lodge')
                ->where('facilityable_id', $lodge->id)
                ->firstOrFail();
            $facility->update([
                'facility-trixFields' => $request->input('facility-trixFields'),
            ]);
            return redirect()->route('lodges.show', $lodge->slug)->with('success', 'Lodge updated successfully.');
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
            Lodge::findOrFail($id)->delete();
            return redirect()->route('lodges.index')->with('success', 'Lodge deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroyImage(string $id)
    {
        try {
            $image = Image::findOrFail($id);
            Image::purge($image);
            return redirect()->back()->with('success', 'Image deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
