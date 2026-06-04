<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@portfolio.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Settings
        $settings = [
            'full_name' => 'Ahmed Al-Rashidi',
            'full_name_ar' => 'أحمد الراشدي',
            'job_title' => 'Full Stack Laravel Developer',
            'job_title_ar' => 'مطور Laravel Full Stack',
            'bio' => 'A passionate Full Stack Developer with 5+ years of experience building modern web applications. I specialize in Laravel, PHP, and creating elegant user interfaces.',
            'bio_ar' => 'مطور Full Stack شغوف بخبرة تزيد على 5 سنوات في بناء تطبيقات ويب حديثة. متخصص في Laravel وPHP وإنشاء واجهات مستخدم أنيقة.',
            'email' => 'ahmed@portfolio.com',
            'phone' => '+966 50 000 0000',
            'location' => 'Riyadh, Saudi Arabia',
            'location_ar' => 'الرياض، المملكة العربية السعودية',
            'github_url' => 'https://github.com',
            'linkedin_url' => 'https://linkedin.com',
            'twitter_url' => 'https://twitter.com',
            'years_experience' => '5',
            'hero_subtitle_en' => 'Building Modern Web Solutions With Clean Code & Creative Thinking',
            'hero_subtitle_ar' => 'بناء حلول ويب حديثة بكود نظيف وتفكير إبداعي',
            'interests' => 'Open Source Development, UI/UX Design, Cloud Computing, Machine Learning',
            'interests_ar' => 'تطوير المصدر المفتوح، تصميم UI/UX، الحوسبة السحابية، التعلم الآلي',
        ];

        foreach ($settings as $key => $value) {
            Setting::create(['key' => $key, 'value' => $value]);
        }

        // Skills
        $skills = [
            ['name' => 'PHP', 'name_ar' => 'PHP', 'percentage' => 90, 'category' => 'backend', 'icon' => 'fab fa-php', 'color' => '#777BB4'],
            ['name' => 'Laravel', 'name_ar' => 'Laravel', 'percentage' => 92, 'category' => 'backend', 'icon' => 'fab fa-laravel', 'color' => '#FF2D20'],
            ['name' => 'MySQL', 'name_ar' => 'MySQL', 'percentage' => 85, 'category' => 'backend', 'icon' => 'fas fa-database', 'color' => '#4479A1'],
            ['name' => 'REST APIs', 'name_ar' => 'REST APIs', 'percentage' => 88, 'category' => 'backend', 'icon' => 'fas fa-code', 'color' => '#10B981'],
            ['name' => 'HTML5', 'name_ar' => 'HTML5', 'percentage' => 95, 'category' => 'frontend', 'icon' => 'fab fa-html5', 'color' => '#E34F26'],
            ['name' => 'CSS3', 'name_ar' => 'CSS3', 'percentage' => 90, 'category' => 'frontend', 'icon' => 'fab fa-css3-alt', 'color' => '#1572B6'],
            ['name' => 'JavaScript', 'name_ar' => 'JavaScript', 'percentage' => 82, 'category' => 'frontend', 'icon' => 'fab fa-js', 'color' => '#F7DF1E'],
            ['name' => 'Tailwind CSS', 'name_ar' => 'Tailwind CSS', 'percentage' => 88, 'category' => 'frontend', 'icon' => 'fas fa-wind', 'color' => '#06B6D4'],
            ['name' => 'Alpine.js', 'name_ar' => 'Alpine.js', 'percentage' => 80, 'category' => 'frontend', 'icon' => 'fab fa-js-square', 'color' => '#77C1D2'],
            ['name' => 'Bootstrap', 'name_ar' => 'Bootstrap', 'percentage' => 90, 'category' => 'frontend', 'icon' => 'fab fa-bootstrap', 'color' => '#7952B3'],
            ['name' => 'Git', 'name_ar' => 'Git', 'percentage' => 88, 'category' => 'tools', 'icon' => 'fab fa-git-alt', 'color' => '#F05032'],
            ['name' => 'GitHub', 'name_ar' => 'GitHub', 'percentage' => 88, 'category' => 'tools', 'icon' => 'fab fa-github', 'color' => '#181717'],
            ['name' => 'VS Code', 'name_ar' => 'VS Code', 'percentage' => 95, 'category' => 'tools', 'icon' => 'fas fa-code', 'color' => '#007ACC'],
            ['name' => 'Postman', 'name_ar' => 'Postman', 'percentage' => 85, 'category' => 'tools', 'icon' => 'fas fa-paper-plane', 'color' => '#FF6C37'],
            ['name' => 'Docker', 'name_ar' => 'Docker', 'percentage' => 70, 'category' => 'tools', 'icon' => 'fab fa-docker', 'color' => '#2496ED'],
        ];

        foreach ($skills as $index => $skill) {
            Skill::create(array_merge($skill, ['sort_order' => $index]));
        }

        // Experience
        Experience::create([
            'company_name' => 'Tech Solutions Co.',
            'company_name_ar' => 'شركة حلول تقنية',
            'position' => 'Senior Laravel Developer',
            'position_ar' => 'مطور Laravel أول',
            'start_date' => '2022-01-01',
            'is_current' => true,
            'description' => 'Leading development of enterprise web applications using Laravel, implementing RESTful APIs, and mentoring junior developers.',
            'description_ar' => 'قيادة تطوير تطبيقات ويب للمؤسسات باستخدام Laravel، وتطبيق REST APIs، وتوجيه المطورين المبتدئين.',
            'location' => 'Riyadh, Saudi Arabia',
        ]);

        Experience::create([
            'company_name' => 'Digital Agency',
            'company_name_ar' => 'وكالة رقمية',
            'position' => 'Full Stack Developer',
            'position_ar' => 'مطور Full Stack',
            'start_date' => '2020-03-01',
            'end_date' => '2021-12-31',
            'is_current' => false,
            'description' => 'Developed and maintained multiple client websites and web applications using PHP, Laravel, and modern frontend technologies.',
            'description_ar' => 'تطوير وصيانة مواقع ويب وتطبيقات متعددة للعملاء باستخدام PHP وLaravel وتقنيات الواجهة الأمامية الحديثة.',
            'location' => 'Jeddah, Saudi Arabia',
        ]);

        Experience::create([
            'company_name' => 'Startup Inc.',
            'company_name_ar' => 'شركة ناشئة',
            'position' => 'Junior Web Developer',
            'position_ar' => 'مطور ويب مبتدئ',
            'start_date' => '2019-01-01',
            'end_date' => '2020-02-28',
            'is_current' => false,
            'description' => 'Built web applications from scratch, collaborated with design team to implement UI/UX improvements.',
            'description_ar' => 'بناء تطبيقات ويب من الصفر، والتعاون مع فريق التصميم لتنفيذ تحسينات UI/UX.',
            'location' => 'Riyadh, Saudi Arabia',
        ]);

        // Certificates
        Certificate::create([
            'title' => 'Laravel Certified Developer',
            'title_ar' => 'مطور Laravel معتمد',
            'issuer' => 'Laravel',
            'issuer_ar' => 'Laravel',
            'issue_date' => '2023-06-15',
            'sort_order' => 0,
        ]);

        Certificate::create([
            'title' => 'AWS Certified Developer',
            'title_ar' => 'مطور AWS معتمد',
            'issuer' => 'Amazon Web Services',
            'issuer_ar' => 'خدمات أمازون السحابية',
            'issue_date' => '2023-01-20',
            'sort_order' => 1,
        ]);

        Certificate::create([
            'title' => 'Professional Scrum Master',
            'title_ar' => 'سكرم ماستر محترف',
            'issuer' => 'Scrum.org',
            'issuer_ar' => 'Scrum.org',
            'issue_date' => '2022-09-10',
            'sort_order' => 2,
        ]);

        // Projects
        $projects = [
            [
                'title' => 'E-Commerce Platform',
                'title_ar' => 'منصة تجارة إلكترونية',
                'slug' => 'ecommerce-platform',
                'description' => 'A full-featured e-commerce platform built with Laravel, featuring product management, shopping cart, payment integration, and admin dashboard.',
                'description_ar' => 'منصة تجارة إلكترونية متكاملة مبنية بـ Laravel، تتضمن إدارة المنتجات وسلة التسوق ودمج الدفع ولوحة تحكم.',
                'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Alpine.js', 'Stripe'],
                'category' => 'web',
                'featured' => true,
                'sort_order' => 0,
            ],
            [
                'title' => 'Hospital Management System',
                'title_ar' => 'نظام إدارة مستشفى',
                'slug' => 'hospital-management',
                'description' => 'Comprehensive hospital management system with patient records, appointment scheduling, billing, and reporting modules.',
                'description_ar' => 'نظام إدارة مستشفى شامل يتضمن سجلات المرضى وجدولة المواعيد والفوترة وموديولات التقارير.',
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'Bootstrap', 'jQuery'],
                'category' => 'web',
                'featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Task Management App',
                'title_ar' => 'تطبيق إدارة المهام',
                'slug' => 'task-management',
                'description' => 'A collaborative task management application with real-time updates, team collaboration features, and progress tracking.',
                'description_ar' => 'تطبيق إدارة المهام التعاوني مع تحديثات فورية وميزات التعاون الجماعي وتتبع التقدم.',
                'technologies' => ['Laravel', 'Vue.js', 'Pusher', 'MySQL', 'Tailwind CSS'],
                'category' => 'web',
                'featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'REST API Service',
                'title_ar' => 'خدمة REST API',
                'slug' => 'rest-api-service',
                'description' => 'A robust REST API service with authentication, rate limiting, and comprehensive documentation.',
                'description_ar' => 'خدمة REST API قوية مع المصادقة وتحديد المعدل والوثائق الشاملة.',
                'technologies' => ['Laravel', 'Sanctum', 'MySQL', 'Swagger'],
                'category' => 'api',
                'featured' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }

        // Testimonials
        Testimonial::create([
            'name' => 'Sarah Johnson',
            'name_ar' => 'سارة جونسون',
            'position' => 'Product Manager',
            'position_ar' => 'مدير المنتج',
            'company' => 'Tech Corp',
            'content' => 'Ahmed is an exceptional developer who delivers high-quality work on time. His attention to detail and problem-solving skills are outstanding.',
            'content_ar' => 'أحمد مطور استثنائي يقدم عملاً عالي الجودة في الوقت المحدد. انتباهه للتفاصيل ومهاراته في حل المشكلات رائعة.',
            'rating' => 5,
            'is_visible' => true,
            'sort_order' => 0,
        ]);

        Testimonial::create([
            'name' => 'Michael Chen',
            'name_ar' => 'مايكل تشن',
            'position' => 'CTO',
            'position_ar' => 'المدير التقني',
            'company' => 'StartupXYZ',
            'content' => 'Working with Ahmed was a great experience. He understood our requirements quickly and built exactly what we needed.',
            'content_ar' => 'العمل مع أحمد كان تجربة رائعة. فهم متطلباتنا بسرعة وبنى بالضبط ما احتجناه.',
            'rating' => 5,
            'is_visible' => true,
            'sort_order' => 1,
        ]);
    }
}
