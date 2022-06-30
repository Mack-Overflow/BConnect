<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use User;

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
    protected $foreignKey = 'manager_id';

    // Associate review data directly as business attributes, 
    // Or create separate model for review data?
    protected $fillable = [
        'business_name',
        'package_tier',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'businessId', 'id');
    }
}
