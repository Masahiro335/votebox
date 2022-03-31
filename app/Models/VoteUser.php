<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteUser extends Model
{
	use HasFactory;

	public function vote()
	{
		return $this->belongsTo(Theme::class)->where('is_deleted', false);
	}

	public function user()
	{
		return $this->belongsTo(User::class)->where('is_deleted', false);
	}
}
