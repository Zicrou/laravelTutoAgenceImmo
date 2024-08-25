<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


/**
 * @mixin IdeHelperPost
 */

class Property extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable =[
        'title', //=> ['','',''],
        'description', //=> ['','',''],
        'surface', //=> ['','',''],
        'rooms', //=> ['','',''],
        'bedrooms', //=> ['','',''],
        'floor', //=> ['','',''],
        'price', //=> ['','',''],
        'city', //=> ['','',''],
        'address', //=> ['','',''],
        'postal_code', //=> ['','',''],
        'sold', //=> ['','','']
        'image'
    ];

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ImageUpload::class);
    }

    public function getslug(): string
    {
        return Str::slug($this->title);
    }

    public function scopeAvailable(Builder $builder, bool $available = true): Builder
    {
        return $builder->where('sold', !$available);
    }

    public function scopeRecent(Builder $builder)
    {
        return $builder->orderBy('created_at', 'desc');
    }

    public function imageUrl(): string{
        return Storage::disk('public')->url($this->images);
    }
}
