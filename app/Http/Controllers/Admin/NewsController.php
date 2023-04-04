<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsCategory;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:news-list|news-create|news-edit|news-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:news-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:news-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:news-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');

        $news = News::orderBy('created_at', 'desc')
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('trixRichText', function ($query) use ($search) {
                    return $query->whereFullText('content', $search);
                })
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhereRelation('category', 'name', 'like', "%{$search}%");
            })
            ->when($category, function ($query) use ($category) {
                return $query->whereRelation('category', 'name', $category);
            })
            ->paginate(9);

        $categories = News::select('news_category_id')->distinct()->get()->pluck('category.name');
        return view('admin.news.index', compact('news', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = NewsCategory::all();
            return view('admin.news.create', compact('categories'));
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
            'title' => 'required|min:3|max:60',
            'news_category_id' => 'required|exists:news_categories,id',
            'news-trixFields' => 'required',
        ], [
            'news-trixFields.required' => 'The content field is required.',
        ]);

        try {
            News::create($request->all());
            return redirect()->route('news.index')->with('success', 'News created successfully');
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
            $news = News::where('slug', $slug)->firstOrFail();
            return view('admin.news.show', compact('news'));
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
            $news = News::where('slug', $slug)->firstOrFail();
            $categories = NewsCategory::all();
            return view('admin.news.edit', compact('news', 'categories'));
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
            'title' => 'required|min:3|max:60',
            'news_category_id' => 'required|exists:news_categories,id',
            'news-trixFields' => 'required',
        ]);

        try {
            $news = News::findOrFail($id);
            $news->update($request->all());
            return redirect()->route('news.index')->with('success', 'News updated successfully');
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
            $news = News::findOrFail($id);
            $news->delete();
            return redirect()->route('news.index')->with('success', 'News deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
