<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;

    public function countris()
    {
        return $this->hasOne('App\Models\Countries', 'id', 'country_id');
    }
}
