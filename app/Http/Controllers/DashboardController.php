<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::all(); 
        return view('dashboard', compact('feedbacks'));
    }   
}
