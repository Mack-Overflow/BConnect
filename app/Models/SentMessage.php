<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Each business will have one SentMessage type for each SendToType
 */
class SentMessage extends Model
{
    use HasFactory;

    // protected $foreignKey
    protected $table = 'sent_messages';

    protected $foreignKey = 'textMessageId';

    protected $fillable = [
        'businessId',
        'textMessageId',
        'sendToType'
    ];
}
