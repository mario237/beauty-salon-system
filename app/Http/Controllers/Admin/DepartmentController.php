<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CustomerSource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerRequest;
use App\Http\Requests\Admin\DepartmentRequest;
use App\Models\Customer;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('addedBy')->latest()->get();
        return view('pages.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('pages.departments.create');
    }

    public function store(DepartmentRequest $request)
    {
        $department = $request->validated();
        $department['added_by'] = Auth::user()->id;
        Department::create($department);
        return redirect()->route('admin.departments.index')->with(['success' => 'Department is created successfully']);
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('pages.departments.edit', compact('department'));
    }

    public function update(DepartmentRequest $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->update($request->validated());
        return redirect()->route('admin.departments.index')->with(['success' => 'Department is updated successfully']);
    }

    public function destroy($id)
    {
        Department::find($id)->delete();
        return response()->json([
            'success' => 'true',
            'message' => 'Department is deleted successfully'
        ]);
    }
}
