<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reservation;

class ReservationController extends Controller
{
    private const services = [
        'consulta' => 'Consulta médica',
        'corte' => 'Corte de cabello',
        'masaje' => 'Masaje relajante',
        'dentista' => 'Revision dental',
    ];

    private const slots = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00',];

    public function index(Request $request)
    {
       $date = $request->get('date', now()->format('Y-m-d'));
       $service = $request->get('service');
       $booked = Reservation::where('date', $date)->where('service', $service)->pluck('slot')->all();

       return view('exercises.reservations.index', [
           'services' => self::services,
           'slots' => self::slots,
           'reservations' => Reservation::latest('date')->get(),
           'selectedDate' => $date,
            'bookedSlots' => $booked,
       ]);
    }

    public function store (Request $request)
    {
        $data = $request->validate([
            'name'=> 'required|string|max:255',
            'service' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'slot' => 'required|string',
        ]);

        $exists = Reservation::whereDate('date', $data['date'])
            ->where('slot', $data['slot'])->where('service', $data['service'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['slot' => 'El horario seleccionado ya está reservado.'])->withInput();
        }

        Reservation::create([
            'name' => $data['name'],
            'service' => $data['service'],
            'service_name' => self::services[$data['service']] ?? $data['service'],
            'date' => $data['date'],
            'slot' => $data['slot'],
            'confirmed' => true,
        ]);

        return back()->with('success', 'Reserva creada exitosamente.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return back()->with('success', 'Reserva eliminada exitosamente.');
    }
}
