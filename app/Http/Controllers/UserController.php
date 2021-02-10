<?php


namespace App\Http\Controllers;


use App\Models\Comment;
use App\Models\Day;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 1)->get();

        return response()->json($users);
    }

    public function getBySpecialty($specialty_id)
    {
        $users = User::where('specialty_id', $specialty_id)->get();

        return response()->json($users);
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([], 404);
        }
        if ($user->role == 0) {
            return response()->json($user);
        }

        $weekDays = json_decode($user->week_days);
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $now = Carbon::now()->addDays($i);
            if ($weekDays[$now->dayOfWeek] && Day::where('date', $now->startOfDay())->where('doctor_id', $id)->count() <= 3) {
                $days[$now->format('Y-m-d')] = 1;
            } else {
                $days[$now->format('Y-m-d')] = 0;
            }
        }

        $comments = Comment::where('doctor_id', $id)->get();

        return response()->json(['user' => $user, 'days' => $days, 'comments' => $comments]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->username = $request->username;
        if ($request->password)
            $user->password = Hash::make($request->password);
        if ($request->spec)
            $user->specialty_id = $request->spec;
        if ($request->number)
            $user->nezam = $request->number;
        if ($request->online_pay)
            $user->online_pay = $request->online_pay;
        if ($request->experience_years)
            $user->experience_years = $request->experience_years;
        if ($request->address)
            $user->address = $request->address;
        if ($request->week_days)
            $user->week_days = json_encode($request->week_days);
        if ($request->image) {
            $path = $request->file('image')->store('user');
            $user->image = $path;
        }
        $user->save();

        return response()->json();
    }

    public function search($query)
    {
        $users = User::where('name', 'like', "%$query%")->get();

        return response()->json($users);
    }

    public function allUser(){
        $users = User::all();
        return response()->json($users);
    }
}
