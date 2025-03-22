<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\Employee;
use App\Models\Reservation;
use App\Models\ReservationService;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

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
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['added_by'] = Auth::user()->id;
            $employee = Employee::create($data);
            $employee->services()->sync($request->services);
            DB::commit();
            return redirect()->route('admin.employees.index')->with(['success' =>
                trans('general.model_is_created_successfully', ['model' => trans('general.employee')])
            ]);
        }catch (Throwable){
            DB::rollBack();
            return redirect()->back()->with(['error' =>
                trans('general.error_occurred_while_action_on_model', ['action' => trans('general.create'), 'model' => trans('general.employee')])
            ]);
        }
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $services = Service::all();
        return view('pages.employees.edit', compact('employee', 'services'));
    }

    public function update(EmployeeRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $employee = Employee::findOrFail($id);
            $employee->update($request->validated());
            $employee->services()->sync($request->services);
            DB::commit();
            return redirect()->route('admin.employees.index')->with(['success' =>
                trans('general.model_is_updated_successfully', ['model' => trans('general.employee')])
            ]);
        }catch (Throwable){
            DB::rollBack();
            return redirect()->back()->with(['error' =>
                trans('general.error_occurred_while_action_on_model', ['action' => trans('general.update'), 'model' => trans('general.employee')])
            ]);
        }

    }

    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return response()->json([
            'success' => 'true',
            'message' => trans('general.model_is_deleted_successfully', ['model' => trans('general.employee')])
        ]);
    }

    public function getAvailableEmployees($serviceId, Request $request)
    {
        $startTime = Carbon::parse($request->query('start_time'));

        // Get employees providing the requested service
        $employees = Employee::whereHas('services', function ($query) use ($serviceId) {
            $query->where('service_id', $serviceId);
        })->get();

        // Filter out employees who have conflicting reservations at the given time
        $availableEmployees = $employees->filter(function ($employee) use ($request, $startTime) {
            return !ReservationService::where('employee_id', $employee->id)
                ->whereHas('reservation', function ($query) use ($startTime) {
                    $query->where('start_datetime', '<', $startTime)
                        ->where('end_datetime', '>', $startTime);
                })
                ->exists();
        });

        return response()->json([
            'count' => count($availableEmployees),
            'list' => $availableEmployees
        ]);
    }
}
