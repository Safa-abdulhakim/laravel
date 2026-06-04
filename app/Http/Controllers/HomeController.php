<?php

namespace App\Http\Controllers;

use App\Models\Analysis;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_analyses' => Analysis::count(),
            'avg_confidence' => Analysis::avgConfidence(),
            'categories'     => count(Analysis::indicators()),
            'most_common'    => Analysis::mostCommonIndicator() ?? 'مؤشرات الاكتئاب',
        ];

        return view('home.index', compact('stats'));
    }
}
