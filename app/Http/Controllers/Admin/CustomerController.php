<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CustomerSource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $customer = $request->validated();
        $customer['added_by'] = Auth::user()->id;
        Customer::create($customer);
        return redirect()->route('admin.customers.index')->with(['success' => 'Customer is created successfully']);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        $sources = CustomerSource::values();
        return view('pages.customers.edit', compact('customer','sources'));
    }

    public function update(CustomerRequest $request, $id)
    {
        $customer = Customer::find($id);
        $customer->update($request->validated());
        return redirect()->route('admin.customers.index')->with(['success' => 'Customer is updated successfully']);
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
