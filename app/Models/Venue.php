<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    public function admin()
    {
        return $this->belongsTo(Person::class, 'venues', 'id', 'admin_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

}
