<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function themes()
    {
        return $this->hasMany(Theme::class)->where('is_deleted', false);
    }
}
