<?php
namespace App\Validator;

/**
 * カスタムバリデーション
 */
class CustomValidator extends \Illuminate\Validation\Validator
{

    /**
     * [alpha_puls description]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validateAlphaPuls($attribute, $value, $parameters)
    {
        return  preg_match("/^[!-~]+$/", $value);
    }

    /**
     * [alpha_num_all description]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validateAlphaNumAll($attribute, $value, $parameters)
    {
        return  preg_match("/^[a-zA-Z0-9]+$/", $value);
    }

    /**
     * [numeric_puls description]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validateNumericPuls($attribute, $value, $parameters)
    {
        return preg_match('/^[\d-]*$/', $value);
    }

    /**
     * [zipcode description]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validateZipcode($attribute, $value, $parameters)
    {
        return preg_match('/^\d{3}-\d{4}$/', $value);
    }

    /**
     * [tel_no description]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validateTelNo($attribute, $value, $parameters)
    {
        return preg_match("/^0[0-9]{9,10}$/", $value);
    }

    /**
     * [tel_hyphen description]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validateTelHyphen($attribute, $value, $parameters)
    {
        return preg_match("/^0¥d{1,3}-¥d{4}$|^¥d{2,5}-¥d{1,4}-¥d{4}$/", $value);
    }

    /**
     * [katakana_all description]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validateKatakanaAll($attribute, $value, $parameters)
    {
        return preg_match("/^[ァ-ヶｦ-ﾟー]+$/u", $value);
    }

}
