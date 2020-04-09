<?php
namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;

class SingSongRequest extends FormRequest
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
        $validation = [
            'all_space1' => 'accepted',
            'all_space2' => 'accepted',
            'all_space3' => 'accepted',
            'name'       => 'required|max:100',
            'comment'    => 'required|max:100',
            'youtube'    => 'required|max:128'
        ];
        return $validation;
    }

    public function attributes()
    {
        return [
            'name'    => 'タイトル',
            'comment' => 'コメント',
            'youtube' => '動画ID'
        ];
    }

    public function messages()
    {
        return [
            'all_space1.accepted' => 'スペースだけの入力はご遠慮ください。',
            'all_space2.accepted' => 'スペースだけの入力はご遠慮ください。',
            'all_space3.accepted' => 'スペースだけの入力はご遠慮ください。'
        ];
    }

    public function validationData()
    {
        $flg1 = $flg2 = $flg3 = true;
        if (preg_match('/^( |　)+$/', $this->name)) {
            $flg1 = false;
        }
        if (preg_match('/^( |　)+$/', $this->comment)) {
            $flg2 = false;
        }
        if (preg_match('/^( |　)+$/', $this->youtube)) {
            $flg3 = false;
        }
        $this->merge([
            'all_space1' => $flg1
        ]);
        $this->merge([
            'all_space2' => $flg2
        ]);
        $this->merge([
            'all_space3' => $flg3
        ]);
        return $this->all();
    }
}