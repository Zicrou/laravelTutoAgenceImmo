<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageUpload extends Model
{
    use HasFactory;

    protected $table = 'image_uploads';
    protected $fillable = ['image', 'property_id'];
    
    public function property() {
        return $this->belongsTo(Property::class);
    }
}

