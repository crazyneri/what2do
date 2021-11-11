<?php

namespace App\Models;

use App\Models\Event;
use App\Models\UserChoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function user_choice()
    {
        return $this->hasOne(UserChoice::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
