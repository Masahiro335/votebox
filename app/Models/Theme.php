<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Theme extends Model
{
	//お題の募集タイプ
	const TYPE = [
		'ACTIVE' => 10,
		'CLOSE' => 20,
		'PLAN' => 30,
	];

	//お題のソートタイプ
	const SORT = [
		'10' => '最新順',
		'20' => '終了順',
		'30' => '開始順',
	];

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
		return $query
			->where('Themes.is_deleted', false)
			->where('Themes.is_invalid', false)
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
		if( empty($request->input('type_id')) || $request->input('type_id') == $this::TYPE['ACTIVE']){
			$query
				->whereDate('Themes.start_date_time', '<=', date('Y-m-d') )
				->whereDate('Themes.end_date_time', '>=', date('Y-m-d') )
			;
		//募集終了
		}elseif($request->input('type_id') == $this::TYPE['CLOSE']){
			$query->whereDate('Themes.end_date_time', '<', date('Y-m-d') );
		//募集予定
		}else{
			$query->whereDate('Themes.start_date_time', '>', date('Y-m-d') );
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

		//ソート
		if( empty($request->input('sort')) == false ){
			switch($request->input('sort')){
				case '10':
					$query->orderBy('Themes.created_at', 'desc');
					break;
				case '20':
					$query->orderBy('Themes.end_date_time', 'asc');
					break;
				case '30':
					$query->orderBy('Themes.start_date_time', 'asc');
					break;
				default:
					$query->orderBy('Themes.created_at', 'desc');
					break;
			}
		}else{
			$query->orderBy('Themes.created_at', 'desc');
		}

		return $query;
	}

	/**
	 * 投票できる状態かお題か確認する
	 *
	 * @param Entity $Auth ログイン情報
	 * @return bool ture:投票できる　false:できない
	 */
	public function isVote($Auth)
	{
		
		//募集終了はできない
		if( new Datetime($this->end_date_time) <= new Datetime(date('Y-m-d').' 23:59:59.9999') ){
			return false;
		}

		//自身の投稿は投票できない
		if($this->user_id == $Auth['id']){
			return false;
		}

		//一度投票したのは投票できない
		foreach($this->votes as $entVote){
			if( empty($entVote->vote_users) == false ){
				foreach($entVote->vote_users as $entVoteUser){
					if( $entVoteUser->user_id == $Auth['id'] ) return false;
				}
			}
		}
		return true;
	}


	/**
	 * グラフのデータを出力
	 *
	 * @param Entity $Auth ログイン情報
	 * @return array $data グラフのデータ
	 */
	public function graphData( $Auth )
	{
		$data = [];
		foreach($this->votes as $key => $entVote){
			$data['vote_name'][] = $entVote->name;
			$data['vote_coount'][] = empty($entVote->vote_users) ? 0 : count($entVote->vote_users);
			$data['is_vote'][] = false;
			//ユーザーが投票したかどうか
			foreach($entVote->vote_users as $entVoteUser){
				if( $entVoteUser->user_id == $Auth['id'] ){
					$data['is_vote'][$key] = true;
				}
			}
			//投票最大値を取得
			if( empty($data['coount_max']) || count($entVote->vote_users) > $data['coount_max'] ){
				$data['coount_max'] = count($entVote->vote_users);
			}
		}

		return $data;
	}


	/**
	 * 募集終了までの日付または時間を出力
	 *
	 * @return string $voteLeftDay 募集終了までの日付または時間
	 */
	public function voteLeftDay()
	{
		$diff = (new DateTime($this->end_date_time))->diff(new DateTime(date('Y-m-d H:i:s')));

		$voteLeftDay = $diff->format('%a').'日';
		if( $voteLeftDay == '0日' ){
			$voteLeftDay = $diff->format('%h').'時間';
		}

		return $voteLeftDay;
	}
}
