<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'coupon_id';
    protected $guarded = [];
    public $timestamps = false;

    // public function block_user()
    // {
    //     return $this->hasOne('App\User', 'UserID', 'user_id')->select('UserID','Firstname','ProfileImage');
    // }
}
