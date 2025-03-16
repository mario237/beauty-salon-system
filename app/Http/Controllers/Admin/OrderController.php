<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer', 'products')->latest()->paginate(10);
        return view('pages.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('pages.orders.create', compact('customers', 'products'));
    }

    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();

            // Calculate order subtotal and total
            $subtotal = 0;
            foreach ($request->products as $product) {
                $lineTotal = $product['quantity'] * $product['price'];

                // Apply product-level discount if provided
                if (isset($product['discount']) && $product['discount'] > 0) {
                    if ($product['discount_type'] === 'percentage') {
                        $lineTotal -= ($lineTotal * ($product['discount'] / 100));
                    } else {
                        $lineTotal -= $product['discount'];
                    }
                }

                $subtotal += $lineTotal;
            }

            // Apply order-level discount
            $total = $subtotal;
            if ($request->discount > 0) {
                if ($request->discount_type === 'percentage') {
                    $total = $subtotal - ($subtotal * ($request->discount / 100));
                } else {
                    $total = $subtotal - $request->discount;
                }
            }

            // Create order record
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'subtotal' => $subtotal,
                'discount' => $request->discount ?? 0,
                'discount_type' => $request->discount_type ?? 'flat',
                'total_price' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'notes' => $request->notes,
                'status' => 'pending'
            ]);

            // Create order products
            foreach ($request->products as $product) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'discount' => $product['discount'] ?? 0,
                    'discount_type' => $product['discount_type'] ?? 'flat'
                ]);

                // Update product stock if needed
                $productModel = Product::find($product['id']);
                if (property_exists($productModel, 'track_stock') && $productModel->track_stock) {
                    $productModel->decrement('stock', $product['quantity']);
                }
            }

            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'redirect' => route('admin.orders.show', $order->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Order creation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Order $order)
    {
        return view('pages.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('pages.orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(OrderRequest $request, Order $order)
    {
        try {
            DB::beginTransaction();

            // Calculate order subtotal and total
            $subtotal = 0;
            foreach ($request->products as $product) {
                $lineTotal = $product['quantity'] * $product['price'];

                // Apply product-level discount if provided
                if (isset($product['discount']) && $product['discount'] > 0) {
                    if ($product['discount_type'] === 'percentage') {
                        $lineTotal -= ($lineTotal * ($product['discount'] / 100));
                    } else {
                        $lineTotal -= $product['discount'];
                    }
                }

                $subtotal += $lineTotal;
            }

            // Apply order-level discount
            $total = $subtotal;
            if ($request->discount > 0) {
                if ($request->discount_type === 'percentage') {
                    $total = $subtotal - ($subtotal * ($request->discount / 100));
                } else {
                    $total = $subtotal - $request->discount;
                }
            }

            // Update order record
            $order->update([
                'customer_id' => $request->customer_id,
                'subtotal' => $subtotal,
                'discount' => $request->discount ?? 0,
                'discount_type' => $request->discount_type ?? 'flat',
                'total_price' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'notes' => $request->notes,
                'status' => $order->status // Keep the existing status or update if needed
            ]);

            // Sync order products
            $orderProducts = [];
            foreach ($request->products as $product) {
                $orderProducts[$product['id']] = [
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'discount' => $product['discount'] ?? 0,
                    'discount_type' => $product['discount_type'] ?? 'flat'
                ];

                // Update product stock if needed
                $productModel = Product::find($product['id']);
                if (property_exists($productModel, 'track_stock') && $productModel->track_stock) {
                    // Restore the old quantity first (if needed)
                    $oldProduct = $order->products()->where('product_id', $product['id'])->first();
                    if ($oldProduct) {
                        $productModel->increment('stock', $oldProduct->pivot->quantity);
                    }

                    // Deduct the new quantity
                    $productModel->decrement('stock', $product['quantity']);
                }
            }

            // Sync order products (this will remove old products and add new ones)
            $order->products()->sync($orderProducts);

            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully',
                'redirect' => route('admin.orders.show', $order->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order update failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Order update failed: ' . $e->getMessage()
            ], 500);
        }
    }
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
