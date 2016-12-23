<meta charset="UTF-8">
<?php
/**
 * Created by PhpStorm.
 * User: LiHaicai
 * Date: 2016/12/20
 * Time: 16:18
 */
require 'func.php';
//$page = downLoad("http://dict.hjenglish.com/jp/jc/%E6%8B%8D%E6%89%8B");
//$translate="";
//$pos_tran_begin = strpos($page, "<div class='simple_content mt10'>");
//if ($pos_tran_begin !== false) {
//    $pos_tran_end = strpos($page, "</div>", $pos_tran_begin + 1);
//    $rawTranslate = substr($page, $pos_tran_begin, $pos_tran_end - $pos_tran_begin);
//    $translate = $str = preg_replace_callback("/<\\/?\\w+>/", function ($match) {
//        return preg_replace("/<\\/?\\w+>/", '', $match[0]);
//    }, $rawTranslate);
//}
//
//$kana="";
//$pos_kana_begin = strpos($page, "<span id='kana_1' class='trs_jp bold' title='假名'>");
//if ($pos_kana_begin !== false) {
//    $pos_kana_end = strpos($page, "</span>", $pos_kana_begin + 1);
//    $rawKana = substr($page, $pos_kana_begin, $pos_kana_end - $pos_kana_begin);
//    $kana = $str = preg_replace_callback("/<\\/?\\w+>/", function ($match) {
//        return preg_replace("/<\\/?\\w+>/", '', $match[0]);
//    }, $rawKana);
//}
//echo $kana;


echo prepareFields("");
