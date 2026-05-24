<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price_per_hour', 'image', 'is_active'
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
