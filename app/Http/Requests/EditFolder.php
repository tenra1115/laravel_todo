<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Folder;
use Illuminate\Validation\Rule;

class EditFolder extends CreateFolder
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
        $rule = parent::rules();
        
        $status_rule = Rule::in(array_keys(Folder::STATUS));
        return $rule + [
            'title' => 'required|' . $status_rule,
        ];
    }

    public function attributes()
    {
        $attributes = parent::attributes();

        return $attributes + [
            'title' => 'フォルダ名',
        ];
    }


}
