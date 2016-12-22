<?php
/**
 * Created by PhpStorm.
 * User: LiHaicai
 * Date: 2016/12/20
 * Time: 16:18
 */
require 'func.php';
date_default_timezone_set('PRC');
$info = new sentenceInfo();
$result=$info->select('select distinct `created_at` from `sentenceinfo` order by `created_at` asc;');
echo json_encode($result);



