<?php
namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SongUserCreateRequest extends FormRequest
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
            'all_space1'   => 'accepted',
            'all_space2'   => 'accepted',
            'nickname'     => 'required|max:15|unique:song_users,nickname',
            'password_org' => 'required|min:4|max:8|regex:/^[a-zA-Z0-9]+$/'
        ];
        return $validation;
    }

    public function attributes()
    {
        return [
            'nickname'     => 'ニックネーム',
            'password_org' => 'パスワード'
        ];
    }

    public function messages()
    {
        return [
            'nickname.unique'     => '入力された:attributeは既に使用されています。',
            'all_space1.accepted' => 'スペースだけの入力はご遠慮ください。',
            'all_space2.accepted' => 'スペースだけの入力はご遠慮ください。'
        ];
    }

    public function validationData()
    {
        $flg1 = $flg2 = true;
        if (preg_match('/^( |　)+$/', $this->nickname)) {
            $flg1 = false;
        }
        if (preg_match('/^( |　)+$/', $this->password_org)) {
            $flg2 = false;
        }
        $this->merge([
            'all_space1' => $flg1
        ]);
        $this->merge([
            'all_space2' => $flg2
        ]);
        return $this->all();
    }

    /*
     * バリデーションエラー
     */
    protected function failedValidation(Validator $validator)
    {
        $response['status'] = 'NG';
        $response['errors'] = $validator->errors()->toArray();

        throw new HttpResponseException(
            response()->json($response)
        );
    }
}