<?php


namespace App\Http\Controllers;


use App\Models\Day;
use Illuminate\Support\Facades\Auth;

class DayController extends Controller
{
    public function store($doctor_id, $date)
    {
        $day = new Day();
        $day->date = $date;
        $day->doctor_id = $doctor_id;
        $day->patient_id = Auth::id();
        $day->save();

        return response()->json([], 201);
    }
}
