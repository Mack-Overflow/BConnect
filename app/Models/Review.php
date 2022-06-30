<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $connection = 'mysql';

    protected $primaryKey = 'reviewId';

    protected $foreignKey = 'businessId';

    protected $fillable = [
        'rating',
        'reviewBody',
        'customerName'
    ];
}
