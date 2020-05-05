<?php
namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiRequest;

class SingerSearchRequest extends ApiRequest
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
            'singer_rank'  => 'required|array|min:1',
            'advicer_rank' => 'required|array|min:1'
        ];
        return $validation;
    }

    public function attributes()
    {
        return [
            'singer_rank'  => '歌い手ランク',
            'advicer_rank' => 'アドバイザーランク'
        ];
    }
}