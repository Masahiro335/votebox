<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
	use HasFactory;

	protected $fillable = ['user_id','body','start_date_time','end_date_time','is_invalid','is_deleted'];

	public function user()
	{
		return $this->belongsTo(User::class)->where('is_deleted', false);
	}

	public function votes()
	{
		return $this->hasmany(Vote::class)->where('is_deleted', false);
	}

	/**
	 * 基準クエリ
	 *
	 * @param Query $query
	 * @return Query
	 */
	public function scopeQueryBasic($query)
	{
		return $query->where('Themes.is_deleted', false)
			->where('Themes.is_invalid', false)
			->orderBy('Themes.created_at', 'desc')
		;
	}

	/**
	 * TOP画面用クエリ
	 *
	 * @param Query $query
	 * @param Request $request
	 * @return Query
	 */
	public function scopeQueryTOP($query, $request)
	{
		$query = $this->scopeQueryBasic($query);

		//募集中
		if( empty($request->input('is_close')) ){
			$query
				->whereDate('Themes.start_date_time', '<=', date('Y-m-d') )
				->whereDate('Themes.end_date_time', '>=', date('Y-m-d') )
			;
		}else{
			$query->whereDate('Themes.end_date_time', '<', date('Y-m-d') );
		}

		//検索
		if( empty($request->input('search')) == false ){
			//1.検索キーワードの「両端のスペース」を削除。
			//2.検索キーワードの間の「全角スペースを半角スペース」に変更。
			//3.検索キーワードにスペースと[,]が入ってた場合、文字列を分裂する。
			$keyWords = preg_split('/[\s,]+/', mb_convert_kana(trim($request->input('search')),'s'));

			//お題の検索
			$query->where(function ($query) use ($keyWords) {
				foreach ($keyWords as $keyWord) {
					$query->orWhere('Themes.body', 'like', '%'.$keyWord.'%');
				}
			});
		}

		return $query;
	}
}
