<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminAccountUpdateRequest extends FormRequest
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
            'name'         => 'required|max:20|'.Rule::unique('admins')->ignore($this->data_id),
            'userid'       => 'required|regex:/^[a-zA-Z0-9]+$/|min:4|max:20|'.Rule::unique('admins')->ignore($this->data_id),
            'password_org' => 'required|regex:/^[a-zA-Z0-9]+$/|min:4|max:20',  // パスワード被りは可
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