<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Certificate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'John Developer',
            'email' => 'admin@portfolio.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Seed Skills
        $skills = [
            ['name' => 'HTML/CSS', 'percentage' => 95, 'category' => 'frontend', 'sort_order' => 1],
            ['name' => 'JavaScript', 'percentage' => 90, 'category' => 'frontend', 'sort_order' => 2],
            ['name' => 'Vue.js', 'percentage' => 85, 'category' => 'frontend', 'sort_order' => 3],
            ['name' => 'Bootstrap 5', 'percentage' => 92, 'category' => 'frontend', 'sort_order' => 4],
            ['name' => 'PHP', 'percentage' => 90, 'category' => 'backend', 'sort_order' => 1],
            ['name' => 'Laravel', 'percentage' => 92, 'category' => 'backend', 'sort_order' => 2],
            ['name' => 'MySQL', 'percentage' => 85, 'category' => 'backend', 'sort_order' => 3],
            ['name' => 'REST APIs', 'percentage' => 88, 'category' => 'backend', 'sort_order' => 4],
            ['name' => 'Git/GitHub', 'percentage' => 90, 'category' => 'tools', 'sort_order' => 1],
            ['name' => 'Docker', 'percentage' => 75, 'category' => 'tools', 'sort_order' => 2],
            ['name' => 'Linux', 'percentage' => 80, 'category' => 'tools', 'sort_order' => 3],
            ['name' => 'Figma', 'percentage' => 70, 'category' => 'tools', 'sort_order' => 4],
        ];
        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        // Seed Experiences
        $experiences = [
            [
                'company' => 'Tech Solutions Inc.',
                'position' => 'Senior Full Stack Developer',
                'start_date' => '2022-01-01',
                'end_date' => null,
                'is_current' => true,
                'description' => 'Lead development of multiple web applications using Laravel and Vue.js. Mentored junior developers and implemented best practices for code quality.',
                'location' => 'Remote',
                'sort_order' => 1,
            ],
            [
                'company' => 'Digital Agency XYZ',
                'position' => 'Full Stack Developer',
                'start_date' => '2020-03-01',
                'end_date' => '2021-12-31',
                'is_current' => false,
                'description' => 'Developed and maintained multiple client websites using Laravel framework. Collaborated with design team to implement responsive UI components.',
                'location' => 'New York, USA',
                'sort_order' => 2,
            ],
            [
                'company' => 'Startup Hub',
                'position' => 'Junior Web Developer',
                'start_date' => '2019-06-01',
                'end_date' => '2020-02-28',
                'is_current' => false,
                'description' => 'Built RESTful APIs and web interfaces using PHP and JavaScript. Worked on agile team delivering features in 2-week sprints.',
                'location' => 'San Francisco, USA',
                'sort_order' => 3,
            ],
        ];
        foreach ($experiences as $exp) {
            Experience::create($exp);
        }

        // Seed Projects
        $projects = [
            [
                'title' => 'E-Commerce Platform',
                'description' => 'A full-featured e-commerce platform built with Laravel 11 and Vue.js. Features include product management, shopping cart, payment integration, order tracking, and admin dashboard.',
                'github_link' => 'https://github.com/example/ecommerce',
                'live_demo' => 'https://demo.example.com',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Stripe', 'Bootstrap 5'],
                'status' => 'featured',
                'sort_order' => 1,
            ],
            [
                'title' => 'Task Management App',
                'description' => 'A collaborative task management application with real-time updates, team workspaces, kanban boards, and time tracking features.',
                'github_link' => 'https://github.com/example/taskmanager',
                'live_demo' => null,
                'technologies' => ['Laravel', 'Alpine.js', 'MySQL', 'Pusher'],
                'status' => 'featured',
                'sort_order' => 2,
            ],
            [
                'title' => 'Blog CMS',
                'description' => 'A modern content management system with SEO optimization, category management, tags, and commenting system.',
                'github_link' => 'https://github.com/example/blog-cms',
                'live_demo' => 'https://blog.example.com',
                'technologies' => ['Laravel', 'MySQL', 'TailwindCSS', 'Livewire'],
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'title' => 'REST API Service',
                'description' => 'A scalable RESTful API service for mobile applications with authentication, rate limiting, and comprehensive documentation.',
                'github_link' => 'https://github.com/example/api-service',
                'live_demo' => null,
                'technologies' => ['Laravel', 'Sanctum', 'MySQL', 'Redis'],
                'status' => 'active',
                'sort_order' => 4,
            ],
        ];
        foreach ($projects as $project) {
            Project::create($project);
        }

        // Seed Certificates
        $certificates = [
            [
                'title' => 'Laravel Certified Developer',
                'issuer' => 'Laravel LLC',
                'issue_date' => '2023-05-15',
                'credential_id' => 'LCD-2023-001',
                'credential_url' => 'https://laravel.com/certifications',
                'sort_order' => 1,
            ],
            [
                'title' => 'AWS Certified Developer',
                'issuer' => 'Amazon Web Services',
                'issue_date' => '2022-11-20',
                'expiry_date' => '2025-11-20',
                'credential_id' => 'AWS-DEV-2022',
                'sort_order' => 2,
            ],
            [
                'title' => 'Google UX Design Certificate',
                'issuer' => 'Google',
                'issue_date' => '2022-03-10',
                'credential_url' => 'https://coursera.org/verify',
                'sort_order' => 3,
            ],
        ];
        foreach ($certificates as $cert) {
            Certificate::create($cert);
        }

        $this->command->info('✅ Portfolio seeded successfully!');
        $this->command->info('👤 Admin Login: admin@portfolio.com / password');
    }
}
