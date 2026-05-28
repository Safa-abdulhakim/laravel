<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Prompt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Regular User
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Writing', 'slug' => 'writing', 'description' => 'Writing and content creation prompts'],
            ['name' => 'Coding', 'slug' => 'coding', 'description' => 'Programming and development prompts'],
            ['name' => 'Marketing', 'slug' => 'marketing', 'description' => 'Marketing and sales prompts'],
            ['name' => 'Design', 'slug' => 'design', 'description' => 'Design and creativity prompts'],
            ['name' => 'Education', 'slug' => 'education', 'description' => 'Learning and teaching prompts'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create Tags
        $tagNames = ['creative', 'technical', 'business', 'social-media', 'SEO', 'AI', 'productivity', 'storytelling'];
        foreach ($tagNames as $name) {
            Tag::create(['name' => $name, 'slug' => \Illuminate\Support\Str::slug($name)]);
        }

        // Create Sample Prompts
        $samplePrompts = [
            [
                'title' => 'Blog Post Writer',
                'prompt_content' => 'Write a comprehensive blog post about [TOPIC] that is engaging, informative, and optimized for SEO. Include an introduction, 5 main sections with subheadings, and a conclusion with a call-to-action.',
                'platform' => 'ChatGPT',
                'status' => 'public',
                'category_id' => 1,
            ],
            [
                'title' => 'Code Review Assistant',
                'prompt_content' => 'Review the following code and provide detailed feedback on: 1) Code quality and best practices, 2) Potential bugs or security issues, 3) Performance improvements, 4) Suggestions for better readability.',
                'platform' => 'Claude',
                'status' => 'public',
                'category_id' => 2,
            ],
            [
                'title' => 'Social Media Campaign',
                'prompt_content' => 'Create a 30-day social media content calendar for [BRAND/PRODUCT] targeting [AUDIENCE]. Include post ideas, hashtags, and engagement strategies for Instagram, Twitter, and LinkedIn.',
                'platform' => 'ChatGPT',
                'status' => 'public',
                'category_id' => 3,
            ],
            [
                'title' => 'Fantasy Landscape Art',
                'prompt_content' => 'A breathtaking fantasy landscape with towering crystal mountains, floating islands covered in lush vegetation, a magical aurora sky in purple and teal, cinematic lighting, ultra-detailed, 8k resolution, concept art style',
                'platform' => 'Midjourney',
                'status' => 'public',
                'category_id' => 4,
            ],
            [
                'title' => 'Study Plan Generator',
                'prompt_content' => 'Create a structured 12-week study plan for learning [SUBJECT]. Include daily topics, recommended resources, practice exercises, and weekly review sessions. Adapt the plan for a beginner level.',
                'platform' => 'Gemini',
                'status' => 'public',
                'category_id' => 5,
            ],
            [
                'title' => 'Python Debug Helper',
                'prompt_content' => 'You are an expert Python debugger. Analyze the following code, identify all bugs, explain why they are bugs, and provide the corrected version with explanations.',
                'platform' => 'Claude',
                'status' => 'public',
                'category_id' => 2,
            ],
        ];

        foreach ($samplePrompts as $promptData) {
            $prompt = Prompt::create(array_merge($promptData, ['user_id' => $user->id, 'views' => rand(10, 200)]));
            // Attach random tags
            $tagIds = Tag::inRandomOrder()->limit(rand(1, 3))->pluck('id')->toArray();
            $prompt->tags()->attach($tagIds);
        }
    }
}
