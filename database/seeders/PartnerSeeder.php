<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::create([
            'name' => 'প্রত্যয় কোচিং সেন্টার',
            'email' => 'info@prottay.com',
            'phone' => '+880 1234567890',
            'address' => 'রংপুর, বাংলাদেশ',
            'city' => 'রংপুর',
            'description' => 'প্রত্যয় কোচিং সেন্টার একটি বিশ্বস্ত শিক্ষা প্রতিষ্ঠান যা শিক্ষার্থীদের উচ্চ শিক্ষার জন্য প্রস্তুত করে।',
            'status' => 'active',
        ]);

        Partner::create([
            'name' => 'বিকল্প অনলাইন টেস্ট',
            'email' => 'info@bikolpo.com',
            'phone' => '+880 9876543210',
            'address' => 'ঢাকা, বাংলাদেশ',
            'city' => 'ঢাকা',
            'description' => 'বিকল্প অনলাইন টেস্ট সিস্টেম একটি আধুনিক ডিজিটাল শিক্ষা প্ল্যাটফর্ম।',
            'status' => 'active',
        ]);
    }
}
