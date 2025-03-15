<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $category = $request->validated();
            $category['added_by'] = Auth::user()->id;
            Category::create($category);
            DB::commit();
            return redirect()->route('admin.categories.index')->with(['success' => 'Category is created successfully']);
        } catch (Throwable) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Error has been occurred']);
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $category = Category::findOrFail($id);
            $category->update($request->validated());
            DB::commit();
            return redirect()->route('admin.categories.index')->with(['success' => 'Category is updated successfully']);
        } catch (Throwable) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Error has been occurred']);
        }
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
        return response()->json([
            'success' => 'true',
            'message' => 'Category is deleted successfully'
        ]);
    }
}
