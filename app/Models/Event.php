<?php

namespace App\Models;

use App\Models\Category;
use App\Models\SearchSession;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'venue_id', 'start_date', 'start_time',
        'end_date', 'end_time', 'description', 'price', 'is_recurring'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
    public function search_session()
    {
        return $this->belongsTo(SearchSession::class);
    }

}
