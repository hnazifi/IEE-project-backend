<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        Log::info(json_encode($request->allFiles()));
        Log::info(json_encode($request->all()));
        $user = new User();
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        if ($request->spec)
            $user->specialty_id = $request->spec;
        if ($request->number)
            $user->nezam = $request->number;
        if ($request->online_pay)
            $user->online_pay = ($request->online_pay == 'true');
        if ($request->experience_years)
            $user->experience_years = $request->experience_years;
        if ($request->address)
            $user->address = $request->address;
        if ($request->week_days) {
            $weekDays = [];
            foreach ($request->week_days as $week_day) {
                $weekDays[] = ($week_day === 'true');
            }
            $user->week_days = json_encode($weekDays);
        }
        $user->api_token = Hash::make(random_bytes(5));
        if ($request->image) {
            $path = $request->file('image')->store('public');
            $user->image = $path;
        }
        $user->save();

        return response()->json(['api_token' => $user->api_token], 201);
    }

    public function login(Request $request)
    {
        Log::info($request->all());
        Log::info(Hash::make($request->password));

        try {
            $user = User::where('username', $request->username)->firstOrFail();
            if (!Hash::check($request->password, $user->password))
                return response()->json([], 403);

            return response()->json(['api_token' => $user->api_token]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([], 403);
        }
    }
}
