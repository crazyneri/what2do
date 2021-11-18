<?php

namespace App\Models;

use App\Models\Group;
use App\Models\SearchSession;
use App\Models\UserChoice;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_choices()
    {
        return $this->hasMany(UserChoice::class);
    }
    public function search_sessions()
    {
        return $this->hasMany(SearchSession::class);
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
    public function owned_groups()
    {
        return $this->hasMany(Group::class, 'owner_id', 'id');
    }

    public function venues()
    {
        return $this->hasMany(Venue::class, 'admin_id', 'id');
    }

    public function events(){
        return $this->hasManyThrough(Event::class, Venue::class, 
            'admin_id', // Foreign key on the venues table...
            'venue_id', // Foreign key on the events table...
            'id', // Local key on the venues table...
            'id' // Local key on the users table...
        );
    }
}
