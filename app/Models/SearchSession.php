<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Group;
use App\Models\User;
use App\Models\UserChoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchSessions extends Model
{
    use HasFactory;

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
        return $this->hasMany(UserChoice::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}