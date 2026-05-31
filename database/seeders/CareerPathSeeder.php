<?php

namespace Database\Seeders;

use App\Models\CareerPath;
use App\Models\LearningResource;
use App\Models\Skill;
use App\Models\Stage;
use Illuminate\Database\Seeder;

class CareerPathSeeder extends Seeder
{
    public function run(): void
    {
        $paths = [
            [
                'title' => 'Laravel Developer',
                'description' => 'Master Laravel framework from basics to advanced topics including APIs, queues, and deployment.',
                'icon' => 'bi-code-slash',
                'difficulty_level' => 'Intermediate',
                'estimated_duration' => '6 months',
                'status' => 'active',
                'enrolled_count' => 245,
                'stages' => [
                    [
                        'title' => 'Web Fundamentals',
                        'description' => 'Core web technologies every developer must know.',
                        'order' => 1,
                        'skills' => [
                            ['title' => 'HTML5', 'estimated_hours' => 20, 'difficulty' => 'Beginner', 'order' => 1],
                            ['title' => 'CSS3 & Flexbox', 'estimated_hours' => 25, 'difficulty' => 'Beginner', 'order' => 2],
                            ['title' => 'JavaScript Basics', 'estimated_hours' => 40, 'difficulty' => 'Beginner', 'order' => 3],
                        ],
                    ],
                    [
                        'title' => 'PHP & OOP',
                        'description' => 'PHP programming with object-oriented principles.',
                        'order' => 2,
                        'skills' => [
                            ['title' => 'PHP Fundamentals', 'estimated_hours' => 30, 'difficulty' => 'Beginner', 'order' => 1],
                            ['title' => 'OOP in PHP', 'estimated_hours' => 25, 'difficulty' => 'Intermediate', 'order' => 2],
                            ['title' => 'MySQL & SQL', 'estimated_hours' => 20, 'difficulty' => 'Beginner', 'order' => 3],
                        ],
                    ],
                    [
                        'title' => 'Laravel Fundamentals',
                        'description' => 'Core Laravel concepts and MVC pattern.',
                        'order' => 3,
                        'skills' => [
                            ['title' => 'Routing & Controllers', 'estimated_hours' => 15, 'difficulty' => 'Intermediate', 'order' => 1],
                            ['title' => 'Eloquent ORM', 'estimated_hours' => 20, 'difficulty' => 'Intermediate', 'order' => 2],
                            ['title' => 'Blade Templates', 'estimated_hours' => 10, 'difficulty' => 'Beginner', 'order' => 3],
                            ['title' => 'Migrations & Seeders', 'estimated_hours' => 10, 'difficulty' => 'Intermediate', 'order' => 4],
                        ],
                    ],
                    [
                        'title' => 'Advanced Laravel',
                        'description' => 'Advanced features including APIs, queues, and testing.',
                        'order' => 4,
                        'skills' => [
                            ['title' => 'REST API Development', 'estimated_hours' => 25, 'difficulty' => 'Advanced', 'order' => 1],
                            ['title' => 'Authentication & Authorization', 'estimated_hours' => 15, 'difficulty' => 'Advanced', 'order' => 2],
                            ['title' => 'Queues & Jobs', 'estimated_hours' => 15, 'difficulty' => 'Advanced', 'order' => 3],
                            ['title' => 'Testing with PHPUnit', 'estimated_hours' => 20, 'difficulty' => 'Advanced', 'order' => 4],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Frontend Developer',
                'description' => 'From HTML/CSS basics to modern React/Vue.js development with professional UI/UX skills.',
                'icon' => 'bi-layout-text-window',
                'difficulty_level' => 'Beginner',
                'estimated_duration' => '5 months',
                'status' => 'active',
                'enrolled_count' => 312,
                'stages' => [
                    [
                        'title' => 'HTML & CSS',
                        'description' => 'Web markup and styling fundamentals.',
                        'order' => 1,
                        'skills' => [
                            ['title' => 'HTML Structure & Semantics', 'estimated_hours' => 20, 'difficulty' => 'Beginner', 'order' => 1],
                            ['title' => 'CSS Styling & Box Model', 'estimated_hours' => 25, 'difficulty' => 'Beginner', 'order' => 2],
                            ['title' => 'Flexbox & Grid', 'estimated_hours' => 20, 'difficulty' => 'Intermediate', 'order' => 3],
                            ['title' => 'Responsive Design', 'estimated_hours' => 15, 'difficulty' => 'Intermediate', 'order' => 4],
                        ],
                    ],
                    [
                        'title' => 'JavaScript',
                        'description' => 'Modern JavaScript programming.',
                        'order' => 2,
                        'skills' => [
                            ['title' => 'JavaScript Fundamentals', 'estimated_hours' => 35, 'difficulty' => 'Beginner', 'order' => 1],
                            ['title' => 'ES6+ Features', 'estimated_hours' => 20, 'difficulty' => 'Intermediate', 'order' => 2],
                            ['title' => 'DOM Manipulation', 'estimated_hours' => 15, 'difficulty' => 'Intermediate', 'order' => 3],
                            ['title' => 'Fetch API & AJAX', 'estimated_hours' => 10, 'difficulty' => 'Intermediate', 'order' => 4],
                        ],
                    ],
                    [
                        'title' => 'React.js',
                        'description' => 'Modern React development with hooks and state management.',
                        'order' => 3,
                        'skills' => [
                            ['title' => 'React Basics & JSX', 'estimated_hours' => 20, 'difficulty' => 'Intermediate', 'order' => 1],
                            ['title' => 'React Hooks', 'estimated_hours' => 20, 'difficulty' => 'Intermediate', 'order' => 2],
                            ['title' => 'State Management', 'estimated_hours' => 20, 'difficulty' => 'Advanced', 'order' => 3],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'DevOps Engineer',
                'description' => 'Master CI/CD, Docker, Kubernetes, and cloud infrastructure for modern deployment.',
                'icon' => 'bi-gear-wide-connected',
                'difficulty_level' => 'Advanced',
                'estimated_duration' => '8 months',
                'status' => 'active',
                'enrolled_count' => 156,
                'stages' => [
                    [
                        'title' => 'Linux & Networking',
                        'description' => 'Linux administration and networking fundamentals.',
                        'order' => 1,
                        'skills' => [
                            ['title' => 'Linux Command Line', 'estimated_hours' => 30, 'difficulty' => 'Beginner', 'order' => 1],
                            ['title' => 'Shell Scripting', 'estimated_hours' => 20, 'difficulty' => 'Intermediate', 'order' => 2],
                            ['title' => 'Networking Basics', 'estimated_hours' => 15, 'difficulty' => 'Intermediate', 'order' => 3],
                        ],
                    ],
                    [
                        'title' => 'Containerization',
                        'description' => 'Docker and container orchestration.',
                        'order' => 2,
                        'skills' => [
                            ['title' => 'Docker Fundamentals', 'estimated_hours' => 25, 'difficulty' => 'Intermediate', 'order' => 1],
                            ['title' => 'Docker Compose', 'estimated_hours' => 15, 'difficulty' => 'Intermediate', 'order' => 2],
                            ['title' => 'Kubernetes Basics', 'estimated_hours' => 40, 'difficulty' => 'Advanced', 'order' => 3],
                        ],
                    ],
                    [
                        'title' => 'CI/CD & Cloud',
                        'description' => 'Continuous integration, deployment, and cloud services.',
                        'order' => 3,
                        'skills' => [
                            ['title' => 'Git & GitHub Actions', 'estimated_hours' => 20, 'difficulty' => 'Intermediate', 'order' => 1],
                            ['title' => 'AWS Fundamentals', 'estimated_hours' => 35, 'difficulty' => 'Advanced', 'order' => 2],
                            ['title' => 'Infrastructure as Code', 'estimated_hours' => 30, 'difficulty' => 'Advanced', 'order' => 3],
                        ],
                    ],
                ],
            ],
            [
                'title' => 'Data Scientist',
                'description' => 'Learn Python, statistics, machine learning, and data visualization for data science.',
                'icon' => 'bi-graph-up-arrow',
                'difficulty_level' => 'Advanced',
                'estimated_duration' => '9 months',
                'status' => 'active',
                'enrolled_count' => 198,
                'stages' => [
                    [
                        'title' => 'Python & Statistics',
                        'description' => 'Python programming and statistical foundations.',
                        'order' => 1,
                        'skills' => [
                            ['title' => 'Python Fundamentals', 'estimated_hours' => 35, 'difficulty' => 'Beginner', 'order' => 1],
                            ['title' => 'NumPy & Pandas', 'estimated_hours' => 25, 'difficulty' => 'Intermediate', 'order' => 2],
                            ['title' => 'Statistics & Probability', 'estimated_hours' => 30, 'difficulty' => 'Intermediate', 'order' => 3],
                        ],
                    ],
                    [
                        'title' => 'Machine Learning',
                        'description' => 'Core machine learning algorithms and frameworks.',
                        'order' => 2,
                        'skills' => [
                            ['title' => 'Scikit-learn Basics', 'estimated_hours' => 30, 'difficulty' => 'Intermediate', 'order' => 1],
                            ['title' => 'Deep Learning with TensorFlow', 'estimated_hours' => 40, 'difficulty' => 'Advanced', 'order' => 2],
                            ['title' => 'Model Evaluation & Tuning', 'estimated_hours' => 20, 'difficulty' => 'Advanced', 'order' => 3],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($paths as $pathData) {
            $stages = $pathData['stages'];
            unset($pathData['stages']);

            $path = CareerPath::firstOrCreate(['title' => $pathData['title']], $pathData);

            foreach ($stages as $stageData) {
                $skills = $stageData['skills'];
                unset($stageData['skills']);
                $stageData['career_path_id'] = $path->id;

                $stage = Stage::firstOrCreate(
                    ['career_path_id' => $path->id, 'title' => $stageData['title']],
                    $stageData
                );

                foreach ($skills as $skillData) {
                    $skillData['stage_id'] = $stage->id;
                    $skill = Skill::firstOrCreate(
                        ['stage_id' => $stage->id, 'title' => $skillData['title']],
                        $skillData
                    );

                    LearningResource::firstOrCreate(
                        ['skill_id' => $skill->id, 'title' => $skill->title . ' - Official Docs'],
                        [
                            'skill_id' => $skill->id,
                            'title' => $skill->title . ' - Official Documentation',
                            'type' => 'Documentation',
                            'url' => 'https://example.com',
                            'provider' => 'Official',
                        ]
                    );
                }
            }
        }
    }
}
