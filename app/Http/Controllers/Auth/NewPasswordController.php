<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewPasswordController extends Controller
{
    public function create(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function store(Request $request)
    {
        // TODO: Implement password reset
        return redirect()->route('login');
    }
}