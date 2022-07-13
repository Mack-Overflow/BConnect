<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\TextMessage;
use App\Services\GenerateReviewUrlService;

class SendReviewText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Text Message instance that will be sent with review link
     * @var TextMessage
     */
    public $textMessage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TextMessage $tm)
    {
        $this->textMessage = $tm;
    }

    /**
     * Execute the job.
     * @param SmsService $sms
     * @param GenerateReviewUrlService $genReview
     *
     * @return void
     */
    public function handle(GenerateReviewUrlService $genReview, SmsService $sms, string $reviewerPhoneNo)
    {
        $header = 'We want your feedback!';
        $body = 'Take a minute at the provided link to give us a rating and share your experience.';
        $sendToTypes = ['Review Invite' => 1];
        
        $shortUrl = $genReview->generate();

        // FOR DEVELOPMENT ENV ONLY!
        $reviewUrl = 'http://localhost:3000/create-review/'.$shortUrl;

        $subscriberId = Subscriber::find($reviewerPhoneNo)->id;
        Url::create(['fullUrl' => $reviewUrl, 'shortUrl' => $shortUrl, '']);

        $sms->send($header, $body, $sendToTypes, $reviewUrl, $reviewerPhoneNo);
    }
}
