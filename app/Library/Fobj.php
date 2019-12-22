<?php

namespace App\Library;

use Illuminate\Support\Facades\Config;

class Fobj
{
    /**
     * [getLavel description]
     * @param  string $config [description]
     * @return string         [description]
     */
    static public function getLavel( string $config)
    {
        return Config::get($config);
    }

    /**
     * [createSelectBox]
     * @param  string $name       [description]
     * @param  string $label      [コンフィグのラベル]
     * @param  string $selected   [初期値]
     * @param  array  $elements   [エレメントのオプション]
     * @param  array  $add_option [追加セレクト情報]
     * @param  array  $del_option [削除セレクト情報]
     * @return htmlelement        [selectbox]
     */
    static public function select( $name, $label, $selected='', $elements=array(), $add_option=array(), $del_option=array())
    {
        return Fobj::makeSelectBoxHtml( $name, Config::get($label), $selected, $elements, $add_option, $del_option);
    }

    /**
     * [createYearSelectBox]西暦専用セレクトボックス
     * @param  string $name       [description]
     * @param  int    $start      [開始年]
     * @param  int    $end        [終了年]
     * @param  string $selected   [初期値]
     * @param  array  $elements   [description]
     * @param  array  $add_option [description]
     * @return htmlelement        [selectbox]
     */
    static public function yearSelectBox( $name, $start, $end=0, $selected='', $elements=array(), $add_option=array())
    {
        if ( empty($end) ) {
            $end = date('Y');
        }
        $options = [];
        for ($i=$start; $i<=$end; $i++) {
            $options[$i] = $i;
        }
        return Fobj::makeSelectBoxHtml( $name, $options, $selected, $elements, $add_option, array());
    }

    /**
     * [createRadio description]
     * @param  string $name       [description]
     * @param  string $label      [description]
     * @param  string $checked    [description]
     * @param  array  $elements   [description]
     * @param  array  $add_option [description]
     * @param  array  $del_option [description]
     * @return htmlelement        [radiobutton]
     */
    static public function radio( $name, $label, $checked='', $elements=array(), $add_option=array(), $del_option=array())
    {
        $lists = Config::get($label);

        $element_op = 'name="'. $name. '"';
        if (!empty($elements)) {
            foreach($elements as $key => $val) {
                $element_op .= ' '. $key. '="'. $val. '"';
            }
        }

        if (!empty($del_option)) {
            foreach($del_option as $val) {
                unset($lists[$val]);
            }
        }

        $str = '';
        if (!empty($add_option)) {
            foreach($add_option as $key => $val) {
                $chkd = $checked==$key? ' checked="checked"': '';
                $str .= '<input type="radio" id="'. $name. '_'. $key. '" '. $element_op. 'value="'. $key. '" '. $chkd. '>'. $val;
                $str .= '&nbsp;';
            }
        }
        foreach($lists as $key => $val) {
            $chkd = $checked==$key? ' checked="checked"': '';
            $str .= '<input type="radio" id="'. $name. '_'. $key. '" '. $element_op. 'value="'. $key. '" '. $chkd. '>'. $val;
            $str .= '&nbsp;';
        }
        return $str;
    }


    /** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * エレメント作成
     */

     /**
      * [makeSelectBoxHtml description]
      * @param  string $name       [description]
      * @param  array  $options    [description]
      * @param  string $selected   [description]
      * @param  array  $elements   [description]
      * @param  array  $add_option [description]
      * @param  array  $del_option [description]
      * @return [type]             [description]
      */
     static public function makeSelectBoxHtml( $name, $options, $selected='', $elements=[], $add_option=[], $del_option=[])
     {
         $str = '<select id="'. $name. '" name="'. $name. '"';
         if (!empty($elements)) {
             foreach($elements as $key => $val) {
                 $str .= ' '. $key. '="'. $val. '"';
             }
         }
         $str .= '>';
         if (!empty($add_option)) {
             foreach($add_option as $key=> $value) {
                 $options[$key] = $value;
             }
         }

         if (!empty($del_option)) {
             foreach($del_option as $val) {
                 unset($options[$val]);
             }
         }
         foreach($options as $key => $val) {
             $select = $selected==$key? ' selected':'';
             $str.= '<option value="'. $key. '"'. $select. '>'. $val. '</option>';
         }
         $str .= "</select>";
         return $str;
     }

}
