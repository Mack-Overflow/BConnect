<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Business;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Business::firstOrCreate([
            'business_name' => 'Bconnect Dev',
            'google_place_id' => 'ChIJwWJZjhLwsgIRWC4gaAJyfSM'
            ],
            [
                // 'manager_id' => 1,
                'package_tier' => 'High',
                // 'google_review_count_onboarding' => 0,
                // 'total_google_review_count' => 0
        ]);
        // Business::factory()->times(5)->create();
    }
}
