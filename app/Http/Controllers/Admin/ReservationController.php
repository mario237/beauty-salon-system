<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CustomerSource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReservationRequest;
use App\Http\Requests\Admin\ReservationStatusRequest;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\ReservationService;
use App\Models\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['customer', 'addedBy'])->latest()->get();
        return view('pages.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $sources = CustomerSource::values();
        $customers = Customer::all();
        $services = Service::all();
        return view('pages.reservations.create', compact('customers', 'services', 'sources'));
    }

    public function store(ReservationRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();

            $startDatetime = Carbon::parse($request->validated('start_datetime'));

            // Calculate total duration from selected services
            $totalDuration = Service::whereIn('id', $request->services)->sum('duration');

            // Calculate end_datetime
            $endDatetime = $startDatetime->copy()->addMinutes((int)$totalDuration);

            // Create reservation
            $reservation = Reservation::create([
                'customer_id' => $validated['customer_id'],
                'start_datetime' => $startDatetime,
                'end_datetime' => $endDatetime, // Store calculated end_datetime
                'added_by' => auth()->id(),
                'total_price' => 0, // Will be updated
                'status' => 'pending',
            ]);

            $totalPrice = 0;

            // Attach services to reservation
            foreach ($request->services as $index => $serviceId) {
                $service = Service::find($serviceId);
                $amount = $service->price;
                $discount = $request->discount[$index] ?? 0;
                $discountType = $request->discount_type[$index] ?? 'flat';

                if ($discountType === 'percentage') {
                    $discountAmount = ($discount / 100) * $amount;
                } else {
                    $discountAmount = $discount;
                }

                $finalAmount = max($amount - $discountAmount, 0);
                $totalPrice += $finalAmount;

                $reservation->services()->create([
                    'service_id' => $serviceId,
                    'employee_id' => $request->employees[$index] ?? null,
                    'amount' => $finalAmount,
                    'discount' => $discount,
                    'discount_type' => $discountType,
                    'note' => $request->note ?? null,
                ]);
            }

            // Update total price
            $reservation->update(['total_price' => $totalPrice]);

            DB::commit();
            return response()->json(['message' => trans('general.reservation_added_success')], 200);
        } catch (Throwable) {
            DB::rollback();
            return response()->json(['message' => trans('general.error_occurred_while_action_on_model', ['action' => trans('general.create'), 'model' => trans('general.reservation')])]);
        }
    }

    public function show(Reservation $reservation)
    {
        $reservation = Reservation::with(['customer', 'services', 'services.employee', 'transactions'])->findOrFail($reservation->id);
        $isPaid = $reservation->transactions->where('status', 'paid')->count() && $reservation->transactions->sum('amount') >= $reservation->total_price;
        $totalPaid = $reservation->transactions->sum('amount');
        return view('pages.reservations.show', compact('reservation', 'isPaid', 'totalPaid'));
    }

    public function edit($id)
    {
        $reservation = Reservation::with('services')->findOrFail($id);
        $sources = CustomerSource::values();
        $customers = Customer::all();
        $services = Service::all();
        return view('pages.reservations.edit', compact('reservation', 'customers', 'services', 'sources'));
    }

    public function update(ReservationRequest $request, $id)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();

            $reservation = Reservation::findOrFail($id);
            $startDatetime = Carbon::parse($validated['start_datetime']);
            $totalDuration = Service::whereIn('id', $request->services)->sum('duration');
            $endDatetime = $startDatetime->copy()->addMinutes((int)$totalDuration);

            $reservation->update([
                'customer_id' => $validated['customer_id'],
                'start_datetime' => $startDatetime,
                'end_datetime' => $endDatetime,
                'added_by' => auth()->id(),
                'total_price' => 0,
                'status' => 'pending',
            ]);

            $totalPrice = 0;
            $reservation->services()->delete();

            foreach ($request->services as $index => $serviceId) {
                $service = Service::find($serviceId);
                $amount = $service->price;
                $discount = $request->discount[$index] ?? 0;
                $discountType = $request->discount_type[$index] ?? 'flat';

                $discountAmount = ($discountType === 'percentage') ? ($discount / 100) * $amount : $discount;
                $finalAmount = max($amount - $discountAmount, 0);
                $totalPrice += $finalAmount;

                $reservation->services()->create([
                    'service_id' => $serviceId,
                    'employee_id' => $request->employees[$index] ?? null,
                    'amount' => $finalAmount,
                    'discount' => $discount,
                    'discount_type' => $discountType,
                    'note' => $request->note ?? null,
                ]);
            }

            $reservation->update(['total_price' => $totalPrice]);
            DB::commit();
            return response()->json(['message' => trans('general.reservation_updated_success')], 200);
        } catch (Throwable) {
            DB::rollback();
            return response()->json(['message' => trans('general.error_occurred_while_action_on_model', ['action' => trans('general.update'), 'model' => trans('general.reservation')])]);
        }
    }


    public function destroy($id)
    {
        Reservation::find($id)->delete();
        return response()->json([
            'success' => 'true',
            'message' => trans('general.model_is_deleted_successfully', ['model' => trans('general.reservation')])
        ]);
    }

    public function getEmployeeForService($reservationId, $serviceId)
    {
        $employee = ReservationService::where([
            'reservation_id' => $reservationId,
            'service_id' => $serviceId
        ])->first('employee_id');

        return response()->json($employee);
    }

    public function updateStatus(ReservationStatusRequest $request)
    {
        $reservation = Reservation::findOrFail($request->validated('id'));
        $reservation->status = $request->validated('status');
        if ($request->status === 'cancelled') {
            $reservation->cancel_reason = $request->validated('reason');
        }
        $reservation->save();

        return response()->json([
            'message' => trans('general.model_is_modified_successfully', ['model' => trans('general.reservation')])
        ]);
    }
}
