<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['user_id', 'verse_text', 'book_id', 'chapter', 'verse'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verse()
    {
        return $this->belongsTo(Verse::class);
    }
}
