<?php

namespace App\Models;
use App\Models\Banner;
use DataTables,Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_us';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'contact_us_id';
    protected $guarded = [];
    public $timestamps = false;
}
