<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['membership_id', 'court_id', 'days', 'start_time', 'end_time', 'is_available', 'user_id'];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }
}
