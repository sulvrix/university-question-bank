<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questions')->insert([
            [
                'text' => 'What is the primary function of the heart?',
                'answers' => json_encode([
                    ['text' => 'Pump blood', 'is_correct' => true],
                    ['text' => 'Filter toxins', 'is_correct' => false],
                    ['text' => 'Produce hormones', 'is_correct' => false],
                    ['text' => 'Digest food', 'is_correct' => false],
                ]),
                'difficulty' => 'easy',
                'points' => 1,
                'subject_id' => 1,
            ],
            [
                'text' => 'Which organ produces insulin?',
                'answers' => json_encode([
                    ['text' => 'Liver', 'is_correct' => false],
                    ['text' => 'Pancreas', 'is_correct' => true],
                    ['text' => 'Kidney', 'is_correct' => false],
                    ['text' => 'Stomach', 'is_correct' => false],
                ]),
                'difficulty' => 'medium',
                'points' => 1,
                'subject_id' => 1,
            ],
            [
                'text' => 'What is the normal range for blood pressure in adults?',
                'answers' => json_encode([
                    ['text' => '120/80 mmHg', 'is_correct' => true],
                    ['text' => '140/90 mmHg', 'is_correct' => false],
                    ['text' => '100/60 mmHg', 'is_correct' => false],
                    ['text' => '160/100 mmHg', 'is_correct' => false],
                ]),
                'difficulty' => 'hard',
                'points' => 1,
                'subject_id' => 1,
            ],
        ]);
    }
}
