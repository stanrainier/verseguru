<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    protected $table = 'search_histories';

    protected $fillable = [
        'user_id',
        'search_query',
    ];

    // Define relationships or additional methods if needed
}