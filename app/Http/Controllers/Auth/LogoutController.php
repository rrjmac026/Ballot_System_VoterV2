<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class LogoutController extends Controller
{
    public function logout()
    {
        Auth::logout();
        Session::flush();
        
        return redirect()->route('google.switch-account');
    }
}
