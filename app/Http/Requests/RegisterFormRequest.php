<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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

// 日付をまとめる


    public function getValidatorInstance()
    {
        // プルダウンで選択された値(= 配列)を取得
        $year = $this->input('old_year', array());
        $month = $this->input('old_month', array());
        $day = $this->input('old_day', array());
        // 日付を作成(ex. 2020-1-20)
        $birth_day = $year.'-'.$month.'-'. $day;
        // rules()に渡す値を追加でセット
        //     これで、この場で作った変数にもバリデーションを設定できるようになる
        $this->merge([
            'birth_day' => $birth_day,
        ]);

        return parent::getValidatorInstance();
    }




    public function rules()
    {
        return [
            'over_name'  => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'under_name_kana' => 'required|string|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'mail_address' => 'required|unique:users,mail_address|max:100',
            'sex' => 'required|in:1,2,3',
            'birth_day' => 'required|date|after_or_equal:2000-01-01|before:today',
            'role' => 'required|in:1,2,3,4',
            'password' => 'required|min:8|max:30|confirmed',
        ];
    }

    public function messages(){
        return [
            'over_name' => '名前は必ず入力してください。',
            'under_name' => '名前は必ず入力してください。',
            'over_name_kana' => '名前は必ず入力してください。',
            'under_name_kana' => '名前は必ず入力してください。',
            'mail_address' => 'メールアドレスは必ず入力してください。',
            'sex' => '選択してください。',
            'old_year' => '選択してください。',
            'old_month' => '選択してください。',
            'old_day' => '選択してください。',
            'role' => '選択してください。',
            'password' => '8文字以上30文字以下で入力してください。',
        ];
    }
}
