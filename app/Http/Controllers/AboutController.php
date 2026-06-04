<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        $team = [
            [
                'name'        => 'صفاء عبد الحكيم',
                'role'        => 'مطور Full Stack & ML Engineer',
                'description' => 'متخصص في تطوير تطبيقات الذكاء الاصطناعي ومعالجة اللغة الطبيعية باللهجات العربية.',
                'initials'    => 'صع',
                'color'       => '#6C63FF',
            ],
        ];

        $technologies = [
            ['name' => 'Laravel 11',       'icon' => 'laravel',    'color' => '#FF2D20'],
            ['name' => 'PHP 8.2+',         'icon' => 'php',        'color' => '#777BB4'],
            ['name' => 'MySQL',            'icon' => 'database',   'color' => '#4479A1'],
            ['name' => 'Tailwind CSS',     'icon' => 'tailwind',   'color' => '#06B6D4'],
            ['name' => 'Alpine.js',        'icon' => 'alpine',     'color' => '#8BC0D0'],
            ['name' => 'Python AI API',    'icon' => 'python',     'color' => '#3776AB'],
            ['name' => 'NLP Processing',   'icon' => 'nlp',        'color' => '#10B981'],
            ['name' => 'Machine Learning', 'icon' => 'ml',         'color' => '#F59E0B'],
        ];

        return view('about.index', compact('team', 'technologies'));
    }
}
