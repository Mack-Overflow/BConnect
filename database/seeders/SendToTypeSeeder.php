<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SendToType;

class SendToTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SendToType::firstOrCreate([
            'type' => 'Uncontacted',
            'description' => 'Newly uploaded clientele who have yet to be send review invite',
        ]);

        SendToType::firstOrCreate([
            'type' => 'Review Invite',
            'description' => 'Clients who have visited and been sent invite to leave review',
        ]);

        SendToType::firstOrCreate([
            'type' => 'Opt-In Invite',
            'description' => 'Invitation to opt-in to marketing messages',
        ]);

        SendToType::firstOrCreate([
            'type' => 'Have Redeemed',
            'description' => 'Have redeemed at least one promo code or visited one discount URL',
        ]);

        SendToType::firstOrCreate([
            'type' => 'Have Redeemed Multiple',
            'description' => 'Have redeemed more than 1 discount URL',
        ]);
    }
}
