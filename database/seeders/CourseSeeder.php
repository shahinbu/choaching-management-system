<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Topic;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create courses
        $courses = [
            [
                'name' => 'Science',
                'code' => 'SCI',
                'description' => 'Science stream for higher secondary education',
                'subjects' => [
                    [
                        'name' => 'Physics',
                        'code' => 'PHY',
                        'description' => 'Study of matter and energy',
                        'topics' => [
                            ['name' => 'Mechanics', 'code' => 'MECH', 'chapter_number' => 1],
                            ['name' => 'Thermodynamics', 'code' => 'THERM', 'chapter_number' => 2],
                            ['name' => 'Optics', 'code' => 'OPTICS', 'chapter_number' => 3],
                            ['name' => 'Electricity', 'code' => 'ELEC', 'chapter_number' => 4],
                        ]
                    ],
                    [
                        'name' => 'Chemistry',
                        'code' => 'CHEM',
                        'description' => 'Study of substances and their properties',
                        'topics' => [
                            ['name' => 'Organic Chemistry', 'code' => 'ORG', 'chapter_number' => 1],
                            ['name' => 'Inorganic Chemistry', 'code' => 'INORG', 'chapter_number' => 2],
                            ['name' => 'Physical Chemistry', 'code' => 'PHYSCHEM', 'chapter_number' => 3],
                        ]
                    ],
                    [
                        'name' => 'Biology',
                        'code' => 'BIO',
                        'description' => 'Study of living organisms',
                        'topics' => [
                            ['name' => 'Cell Biology', 'code' => 'CELL', 'chapter_number' => 1],
                            ['name' => 'Genetics', 'code' => 'GEN', 'chapter_number' => 2],
                            ['name' => 'Ecology', 'code' => 'ECO', 'chapter_number' => 3],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Arts',
                'code' => 'ARTS',
                'description' => 'Arts stream for higher secondary education',
                'subjects' => [
                    [
                        'name' => 'History',
                        'code' => 'HIST',
                        'description' => 'Study of past events',
                        'topics' => [
                            ['name' => 'Ancient History', 'code' => 'ANCIENT', 'chapter_number' => 1],
                            ['name' => 'Medieval History', 'code' => 'MEDIEVAL', 'chapter_number' => 2],
                            ['name' => 'Modern History', 'code' => 'MODERN', 'chapter_number' => 3],
                        ]
                    ],
                    [
                        'name' => 'Geography',
                        'code' => 'GEO',
                        'description' => 'Study of Earth and its features',
                        'topics' => [
                            ['name' => 'Physical Geography', 'code' => 'PHYGEO', 'chapter_number' => 1],
                            ['name' => 'Human Geography', 'code' => 'HUMGEO', 'chapter_number' => 2],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Commerce',
                'code' => 'COMM',
                'description' => 'Commerce stream for higher secondary education',
                'subjects' => [
                    [
                        'name' => 'Accounting',
                        'code' => 'ACC',
                        'description' => 'Study of financial transactions',
                        'topics' => [
                            ['name' => 'Basic Accounting', 'code' => 'BASIC', 'chapter_number' => 1],
                            ['name' => 'Financial Accounting', 'code' => 'FIN', 'chapter_number' => 2],
                            ['name' => 'Cost Accounting', 'code' => 'COST', 'chapter_number' => 3],
                        ]
                    ],
                    [
                        'name' => 'Economics',
                        'code' => 'ECON',
                        'description' => 'Study of production and consumption',
                        'topics' => [
                            ['name' => 'Microeconomics', 'code' => 'MICRO', 'chapter_number' => 1],
                            ['name' => 'Macroeconomics', 'code' => 'MACRO', 'chapter_number' => 2],
                        ]
                    ],
                ]
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::create([
                'name' => $courseData['name'],
                'code' => $courseData['code'],
                'description' => $courseData['description'],
                'status' => 'active',
            ]);

            foreach ($courseData['subjects'] as $subjectData) {
                $subject = Subject::create([
                    'course_id' => $course->id,
                    'name' => $subjectData['name'],
                    'code' => $subjectData['code'],
                    'description' => $subjectData['description'],
                    'status' => 'active',
                ]);

                foreach ($subjectData['topics'] as $topicData) {
                    Topic::create([
                        'subject_id' => $subject->id,
                        'name' => $topicData['name'],
                        'code' => $topicData['code'],
                        'chapter_number' => $topicData['chapter_number'],
                        'status' => 'active',
                    ]);
                }
            }
        }
    }
}
