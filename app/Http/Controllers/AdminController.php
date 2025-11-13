<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Vervang door een view als je die hebt: return view('admin.dashboard');
        return response('Admin dashboard - welkom', 200);
    }
}
