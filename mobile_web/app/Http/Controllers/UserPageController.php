<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Suport\Facades\View; // Facade for sharing data
use Illuminate\View\View as ViewResponse; // Correct class for type hinting return values

class UserPageController extends Controller
{
    public function __construct()
    {
        
    }

    public function performance(): ViewResponse
    {
        return view('performance.performance');
    }

    public function leaderboard(): ViewResponse
    {
        return view('leaderboard.leaderboard');
    }
    public function roadmap(): ViewResponse
    {
        return view('roadmap.roadmap');
    }

    
    public function requirement(): ViewResponse
    {
        // return view('requirement.mkt-requirement');
        // return view('requirement.ib-requirement');
        return view('requirement.senior-requirement');
    }

    
    public function home(): ViewResponse
    {
        return view('home.home');
    }

}
