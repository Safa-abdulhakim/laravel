<?php

namespace App\Http\Controllers;

use App\Models\CareerPath;
use App\Models\LearningResource;
use App\Models\Skill;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPaths = CareerPath::where('status', 'active')
            ->withCount(['stages', 'skills'])
            ->orderByDesc('enrolled_count')
            ->take(6)
            ->get();

        $stats = [
            'total_paths' => CareerPath::where('status', 'active')->count(),
            'total_skills' => Skill::count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_resources' => LearningResource::count(),
        ];

        return view('home', compact('featuredPaths', 'stats'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
