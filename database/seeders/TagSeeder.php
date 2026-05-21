<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::truncate();

        $tags = [
            // Development
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'PHP', 'slug' => 'php'],
            ['name' => 'Symfony', 'slug' => 'symfony'],
            ['name' => 'Vue.js', 'slug' => 'vuejs'],
            ['name' => 'JavaScript', 'slug' => 'javascript'],
            ['name' => 'API Development', 'slug' => 'api-development'],
            ['name' => 'Backend', 'slug' => 'backend'],
            ['name' => 'Frontend', 'slug' => 'frontend'],
            ['name' => 'Full Stack', 'slug' => 'full-stack'],
            ['name' => 'Clean Code', 'slug' => 'clean-code'],
            ['name' => 'Design Patterns', 'slug' => 'design-patterns'],
            ['name' => 'Software Architecture', 'slug' => 'software-architecture'],
            ['name' => 'DevOps', 'slug' => 'devops'],
            ['name' => 'Testing', 'slug' => 'testing'],
            ['name' => 'Performance', 'slug' => 'performance'],

            // Project / Management
            ['name' => 'Project Management', 'slug' => 'project-management'],
            ['name' => 'Agile', 'slug' => 'agile'],
            ['name' => 'Scrum', 'slug' => 'scrum'],
            ['name' => 'Team Management', 'slug' => 'team-management'],
            ['name' => 'Leadership', 'slug' => 'leadership'],
            ['name' => 'Productivity', 'slug' => 'productivity'],
            ['name' => 'Planning', 'slug' => 'planning'],
            ['name' => 'Workflow', 'slug' => 'workflow'],
            ['name' => 'Task Management', 'slug' => 'task-management'],

            // Money / Business
            ['name' => 'Finance', 'slug' => 'finance'],
            ['name' => 'Budgeting', 'slug' => 'budgeting'],
            ['name' => 'Investment', 'slug' => 'investment'],
            ['name' => 'Freelancing', 'slug' => 'freelancing'],
            ['name' => 'Side Hustle', 'slug' => 'side-hustle'],
            ['name' => 'Entrepreneurship', 'slug' => 'entrepreneurship'],
            ['name' => 'Startup', 'slug' => 'startup'],
            ['name' => 'Revenue', 'slug' => 'revenue'],
            ['name' => 'Passive Income', 'slug' => 'passive-income'],

            // Career / Growth
            ['name' => 'Career Growth', 'slug' => 'career-growth'],
            ['name' => 'Remote Work', 'slug' => 'remote-work'],
            ['name' => 'Job Hunting', 'slug' => 'job-hunting'],
            ['name' => 'Interview Tips', 'slug' => 'interview-tips'],

            // General Tech Thinking
            ['name' => 'System Design', 'slug' => 'system-design'],
            ['name' => 'Scalability', 'slug' => 'scalability'],
            ['name' => 'Security', 'slug' => 'security'],
        ];

        foreach($tags as $tag)
        {
            Tag::create($tag);
        }
    }
}
