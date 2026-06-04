<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Services\AnalysisService;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function __construct(private AnalysisService $service) {}

    public function index()
    {
        return view('analysis.index');
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'text' => ['required', 'string', 'min:10', 'max:5000'],
        ], [
            'text.required' => 'الرجاء إدخال نص للتحليل.',
            'text.min'      => 'النص قصير جدًا، الرجاء إدخال ما لا يقل عن 10 أحرف.',
            'text.max'      => 'النص طويل جدًا، الحد الأقصى 5000 حرف.',
        ]);

        $result = $this->service->analyze($request->input('text'));

        $analysis = Analysis::create([
            'text'               => $request->input('text'),
            'primary_indicator'  => $result['primary_indicator'],
            'confidence_score'   => $result['confidence_score'],
            'probabilities'      => $result['probabilities'],
            'detected_keywords'  => $result['detected_keywords'],
            'highlighted_segments'=> $result['highlighted_segments'],
            'word_count'         => $result['word_count'],
            'processing_time'    => $result['processing_time'],
        ]);

        return redirect()->route('analysis.results', $analysis->id);
    }

    public function results(Analysis $analysis)
    {
        $indicators = Analysis::indicators();
        $colors     = Analysis::indicatorColors();

        return view('analysis.results', compact('analysis', 'indicators', 'colors'));
    }
}
