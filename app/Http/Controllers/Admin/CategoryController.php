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
            return redirect()->route('admin.categories.index')->with(['success' =>
                trans('general.model_is_created_successfully', ['model' => trans('general.category')])
            ]);
        } catch (Throwable) {
            DB::rollBack();
            return redirect()->back()->with(['error' =>
            trans('general.error_occurred_while_action_on_model', ['action' => trans('general.create') , 'model' =>  trans('general.category')])
            ]);
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
            return redirect()->route('admin.categories.index')->with(['success' =>
                trans('general.model_is_updated_successfully', ['model' => trans('general.category')])
            ]);
        } catch (Throwable) {
            DB::rollBack();
            return redirect()->back()->with(['error' =>
                trans('general.error_occurred_while_action_on_model', ['action' => trans('general.update') , 'model' =>  trans('general.category')])
            ]);
        }
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
        return response()->json([
            'success' => 'true',
            'message' =>  trans('general.model_is_deleted_successfully', ['model' => trans('general.category')])
        ]);
    }
}
