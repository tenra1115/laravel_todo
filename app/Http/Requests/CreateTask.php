<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    // authorizeとrulesがあればフォームリクエストは使えるようになる。
    public function authorize()
    {
        // ここに飛んできたときの処理をtrueにする
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // 適用されるバリデーションの検証ルールを設定する。
        return [
            'title' => 'required|max:100',
            'due_date' => 'required|date|after_or_equal:today',
        ];
    }

    public function attributes()
    {
        // rulesで指定したバリデーションでエラーが帰ってきたときのメッセージの項目名を変更できる
        // 入力欄の名称をカスタマイズ
        return [
            'title' => 'タイトル',
            'due_date' => '期限日',
        ];
    }

    public function messages()
    {
        // キーで表示される要素を指定する
        // この場合だとdue_dateが項目でafter_or_equalがルールになっている
        return [
            'due_date.after_or_equal' => ':attribute には今日以降の日付を入力してください。',
        ];
    }
}
