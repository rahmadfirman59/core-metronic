<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect('admin');
        }
        auth()->logout();
        return redirect('login');
    }
}
