<?php


namespace App\Http\Controllers;


use App\Models\Specialty;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::all();

        return response()->json($specialties);
    }

    public function getById($id)
    {
        $specialties = Specialty::where('id' , $id)->get();
        return response()->json($specialties);
    }
}
