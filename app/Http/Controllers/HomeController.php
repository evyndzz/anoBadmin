<?php

namespace App\Http\Controllers;

use App\Models\Court;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $courts = Court::where('is_active', true)->get();
        
        $ownedVouchers = collect();
        if (auth()->check()) {
            $ownedVouchers = auth()->user()->promos()->wherePivot('is_used', false)->get();
        }

        return view('welcome', compact('courts', 'ownedVouchers'));
    }

    public function showCourt(Court $court)
    {
        return view('courts.show', compact('court'));
    }
}
