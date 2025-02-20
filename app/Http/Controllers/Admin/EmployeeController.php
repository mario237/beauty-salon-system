<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['department','addedBy'])->latest()->get();
        return view('pages.employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::latest()->get();
        return view('pages.employees.create', compact('departments'));
    }

    public function store(EmployeeRequest $request)
    {
        $employee = $request->validated();
        $employee['added_by'] = Auth::user()->id;
        Employee::create($employee);
        return redirect()->route('admin.employees.index')->with(['success' => 'Employee is created successfully']);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        $departments = Department::latest()->get();
        return view('pages.employees.edit', compact('employee','departments'));
    }

    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::find($id);
        $employee->update($request->validated());
        return redirect()->route('admin.employees.index')->with(['success' => 'Employee is updated successfully']);
    }

    public function destroy($id)
    {
        Employee::find($id)->delete();
        return response()->json([
            'success' => 'true',
            'message' => 'Employee is deleted successfully'
        ]);
    }
}
