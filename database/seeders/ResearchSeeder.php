<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Research;

class ResearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'title' => 'AI-Driven Recruitment Process',
                'author' => 'Juan Dela Cruz',
                'module' => 'Innovation Proposal',
                'status' => 'For Review'
            ],
            [
                'title' => 'The Impact of Remote Work in ICT',
                'author' => 'Maria Clara',
                'module' => 'Thesis',
                'status' => 'Completed'
            ],
            [
                'title' => 'Cybersecurity Protocols 2026',
                'author' => 'Pedro Penduko',
                'module' => 'Research',
                'status' => 'Ongoing'
            ],
            [
                'title' => 'Blockchain for Data Integrity',
                'author' => 'Sisa Ramos',
                'module' => 'Dissertation',
                'status' => 'Pending'
            ],
            [
                'title' => 'Network Optimization Project',
                'author' => 'Basilio Santos',
                'module' => 'Completed',
                'status' => 'Archive'
            ],
            [
                'title' => 'Full Stack Web Development 2025',
                'author' => 'Crispin Mercado',
                'module' => 'Certificate of Completion',
                'status' => 'Verified'
            ],
            [
                'title' => 'Miscellaneous Technical Docs',
                'author' => 'Simoun Ibarra',
                'module' => 'Others',
                'status' => 'N/A'
            ],
            [
                'title' => 'Smart City Infrastructure Proposal',
                'author' => 'Elias Salcedo',
                'module' => 'Innovation Proposal',
                'status' => 'Draft'
            ],
        ];

        foreach ($modules as $m) {
            Research::create($m);
        }
    }
}