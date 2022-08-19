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
        'google_place_id',
        'google_review_count_onboarding', // Total Google reviews when company registered
        'total_google_review_count' // Total Google review count now
    ];

    public static function find(int $id)
    {
        return Business::where('id', $id)->first();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'businessId', 'id');
    }

    /**
     * 
     */
    public function totalMessagesSent()
    {
        // return count($this->sub)
    }

    public function fetchReviewData()
    {

    }
}
