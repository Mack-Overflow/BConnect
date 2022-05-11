<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $table = 'businesses';
    protected $connection = 'mysql';

    /**
     * @var string
     */
    protected $primaryKey = 'businessId';

    /**
     * @var string
     */
    protected $foreignKey = 'managerUid';

    protected $fillable = [
        'business_name',
        'package_tier',
    ];
}
