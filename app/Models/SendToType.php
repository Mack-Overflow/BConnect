<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendToType extends Model
{
    use HasFactory;

    protected $table = 'send_to_types';

    protected $primaryKey = 'type';
    protected $keyType = 'string';

    protected $fillable = [
        'type',
        'description',
        'timesSent'
    ];
}
