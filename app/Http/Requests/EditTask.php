<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Task;
use Illuminate\Validation\Rule;

// 中身は同じなのでCreateTaskを継承して使う。状態欄のみ違う
class EditTask extends CreateTask
{

    public function rules()
    {
        $rule = parent::rules();

        // 許可リストを配列の形で取得してくる
        $status_rule = Rule::in(array_keys(Task::STATUS));

        return $rule + [
            'status' => 'required|' . $status_rule,
        ];
    }

    public function attributes()
    {
        return [
            'status' => '状態',
        ];
    }

    public function messages()
    {
        // 親クラスのmessagesを呼び出している。つまりCreateTaskのmessages。
        $messages = parent::messages();

        $status_labels = array_map(function($item){
            return $item['label'];
        }, Task::STATUS);

        // ３つ表示する際に、を要素の間に入れていく処理
        $status_labels = implode('、', $status_labels);

        // statusが選択されているものに対して$status_labelsから選ぶようにしている。
        return $messages + [
            'status.in' => ':attribute には' . $status_labels. 'のいずれかを指定してください。',
        ];
    }
}
