<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartSearchHistory extends Model
{
    protected $table = 'smart_search_histories';

    protected $fillable = [
        'user_id',
        'search_query',
    ];

    // Define relationships or additional methods if needed
}