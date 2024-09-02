<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin IdeHelperPost
 */

class UploadImageProperty extends Model
{
    use HasFactory;
    //use SoftDeletes;


    protected $fillable =[
        'image_upload_id',
        'property_id',
    ];    
}
