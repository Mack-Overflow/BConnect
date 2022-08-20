<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\Subscriber;
use App\Models\Review;
use App\Services\SmsService;
use Twilio\TwiML\MessagingResponse;

class OptInOutService
{
    /**
     * Data processing for IncomingSmsController 
     * 
     */
    public static function handleResponse(Request $request, Subscriber $subscriber) 
    {
        // \Log::info($request['Body']);

        $body = trim(strToLower($request['Body'])); // Get Message Body from Request

        $isValid = self::isValidCommand($body); // Is the response a valid command ?
        // if (!$isValid) return "Error: Invalid command"; // Return Twiml error message
        if (!$isValid) \Log::info('Error: Invalid command');
        // Valid command and last message sent to the subscriber is Review Invite
        $rating = ($subscriber->lastMsgSentType === 'Review Invite') ? self::isRating($body) : null; // Is the body a rating ?
        
        // if (!self::isValidCommand($body)) return response()->json(['err])
        \Log::info($subscriber->subscribed);
        if ($rating) self::handleRating($subscriber, $rating);

        // Command is valid but is not a rating, handle subscribe, unsubscribe, or resubscribe
        if (!$rating) self::handleAction($subscriber, $body);
    }

    /**
     * Handle rating, save as review
     * @param Subscriber $subscriber
     * @param int $rating
     */
    public static function handleRating(Subscriber $subscriber, int $rating)
    {
        $customerName = $subscriber->firstName.' '.$subscriber->lastName;
        $associatedBusiness = Business::find($subscriber->businessId);

        // Handle overloading ratings

        // Store rating with no review body
        $review = Review::create([
            'rating' => $rating, 
            'customerName' => $customerName, 
            'businessId' => $subscriber->businessId
        ]);

        // If rating is 5, send Google review link directly to customer
        // Otherwise, send internal review link to customer
        if ($rating === 5) {
            SmsService::send(
                'Leave us a review on Google!', 
                'We would love you to share your experience with others. Visit the link below to leave us a google review',
                'Google Review Invite',
                'https://search.google.com/local/writereview?placeid='.$associatedBusiness->google_place_id,
                $associatedBusiness->id,
                $subscriber->phoneNumber
            );
        } else {
            if (getenv('APP_ENV') === 'staging') {
                $link = 'https://client.bconnect-staging.com/create-review';
            } else if (getenv('APP_ENV') === 'local') {
                $link = getenv('NGROK_URL').'/create-review';
            }
            // Production Link
            SmsService::send(
                'Leave us a review',
                'We would love you to share your experience with others. Visit the link below to leave us a review',
                $link,
                $associatedBusiness->id,
                $subscriber->phoneNumber
            );
        }
        // SMS Service -> send() : Params
        // Please take a moment to leave us a review on Google
    }

    public static function handleAction(Subscriber $subscriber, string $command)
    {
        switch (true) {
            case ($command === 'start' || $command === 'unstop' || $command === 'join' || $command === 'yes'):
                $msg = "You are now subscribed. Text STOP to quit";
                $subscriber->subscribed = 1;
                break;
            case ($command === 'stop' || $command === 'unjoin' || $command === 'end' || $command === 'stopall' || $command === 'unsubscribe'):
                $subscriber->subscribed = - 1;
                $msg = "You are now unsubscribed. You can text JOIN at any time to resubscribe";
                break;
        }
        \Log::info($msg);
        try {
            $subscriber->save();
            \Log::info(Subscriber::find($subscriber->phoneNumber));
            return response()->json(['message' => $msg], 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Unable to process command']);
        }
    }

    // public static function helloWorld(mixed $message)
    // {
    //     return "Message: ".$message;
    // }


    public static function generateOutputMessage($subscriber, $message)
    {
        $subscribe = 'join';
        $message = trim(strtolower($message));

        if (!self::isValidCommand($message)) {
            return self::messageText();
        }

        $isSubscribed = starts_with($message, $subscribe);
        $subscriber->subscribed = $isSubscribed;
        $subscriber->save();

        return $isSubscribed
            ? self::messageText('join')
            : self::messageText('stop');
    }

    public static function isRating(string $body)
    {
        Log::info($body);
        $rating = (intval(trim($body)) > 0) ? intval(trim($body)) : null;
        Log::info($rating);
        return $rating;
    }

    public static function isValidCommand($command)
    {
        $valid_arr = [
            1, 2, 3, 4, 5, 'start', 'unstop', 'join', 'yes', 'stop', 'unjoin', 'quit', 'end', 'stopall', 'unsubscribe'
        ];
        return in_array($command, $valid_arr);
    }
}