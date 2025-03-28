<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->latest()->get();
        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::isActive()->get();
        return view('pages.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();
            $data['added_by'] = Auth::user()->id;
            $product = Product::create($data);

            // Attach categories
            $product->categories()->attach($request->categories);

            // Handle images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $product->images()->create(['image_path' => $path]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => trans('general.model_is_created_successfully', ['model' => trans('general.product')]),
                'redirect' => route('admin.products.index')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => trans('general.error_occurred_while_action_on_model', ['action' => trans('general.create'), 'model' => trans('general.product')]),
            ], 500);
        }
    }

    public function show(Product $product)
    {
        $product = Product::with(['categories', 'images'])->findOrFail($product->id);
        return view('pages.products.show', compact('product'));
    }


    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        $product->categories()->sync($request->categories);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success',
            trans('general.model_is_updated_successfully', ['model' => trans('general.product')])
        );
    }

    public function removeImage($id)
    {
        $image = ProductImage::findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => trans('general.image_deleted_success')]);
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('pages.products.index')->with('success',
            trans('general.model_is_deleted_successfully', ['model' => trans('general.product')])
        );
    }
}
