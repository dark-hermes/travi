<?php

namespace App\Http\Controllers;

use App\Models\TourCategory;
use Illuminate\Http\Request;

class TourCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $tourCategories = TourCategory::where('name', 'like', "%{$search}%")
            ->paginate(10);
        return view('admin.tours.categories.index', compact('tourCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tours.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tour_categories,name',
        ]);

        try {
            TourCategory::create($request->all());
            return redirect()->route('tour-categories.index')->with('success', 'Tour category created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $tourCategory = TourCategory::findOrFail($id);
            return view('admin.tours.categories.show', compact('tourCategory'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $tourCategory = TourCategory::findOrFail($id);
            return view('admin.tours.categories.edit', compact('tourCategory'));
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
            'name' => 'required|unique:tour_categories,name,' . $id,
        ]);

        try {
            $tourCategory = TourCategory::findOrFail($id);
            $tourCategory->update($request->all());
            return redirect()->route('tour-categories.index')->with('success', 'Tour category updated successfully');
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
            $tourCategory = TourCategory::findOrFail($id);
            $tourCategory->delete();
            return redirect()->route('tour-categories.index')->with('success', 'Tour category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
