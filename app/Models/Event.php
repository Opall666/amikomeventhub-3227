<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    // ✅ Kolom yang boleh diisi massal
    protected $fillable = [
        'category_id',
        'title',
        'organizer',
        'description',
        'date',
        'location',
        'location_detail',
        'price',
        'stock',
        'poster_path',
        'guest_star',
    ];

    // ✅ Cast date ke datetime object
    protected $casts = [
        'date' => 'datetime',
    ];

    // ✅ Relasi ke Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}