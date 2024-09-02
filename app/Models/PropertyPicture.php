<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyPicture extends Model
{
    use HasFactory;
    protected $fillable =[
        'picture_id',
        'property_id',
    ];

    protected $table = 'property_pictures';

    public function property(): BelongsTo{
        return $this->belongsTo(Property::class);
    }

    public function pictures(): HasMany{
        return $this->hasMany(Picture::class);
    }
}
