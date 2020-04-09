<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminAccountCreateRequest extends FormRequest
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
            'name'         => 'required|max:20|unique:admins,name,'.$this->route('admin'),
            'userid'       => 'required|regex:/^[a-zA-Z0-9]+$/|min:4|max:20|unique:admins,userid,'.$this->route('admin'),
            'password_org' => 'required|regex:/^[a-zA-Z0-9]+$/|min:4|max:20'
        ];
        return $validation;
    }

    public function attributes()
    {
        return [
            'name'         => 'アカウント名',
            'userid'       => 'ログインID',
            'password_org' => 'パスワード'
        ];
    }
}