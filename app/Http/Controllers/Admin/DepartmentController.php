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
use Illuminate\Support\Facades\DB;
use Throwable;

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
        try {
            DB::beginTransaction();
            $department = $request->validated();
            $department['added_by'] = Auth::user()->id;
            Department::create($department);
            DB::commit();
            return redirect()->route('admin.departments.index')->with(['success' => 'Department is created successfully']);
        } catch (Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Error has been occurred']);
        }
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('pages.departments.edit', compact('department'));
    }

    public function update(DepartmentRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $department = Department::findOrFail($id);
            $department->update($request->validated());
            DB::commit();
            return redirect()->route('admin.departments.index')->with(['success' => 'Department is updated successfully']);
        } catch (Throwable $throwable) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Error has been occurred']);
        }
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
