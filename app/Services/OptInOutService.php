<?php

class OptInOutService
{
    /**
     * Data processing for IncomingSmsController 
     * 
     */


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

    public static function isValidCommand($command)
    {
        return starts_with($command, 'join') || starts_with($command, 'stop');
    }
    
    public static function messageText($messageType = 'unknown') {
        switch($messageType) {
            case 'join':
                return "Thank you for subscribing to notifications!";
                break;
            case 'stop':
                return "The number you texted from will no longer receive notifications. 
            To start receiving notifications again, please text 'join'.";
                break;
            default:
                return "I'm sorry, that's not an option I recognize. 
            Please, let me know if I should 'join' or 'stop' this number from notifications.";
                break;
        }
    }
}