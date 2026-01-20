<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')
            ->where('is_approved', true)
            ->latest()
            ->take(3)
            ->get();

        return view('welcome', compact('reviews'));
    }
}
