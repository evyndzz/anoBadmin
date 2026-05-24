<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code', 'user_id', 'guest_name', 'guest_phone', 'date', 'total_price', 'status', 'promo_id', 'discount_applied', 'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
