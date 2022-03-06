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
			'vote-items.*' => ['required','max:10'],
		];
	}

	//バリデーションメッセージ
	public function messages()
	{
		return [
			'body.required' => 'お題は必須項目です。',
			'body.max' => '100文字以内で入力して下さい。',
			'vote-items.*.required' => '投票項目は必須項目です。',
			'vote-items.*.max' => '10文字以内で入力して下さい。',
		];
	}
}
