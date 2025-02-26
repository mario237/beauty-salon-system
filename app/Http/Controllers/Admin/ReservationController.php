<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CustomerSource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReservationRequest;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            return response()->json(['message' => 'Reservation added successfully!'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Reservation $reservation)
    {
    }

    public function edit(Reservation $reservation)
    {
    }

    public function update(Request $request, Reservation $reservation)
    {
    }

    public function destroy(Reservation $reservation)
    {
    }
}
