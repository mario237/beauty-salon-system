<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Department;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['department', 'addedBy'])->latest()->get();
        return view('pages.services.index', compact('services'));
    }

    public function create()
    {
        $departments = Department::latest()->get();
        return view('pages.services.create', compact('departments'));
    }

    public function store(ServiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $service = $request->validated();
            $service['added_by'] = Auth::user()->id;
            Service::create($service);
            DB::commit();
            return redirect()->route('admin.services.index')->with(['success' => 'Service is created successfully']);
        } catch (Throwable) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Error has been occurred']);
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $service = Service::find($id);
        $departments = Department::latest()->get();
        return view('pages.services.edit', compact('service', 'departments'));
    }

    public function update(ServiceRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $employee = Service::find($id);
            $employee->update($request->validated());
            DB::commit();
            return redirect()->route('admin.services.index')->with(['success' => 'Service is updated successfully']);
        } catch (Throwable) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Error has been occurred']);

        }
    }

    public
    function destroy($id)
    {
        Service::find($id)->delete();
        return response()->json([
            'success' => 'true',
            'message' => 'Service is deleted successfully'
        ]);
    }
}
