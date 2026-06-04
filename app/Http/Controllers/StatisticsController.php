<?php

namespace App\Http\Controllers;

use App\Models\Analysis;

class StatisticsController extends Controller
{
    public function index()
    {
        $stats = [
            'total'          => Analysis::count(),
            'avg_confidence' => Analysis::avgConfidence(),
            'most_common'    => Analysis::mostCommonIndicator() ?? '—',
            'last_analysis'  => Analysis::latest()->first()?->created_at?->diffForHumans() ?? 'لم يتم بعد',
        ];

        $distribution = Analysis::indicatorDistribution();
        $topKeywords  = Analysis::topKeywords(20);
        $dailyStats   = Analysis::dailyStats(14);
        $indicators   = Analysis::indicators();
        $colors       = Analysis::indicatorColors();

        return view('statistics.index', compact(
            'stats', 'distribution', 'topKeywords', 'dailyStats', 'indicators', 'colors'
        ));
    }
}
