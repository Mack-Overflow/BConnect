<?php

namespace Database\Factories;

use App\Models\Subscriber;
use App\Models\SendToType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscriber>
 */
class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;  
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $send_to_types = SendToType::pluck('type')->toArray();
        return [
            'firstName' => $this->faker->firstName(),
            'lastName' => $this->faker-> lastName(),
            'visitDate' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'phoneNumber' => $this->faker->e164PhoneNumber(),
            'businessId' => rand(2, 11),
            'googleReviewLinksClicked' => rand(0, 5),
            'lastMsgSentType' => $send_to_types[array_rand($send_to_types)],
        ];
    }
}
