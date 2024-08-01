<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'withdrawal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'withdrawal_id';
    protected $guarded = [];
    public $timestamps = false;
    
    public function userbank()
    {
        return $this->hasOne('App\Models\UserBank', 'bank_id', 'bank_id');
    }
    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'customer_id', 'user_id');
    }
}
