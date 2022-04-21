<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	use HasFactory;

	protected $fillable = ['name','password','is_deleted'];

	public function themes()
	{
		return $this->hasMany(Theme::class)->orderBy('created_at', 'desc')->where('is_deleted', false);
	}

	public function vote_users()
	{
		return $this->hasMany(VoteUser::class)->orderBy('created_at', 'desc');
	}


	/**
	 * ユーザーが投票した投稿IDを返す
	 *
	 * @return array
	 */
	public function themeIdsVoteUsers()
	{
		$themeIds = [];
		if( empty($this->vote_users) == false ){
			foreach($this->vote_users as $entVoteUser){
				$themeIds[] = $entVoteUser->vote->theme_id;
			}
		}
		return $themeIds;
	}

}
