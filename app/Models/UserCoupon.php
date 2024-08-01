<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_coupons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'user_coupon_id';
    protected $guarded = [];
    public $timestamps = false;
    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'customer_id', 'user_id');
    }
}
