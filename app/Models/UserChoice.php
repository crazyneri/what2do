<?php

namespace App\Models;

use App\Models\Category;
use App\Models\SearchSession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChoice extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function search_session()
    {
        return $this->belongsTo(SearchSession::class);
    }
    public function category()
    {
        return $this->hasOne(Category::class);
    }
}
