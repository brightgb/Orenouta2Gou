<?php
namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'all_space' => 'accepted',
            'question'  => 'required|max:300'
        ];
        return $validation;
    }

    public function attributes()
    {
        return [
            'question' => 'パスワード'
        ];
    }

    public function messages()
    {
        return [
            'all_space.accepted' => 'スペースだけの入力はご遠慮ください。'
        ];
    }

    public function validationData()
    {
        $flg = true;
        if (preg_match('/^( |　)+$/', $this->question)) {
            $flg = false;
        }
        $this->merge([
            'all_space' => $flg
        ]);
        return $this->all();
    }
}