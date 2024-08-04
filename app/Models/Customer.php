<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;


class Customer extends Authenticatable
{
    use HasApiTokens;

    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'customer_id';
    protected $guarded = [];
    public $timestamps = false;

    public function block_user()
    {
        return $this->hasOne('App\User', 'UserID', 'user_id')->select('UserID','Firstname','ProfileImage');
    }
    public function customertype()
    {
        return $this->hasOne('App\Models\CustomerType', 'customer_type_id', 'customer_type');
    }
}
