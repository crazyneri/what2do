<?php

namespace App\Models;

use App\Models\SearchSession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'owner_id'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function search_sessions()
    {
        return $this->hasMany(SearchSession::class);
    }
    public function owner()
    {
        return $this->belongsTo(Person::class, 'id', 'owner_id');
    }
}
