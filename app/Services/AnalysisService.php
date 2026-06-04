<?php

namespace App\Services;

class AnalysisService
{
    /**
     * Keyword dictionary for Yemeni dialect psychological indicators.
     * These represent linguistic patterns associated with each category.
     * This is a mock implementation — the real AI model will replace this.
     */
    private array $keywords = [
        'depression' => [
            'high' => [
                'ما عندي أمل','فقدت الأمل','تعبت من الحياة','ما أبي أكمل','زهقت من كل شي',
                'حياتي ما تسوى','ما لها فايدة','يأس','يائس','ظلام','حياتي زفت',
                'ما أبي أصحى','ودي أرتاح للأبد','وحيد تمامًا','ما يهمني أحد',
            ],
            'medium' => [
                'حزين','زهقان','تعبان','وحيد','مو مرتاح','كل شي ثقيل',
                'ما عندي طاقة','متعب','ما أقدر أنام','ما أقدر آكل','دموع',
                'بكي','بكاء','كآبة','مكتئب','مسرور لا','ما في فرحة',
                'أحس بفراغ','الفراغ','الوحدة','حزن','غم','همّ',
            ],
            'low' => [
                'تعب','تعبت','مرهق','مش قادر','صعب','ثقيل','مو زين',
                'ما أعرف','حيران','ضايق','ضيقة','مش حلو',
            ],
        ],
        'anxiety' => [
            'high' => [
                'خوف شديد','مرعوب','رعب','هلع','نوبة هلع','ما أقدر أتنفس',
                'قلبي يتوقف','دوخة شديدة','خدر','تنميل','خايف أموت',
                'أحس أني راح أموت','ما أستطيع التوقف عن التفكير',
            ],
            'medium' => [
                'قلقان','قلق','خايف','توتر','متوتر','ما أرتاح','مرهق نفسيًا',
                'أفكار ما تطق','تعب من التفكير','صداع من التفكير','قلبي يدق',
                'رعشة','يداي ترتجفان','التنفس صعب','ضيق في الصدر',
                'أحس بقلق','ما أعرف ليش خايف','الخوف','مخاوف',
            ],
            'low' => [
                'متوتر','توتر','عصبي','قلق شوي','مو مرتاح','أفكر كثير',
                'ما أقدر أنام من التفكير','أفكاري ما تنتهي','مشغول البال',
            ],
        ],
        'stress' => [
            'high' => [
                'ضغط فوق طاقتي','ما أقدر أكمل','على وشك الانهيار','خلاص تعبت',
                'ما يمديني','منهك تمامًا','قهرتني الحياة','الضغوط قتلتني',
                'كل شي فوق رأسي','ما أشوف مخرج',
            ],
            'medium' => [
                'ضغط','ضغوط','مشاكل كثير','مرهق','منهك','مو قادر','تعبان من المشاكل',
                'كل يوم مشاكل','ما في راحة','ما أقدر أتعامل','أعباء',
                'مسؤوليات كثيرة','مشغول جدًا','ما عندي وقت','ضيقة بالي',
                'كل شي يضغط','فوق طاقتي','ما في حل','تراكمت المشاكل',
            ],
            'low' => [
                'مشغول','ضغط شوي','تعب','مو راحة','أعمال كثيرة','ما وقفت',
                'ما رحت أنام','مش كافي','ما يكفيني',
            ],
        ],
        'bipolar' => [
            'high' => [
                'مرة أكون عال ومرة وايد تعبان','فجأة حسيت بطاقة هايلة',
                'مزاجي يتغير بدون سبب','أحيانًا أنام يومين ما أصحى',
                'أفكاري تجي بسرعة جدًا وما أقدر أوقفها',
                'أحيانًا أحس أني أقدر أسوي أي شي','مشاعري تتعاكس',
            ],
            'medium' => [
                'تقلبات','مزاجي يتغير','مرة سعيد','مرة حزين','ما أثبت',
                'طاقتي تزيد وتنقص','ما أنام أيام','مو محتاج نوم',
                'أفكاري سريعة','كلام كثير','نشاط زايد','أحيانًا أبكي وأحيانًا أضحك',
                'مرة فوق ومرة تحت','تقلب المزاج','ما أفهم نفسي',
            ],
            'low' => [
                'مزاجي','مو ثابت','تغيير مزاج','أحيانًا زين أحيانًا لا',
                'ما أعرف ليش أحيانًا أحس بطاقة',
            ],
        ],
        'schizophrenia' => [
            'high' => [
                'أسمع أصوات ما في أحد يسمعها','الأصوات تتكلم معي','يراقبونني',
                'الناس تتحدث عني','هم يتحكمون في أفكاري','أحس أن أحدًا يسيطر علي',
                'أشوف أشياء ما يشوفها أحد','مؤامرة ضدي','هم وراءي',
                'أفكاري تُسرق','يضعون أفكارًا في رأسي',
            ],
            'medium' => [
                'أصوات','أسمع','أشوف','أشياء غريبة','أحاسيس غريبة',
                'يراقبوني','يتجسسون','ما أثق','كلهم ضدي','الناس تكرهني',
                'أحس أني مختلف','ما أفهم ما يصير','ارتباك','تشتت',
                'ما أقدر أركز','أفكاري تتوقف فجأة','مسيطرين',
            ],
            'low' => [
                'أحس','غريب','ما أعرف','ارتباك في أفكاري','تفكير غريب',
            ],
        ],
    ];

    public function analyze(string $text): array
    {
        $start = microtime(true);

        $text = $this->normalizeArabic($text);
        $scores = $this->calculateScores($text);
        $detected = $this->extractKeywords($text);
        $highlighted = $this->buildHighlightedSegments($text, $detected['all']);

        arsort($scores);

        $total = array_sum($scores) ?: 1;
        $probabilities = [];
        foreach ($scores as $cat => $score) {
            $probabilities[$cat] = round(($score / $total) * 100, 1);
        }

        // Normalize so they sum to 100
        $sum = array_sum($probabilities);
        if ($sum > 0 && $sum != 100) {
            $diff = 100 - $sum;
            $firstKey = array_key_first($probabilities);
            $probabilities[$firstKey] += $diff;
        }

        $primary = array_key_first($probabilities);
        $confidence = round($probabilities[$primary] + mt_rand(-3, 3), 1);
        $confidence = min(98.0, max(40.0, $confidence));

        $processing = round(microtime(true) - $start + (mt_rand(3, 8) / 10), 2);

        return [
            'primary_indicator'   => $primary,
            'confidence_score'    => $confidence,
            'probabilities'       => $probabilities,
            'detected_keywords'   => $detected['keywords'],
            'highlighted_segments'=> $highlighted,
            'word_count'          => str_word_count($text, 0, 'أبتثجحخدذرزسشصضطظعغفقكلمنهوي'),
            'processing_time'     => $processing,
        ];
    }

    private function calculateScores(string $text): array
    {
        $scores = [
            'depression'    => 0.0,
            'anxiety'       => 0.0,
            'stress'        => 0.0,
            'bipolar'       => 0.0,
            'schizophrenia' => 0.0,
        ];

        foreach ($this->keywords as $category => $levels) {
            foreach ($levels['high']   as $kw) {
                if (str_contains($text, $kw)) $scores[$category] += 3.0;
            }
            foreach ($levels['medium'] as $kw) {
                if (str_contains($text, $kw)) $scores[$category] += 1.5;
            }
            foreach ($levels['low']    as $kw) {
                if (str_contains($text, $kw)) $scores[$category] += 0.5;
            }
        }

        // Add small base noise so we always have a distribution
        foreach ($scores as &$score) {
            $score += mt_rand(1, 8) / 10;
        }

        return $scores;
    }

    private function extractKeywords(string $text): array
    {
        $found = [];
        $all   = [];

        foreach ($this->keywords as $category => $levels) {
            $catKeywords = [];
            foreach (array_merge($levels['high'], $levels['medium']) as $kw) {
                if (str_contains($text, $kw)) {
                    $catKeywords[] = $kw;
                    $all[]         = $kw;
                }
            }
            if ($catKeywords) {
                $found[$category] = array_unique($catKeywords);
            }
        }

        return ['keywords' => $found, 'all' => array_unique($all)];
    }

    private function buildHighlightedSegments(string $text, array $keywords): array
    {
        if (empty($keywords)) return [];

        $segments  = [];
        $remaining = $text;

        foreach ($keywords as $kw) {
            $pos = mb_strpos($remaining, $kw);
            if ($pos !== false) {
                if ($pos > 0) {
                    $segments[] = ['text' => mb_substr($remaining, 0, $pos), 'highlight' => false];
                }
                $segments[] = ['text' => $kw, 'highlight' => true];
                $remaining  = mb_substr($remaining, $pos + mb_strlen($kw));
            }
        }

        if ($remaining !== '') {
            $segments[] = ['text' => $remaining, 'highlight' => false];
        }

        return $segments;
    }

    private function normalizeArabic(string $text): string
    {
        $text = str_replace(['أ','إ','آ'], 'ا', $text);
        $text = str_replace('ة', 'ه', $text);
        $text = preg_replace('/[ًٌٍَُِّْ]/u', '', $text);
        return trim($text);
    }
}
