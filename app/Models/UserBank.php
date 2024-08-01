<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_bank';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'bank_id';
    protected $guarded = [];
    public $timestamps = false;
    
    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'customer_id', 'user_id');
    }
}
