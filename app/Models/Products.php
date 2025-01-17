<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'product_id';
    protected $guarded = [];
    public $timestamps = false;
    public function productcategory()
    {
        return $this->hasOne('App\Models\ProductsCateogry', 'category_id', 'category_id');
    }
}
