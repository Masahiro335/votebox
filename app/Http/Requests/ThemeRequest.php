<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemeRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'body' => ['required','max:100'],
			'vote_names' => ['required','array','between:2,4'],
			'vote_names.*' => ['required','max:10'],
			'start_date_time' =>  ['required','date_format:Y-m-d H:i'],
			'end_date_time' => ['required','date_format:Y-m-d H:i','after:start_date_time'],
			'is_invalid' => ['boolean'],
		];
	}

	//バリデーションメッセージ
	public function messages()
	{
		return [
			'body.required' => 'お題は必須項目です。',
			'body.max' => '100文字以内で入力して下さい。',
			'vote_names.between' => '投票項目は2~4つまでにして下さい。',
			'vote_names.*.required' => '投票項目は必須項目です。',
			'vote_names.*.max' => '10文字以内で入力して下さい。',
			'start_date_time.required' => '開始日時は必須項目です。',
			'start_date_time.date_format' => '正しい入力をしてください。',
			'end_date_time.required' => '終了日時は必須項目です。',
			'end_date_time.date_format' => '正しい入力をしてください。',
			'end_date_time.after' => '開始日時より前は記入できません。',
		];
	}
}
