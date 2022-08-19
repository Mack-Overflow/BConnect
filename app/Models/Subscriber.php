<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $table = 'subscribers';

    /**
     * Primary key associated with the table.
     * 
     * @var string
     */
    protected $primaryKey = 'phoneNumber';

    /**
     * @var string
     */
    protected $foreignKey = 'businessId';
    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'visitDate',
        'phoneNumber',
        'businessId',
        'googleReviewLinksClicked',
        'lastMsgSentType', // To check if last message sent was review invite for Subscriber
    ];

    public function scopeActive($query)
    {
        return $query->where('subscribed', 1);
    }

    /**
     * Increments messagesReceived count of instance
     */
    public function sentMessage()
    {
        $this->messagesReceived++;
        $this->save();
        return $this->messagesReceived;
    }
}
