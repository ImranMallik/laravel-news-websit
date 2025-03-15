<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCategoryCreateRequest;
use App\Http\Requests\AdminCategoryUpdateRequest;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
        // return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $language = Language::where('status', 1)->get();
        return view('admin.category.create', compact('language'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminCategoryCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Generate unique slug
            $slug = Str::slug($validatedData['name']);
            $count = Category::where('slug', $slug)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            // Create category
            $category = Category::create([
                'language' => $validatedData['language'],
                'name' => $validatedData['name'],
                'slug' => $slug,
                'show_at_nav' => $validatedData['show_at_nav'],
                'status' => $validatedData['status'],
            ]);

            return response()->json([
                'success' => true,
                'message' => __('Category created successfully!'),
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Something went wrong. ') . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $language = Language::all();
        return view('admin.category.edit', compact('category', 'language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminCategoryUpdateRequest $request, string $id)
    {
        // dd($request->all());
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->language = $request->language;
        $category->show_at_nav = $request->show_at_nav;
        $category->status = $request->status;
        $category->save();
        // return redirect()->route('admin.category.index')->with('success', __('Category updated successfully!'));
        return response()->json([
            'success' => true,
            'message' => __('Category Updated successfully!'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $language = Category::findOrFail($id);
            if ($language->language === 'en') {
                return response(['status' => 'error', 'message' => __('Can\'t Delete This One')]);
            }
            $language->delete();
            return response()->json([
                'status' => 'success',
                'message' => __('Language deleted successfully!')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 'error',
                'message' => __('Failed to delete language!')
            ]);
        }
    }
}
