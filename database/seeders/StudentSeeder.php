<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'full_name' => 'আহমেদ রহমান',
            'student_id' => 'STU001',
            'date_of_birth' => '2005-03-15',
            'gender' => 'male',
            'email' => 'ahmed@example.com',
            'phone' => '+880 1712345678',
            'address' => 'রংপুর, বাংলাদেশ',
            'city' => 'রংপুর',
            'school_college' => 'রংপুর সরকারি কলেজ',
            'class_grade' => 'Class 12',
            'parent_name' => 'মোঃ আব্দুল রহমান',
            'parent_phone' => '+880 1812345678',
            'status' => 'active',
        ]);

        Student::create([
            'full_name' => 'ফাতেমা খাতুন',
            'student_id' => 'STU002',
            'date_of_birth' => '2006-07-22',
            'gender' => 'female',
            'email' => 'fatema@example.com',
            'phone' => '+880 1723456789',
            'address' => 'ঢাকা, বাংলাদেশ',
            'city' => 'ঢাকা',
            'school_college' => 'ঢাকা সরকারি কলেজ',
            'class_grade' => 'Class 11',
            'parent_name' => 'মোঃ আব্দুল খালেক',
            'parent_phone' => '+880 1823456789',
            'status' => 'active',
        ]);

        Student::create([
            'full_name' => 'সাবরিনা আক্তার',
            'student_id' => 'STU003',
            'date_of_birth' => '2005-11-08',
            'gender' => 'female',
            'email' => 'sabrina@example.com',
            'phone' => '+880 1734567890',
            'address' => 'চট্টগ্রাম, বাংলাদেশ',
            'city' => 'চট্টগ্রাম',
            'school_college' => 'চট্টগ্রাম সরকারি কলেজ',
            'class_grade' => 'Class 12',
            'parent_name' => 'মোঃ আব্দুল মালেক',
            'parent_phone' => '+880 1834567890',
            'status' => 'active',
        ]);
    }
}
