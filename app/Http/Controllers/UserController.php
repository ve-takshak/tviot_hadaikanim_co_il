<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lawsuit;
use Illuminate\Http\Request;
use App\Models\InsuranceCompany;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function clientLogin()
    {
        return view('auth.client-login');
    }
    public function clientLoginDo(Request $request)
    {
        $request->validate([
            'tz' => 'required|string',
            'vno' => 'required|string',
        ]);

        $user = User::where('tz', $request->tz)
            ->whereHas('lawsuits', function ($query) use ($request) {
                $query->whereHas('car', function ($query) use ($request) {
                    $query->where('license_plate', $request->vno);
                });
            })
            ->first();

        if ($user) {
            Auth::login($user);
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    public function toggleDarkMode(Request $request)
    {
        $user = Auth::user();
        $user->dark_mode = $user->dark_mode == 1 ? 0 : 1;
        $user->save();
        return redirect()->back();
    }

}
