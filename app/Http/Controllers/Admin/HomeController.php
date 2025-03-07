<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

class HomeController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('customer')->get()->map(function ($reservation) {
            return [
                'id' => $reservation->id,
                'title' => $reservation->customer->name ?? 'Reservation',
                'start' => $reservation->start_datetime,
                'end' => $reservation->end_datetime ?? $reservation->start_datetime,
                'color' => $reservation->status === 'confirmed' ? '#28a745' : '#dc3545', // Green for confirmed, Red for pending
                'status' => $reservation->status,
                'allDay' => !$reservation->end_datetime, // If no end time, treat as all-day event
                'extendedProps' => [
                    'customer_phone' => $reservation->customer->phone_number ?? '',
                    'customer_email' => $reservation->customer->email ?? '',
                    'notes' => $reservation->notes ?? ''
                ]
            ];
        });

        return view('dashboard', compact('reservations'));
    }
}
