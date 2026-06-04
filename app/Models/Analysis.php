<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $fillable = [
        'text',
        'primary_indicator',
        'confidence_score',
        'probabilities',
        'detected_keywords',
        'highlighted_segments',
        'word_count',
        'processing_time',
    ];

    protected $casts = [
        'probabilities'       => 'array',
        'detected_keywords'   => 'array',
        'highlighted_segments'=> 'array',
        'confidence_score'    => 'float',
        'word_count'          => 'integer',
        'processing_time'     => 'float',
    ];

    public static function indicators(): array
    {
        return [
            'depression'    => 'مؤشرات الاكتئاب',
            'anxiety'       => 'مؤشرات القلق',
            'stress'        => 'مؤشرات الضغوط النفسية',
            'bipolar'       => 'مؤشرات ثنائي القطب',
            'schizophrenia' => 'مؤشرات الفصام',
        ];
    }

    public static function indicatorColors(): array
    {
        return [
            'depression'    => '#3B82F6',
            'anxiety'       => '#F59E0B',
            'stress'        => '#F97316',
            'bipolar'       => '#8B5CF6',
            'schizophrenia' => '#EF4444',
        ];
    }

    public function indicatorLabel(): string
    {
        return self::indicators()[$this->primary_indicator] ?? $this->primary_indicator;
    }

    public function confidenceLevel(): string
    {
        return match(true) {
            $this->confidence_score >= 75 => 'high',
            $this->confidence_score >= 50 => 'medium',
            default                       => 'low',
        };
    }

    public function confidenceLabel(): string
    {
        return match($this->confidenceLevel()) {
            'high'   => 'مرتفع',
            'medium' => 'متوسط',
            default  => 'منخفض',
        };
    }

    public static function avgConfidence(): float
    {
        return round(self::avg('confidence_score') ?? 0, 1);
    }

    public static function mostCommonIndicator(): ?string
    {
        $result = self::selectRaw('primary_indicator, COUNT(*) as count')
            ->groupBy('primary_indicator')
            ->orderByDesc('count')
            ->first();

        return $result ? self::indicators()[$result->primary_indicator] ?? $result->primary_indicator : null;
    }

    public static function indicatorDistribution(): array
    {
        $counts = self::selectRaw('primary_indicator, COUNT(*) as count')
            ->groupBy('primary_indicator')
            ->pluck('count', 'primary_indicator')
            ->toArray();

        $distribution = [];
        foreach (self::indicators() as $key => $label) {
            $distribution[$key] = [
                'label' => $label,
                'count' => $counts[$key] ?? 0,
                'color' => self::indicatorColors()[$key],
            ];
        }

        return $distribution;
    }

    public static function topKeywords(int $limit = 15): array
    {
        $all = self::whereNotNull('detected_keywords')
            ->pluck('detected_keywords')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take($limit)
            ->toArray();

        return $all;
    }

    public static function dailyStats(int $days = 14): array
    {
        return self::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
    }
}
