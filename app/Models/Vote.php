<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
	use HasFactory;

	protected $fillable = ['theme_id','name','sort_number','is_deleted'];

	public function theme()
	{
		return $this->belongsTo(Theme::class)->where('is_deleted', false);
	}

	public function vote_users()
	{
		return $this->hasMany(VoteUser::class);
	}
}
