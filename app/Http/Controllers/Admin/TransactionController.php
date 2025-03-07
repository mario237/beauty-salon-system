<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransactionRequest;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $reservation = Reservation::findOrFail($request->reservation_id);

        if ($reservation->status !== 'confirmed') {
            return response()->json(['message' => 'Reservation is not confirmed!'], 400);
        }

        $transaction = $reservation->transactions()->create([
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'paid',
        ]);

        $reservation->update(['status' => 'completed']);

        return response()->json(['message' => 'Payment successful!', 'transaction' => $transaction]);
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
