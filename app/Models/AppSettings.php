<?php

namespace App\Models;
use App\Models\Banner;
use DataTables,Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSettings extends Model
{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'app_settings_id';
    protected $guarded = [];
    public $timestamps = false;
}
