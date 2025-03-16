<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CustomerSource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerRequest;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('addedBy')->latest()->get();
        return view('pages.customers.index', compact('customers'));
    }

    public function create()
    {
        $sources = CustomerSource::values();
        return view('pages.customers.create', compact('sources'));
    }

    public function store(CustomerRequest $request)
    {
        try {
            DB::beginTransaction();
            $customer = $request->validated();
            $customer['added_by'] = Auth::user()->id;
            Customer::create($customer);
            DB::commit();
            return redirect()->route('admin.customers.index')->with(['success' => 'Customer is created successfully']);
        }catch (Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Error has been occurred']);
        }
    }

    public function show($id)
    {
        $customer = Customer::with('addedBy')->findOrFail($id);
        return view('pages.customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        $sources = CustomerSource::values();
        return view('pages.customers.edit', compact('customer','sources'));
    }

    public function update(CustomerRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $customer = Customer::find($id);
            $customer->update($request->validated());
            return redirect()->route('admin.customers.index')->with(['success' => 'Customer is updated successfully']);
        }catch (Throwable){
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Error has been occurred']);
        }
    }

    public function destroy($id)
    {
        Customer::find($id)->delete();
        return response()->json([
            'success' => 'true',
            'message' => 'Customer is deleted successfully'
        ]);
    }
}
