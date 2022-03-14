<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
			'name' => ['required','max:20','alpha_dash','unique:users'],
			'password' => ['required','min:8','max:20','alpha_dash'],
		];
	}

	//バリデーションメッセージ
	public function messages()
	{
		return [
			'name.required' => 'ユーザー名は必須項目です。',
			'name.max' => '20文字以内で入力して下さい。',
            'name.alpha_dash' => '半角英数字のみで記入して下さい。',
            'name.unique' => '既にこのユーザー名は登録されています。',
			'password.required' => 'パスワードは必須項目です。',
			'password.min' => '8文字以上で記入して下さい。',
            'password.max' => '20文字以内で記入して下さい。',
            'password.alpha_dash' => '半角英数字のみで記入して下さい。',
		];
	}
}
