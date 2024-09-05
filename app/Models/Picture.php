<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'property_id'];
    //protected $table = 'pictures';

    public function property(): BelongsTo {
        return $this->belongsTo(Property::class);
    }

    

    public function propertyPicture(): BelongsTo{
        return $this->belongsTo(PropertyPicture::class);
    }
}
