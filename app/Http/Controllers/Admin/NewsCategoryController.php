<?php

namespace App\Http\Controllers\Admin;

use App\Models\NewsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $newsCategories = NewsCategory::where('name', 'like', "%{$search}%")
            ->paginate(10);
        return view('admin.news.categories.index', compact('newsCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:news_categories,name',
        ]);

        try {
            NewsCategory::create($request->all());
            return redirect()->route('news-categories.index')->with('success', 'News category created successfully');
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
            $newsCategory = NewsCategory::findOrFail($id);
            return view('admin.news.categories.show', compact('newsCategory'));
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
            $newsCategory = NewsCategory::findOrFail($id);
            return view('admin.news.categories.edit', compact('newsCategory'));
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
            'name' => 'required|unique:news_categories,name,' . $id,
        ]);

        try {
            $newsCategory = NewsCategory::findOrFail($id);
            $newsCategory->update($request->all());
            return redirect()->route('news-categories.index')->with('success', 'News category updated successfully');
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
            $newsCategory = NewsCategory::findOrFail($id);
            $newsCategory->delete();
            return redirect()->route('news-categories.index')->with('success', 'News category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
