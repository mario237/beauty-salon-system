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
            return redirect()->route('admin.customers.index')->with(['success' =>
                trans('general.model_is_created_successfully', ['model' => trans('general.customer')])
            ]);
        }catch (Throwable $throwable){
            DB::rollBack();
            return redirect()->back()->with(['error' =>
                trans('general.error_occurred_while_action_on_model', ['action' => trans('general.create'), 'model' => trans('general.customer')])
            ]);
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
            DB::commit();
            return redirect()->route('admin.customers.index')->with(['success' =>
                trans('general.model_is_updated_successfully', ['model' => trans('general.customer')])
            ]);
        }catch (Throwable){
            DB::rollBack();
            return redirect()->back()->with(['error' =>
                trans('general.error_occurred_while_action_on_model', ['action' => trans('general.update'), 'model' => trans('general.customer')])
            ]);
        }
    }

    public function destroy($id)
    {
        Customer::find($id)->delete();
        return response()->json([
            'success' => 'true',
            'message' => trans('general.model_is_deleted_successfully', ['model' => trans('general.customer')])
        ]);
    }
}
