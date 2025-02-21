<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Department;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['department','addedBy'])->latest()->get();
        return view('pages.services.index', compact('services'));
    }

    public function create()
    {
        $departments = Department::latest()->get();
        return view('pages.services.create', compact('departments'));
    }

    public function store(ServiceRequest $request)
    {
        $employee = $request->validated();
        $employee['added_by'] = Auth::user()->id;
        Service::create($employee);
        return redirect()->route('admin.services.index')->with(['success' => 'Service is created successfully']);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $service = Service::find($id);
        $departments = Department::latest()->get();
        return view('pages.services.edit', compact('service','departments'));
    }

    public function update(ServiceRequest $request, $id)
    {
        $employee = Service::find($id);
        $employee->update($request->validated());
        return redirect()->route('admin.services.index')->with(['success' => 'Service is updated successfully']);
    }

    public function destroy($id)
    {
        Service::find($id)->delete();
        return response()->json([
            'success' => 'true',
            'message' => 'Service is deleted successfully'
        ]);
    }
}
