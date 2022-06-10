<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextMessage extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $foreignKey = 'businessId';

    protected $fillable = [
        'header',
        'body',
        'url'
    ];
}
