<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Group;
use App\Models\User;
use App\Models\UserChoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'event_id',
        'searched_date',
        'start_time',
        'end_time',
        'city',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function user_choices()
    {
        return $this->hasMany(UserChoice::class, 'session_id', 'id');
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
