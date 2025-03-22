<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransactionRequest;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class TransactionController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
    }

    public function store(TransactionRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $reservation = Reservation::findOrFail($request->reservation_id);

            if ($reservation->status !== 'confirmed') {
                return response()->json(['message' => trans('general.reservation_is_not_confirmed')], 400);
            }


            $transaction = $reservation->transactions()->create([
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'status' => 'paid',
            ]);

            if ($reservation->transactions->sum('amount') >= $reservation->total_price) {
                $reservation->update(['status' => 'completed']);
            }

            DB::commit();
            return response()->json(['message' => trans('general.payment_successful'), 'transaction' => $transaction]);
        } catch (Throwable $throwable) {
            DB::rollBack();
            return response()->json(['message' => trans('general.error_occurred_while_action_on_model', ['action' => trans('general.create'), 'model' => trans('general.transaction')])]);
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
