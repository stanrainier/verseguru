<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePicture extends Model
{
    public function profilePicture()
    {
        return $this->hasOne(ProfilePicture::class);
    }
}