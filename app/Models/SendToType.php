<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendToType extends Model
{
    use HasFactory;

    protected $primaryKey = 'type';

    protected $fillable = [
        'type',
        'description',
        'timesSent'
    ];
}
