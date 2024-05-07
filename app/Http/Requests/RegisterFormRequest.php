<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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
    public function rules()
    {
        return [
            'over_name'  => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'under_name_kana' => 'required|string|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'mail_address' => 'required|unique:users,mail_address|max:100',
            'sex' => 'required|in:1,2,3',
            'old_year' => 'required|integer|min:2000|max:'. Carbon::now()->year,
            'old_month' => 'required|integer|between:1,12',
            'old_day' => 'required|integer|between:1,31',
            'role' => 'required|in:1,2,3,4',
            'password' => 'required|min:8|max:30|confirmed',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
        $old_year = $this->input('old_year');
        $old_month = $this->input('old_month');
        $old_day = $this->input('old_day');
        try {
            $inputDate = Carbon::createFromDate($old_year, $old_month, $old_day);
            $startDate = Carbon::createFromDate(2000, 1, 1);
            $endDate = Carbon::now();
            if ($inputDate->lt($startDate) || $inputDate->gt($endDate)) {
                $validator->errors()->add('old_year', '日付は2000年1月1日から今日までの間である必要があります。');
            }
            }
        catch (\Exception $e) {
            $validator->errors()->add('old_year', '無効な日付です。正しい日付を選択してください。');
            }
        });
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
