<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['services', 'addedBy'])->latest()->get();
        return view('pages.employees.index', compact('employees'));
    }

    public function create()
    {
        $services = Service::all();
        return view('pages.employees.create', compact('services'));
    }

    public function store(EmployeeRequest $request)
    {
        $data = $request->validated();
        $data['added_by'] = Auth::user()->id;
        $employee = Employee::create($data);
        $employee->services()->sync($request->services);
        return redirect()->route('admin.employees.index')->with(['success' => 'Employee is created successfully']);
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $services = Service::all();
        return view('pages.employees.edit', compact('employee', 'services'));
    }

    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->validated());
        $employee->services()->sync($request->services);
        return redirect()->route('admin.employees.index')->with(['success' => 'Employee is updated successfully']);
    }

    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return response()->json([
            'success' => 'true',
            'message' => 'Employee is deleted successfully'
        ]);
    }
}
