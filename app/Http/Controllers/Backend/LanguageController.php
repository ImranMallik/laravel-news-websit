<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\LanguageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLanguageStoreRequest;
use App\Http\Requests\AdminLanguageUpdateRequest;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LanguageDataTable $dataTable)
    {
        return $dataTable->render('admin.languages.index');
        // return view('admin.languages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.languages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminLanguageStoreRequest $request)
    {
        $language = Language::create([
            'language' => $request->language,
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'is_default' => $request->default
        ]);

        return response()->json([
            'success' => true,
            'message' => __('Language created successfully!'),
            'data' => $language
        ]);
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
        $edit_data = Language::findOrFail($id);
        $languages = config('language');
        return view('admin.languages.edit', compact('edit_data', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminLanguageUpdateRequest $request, string $id)
    {
        try {
            $language = Language::findOrFail($id);

            // Check if the language already exists
            $exists = Language::where('language', $request->language)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json(['status' => 'error', 'message' => 'The selected language already exists.'], 422);
            }



            // Check if the slug already exists
            $slugExists = Language::where('slug', $request->slug)
                ->where('id', '!=', $id)
                ->exists();

            if ($slugExists) {
                return response()->json(['status' => 'error', 'message' => 'The selected slug is already in use.'], 422);
            }

            // If validation passes, update the record
            $language->update([
                'language' => $request->language,
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
                'is_default' => $request->default,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Language updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $language = Language::findOrFail($id);
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
