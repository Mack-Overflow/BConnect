<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    /**
     * Primary key associated with the table.
     * 
     * @var string
     */

    protected $primaryKey = 'phoneNumber';
    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'visitDate',
        'phoneNumber'
    ];
}
