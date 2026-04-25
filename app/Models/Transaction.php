<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
        protected $fillable = [
        'event_id',
        'order_id',
        'customer_name',
        'customer_email',
        'customer_phone',   
        'total_price',
        'status',
        'snap_token',
    ];

    // Relasi ke Event (optional, untuk nanti)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
