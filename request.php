<?php
/**
 * Created by PhpStorm.
 * User: LiHaicai
 * Date: 2016/12/20
 * Time: 22:48
 */
require_once 'func.php';

switch ($_POST['action']) {
    case 'getDateList': {
        $info = new sentenceInfo();
        $result = $info->select('select distinct `created_at` from `sentenceinfo` order by `created_at` asc;');
        echo json_encode($result);
        break;
    }
    case 'search': {
        if (!empty($_POST['searchFields'])) {
            $searchFields = $_POST['searchFields'];
            foreach ($searchFields as &$searchField) {
                $searchField .= " like '%{$_POST['key']}%'";
            }
            unset($searchField);
            $whereStr = implode(' or ', $searchFields);
            $info = new sentenceInfo();
            $result = $info->select("select * from `sentenceinfo` where {$whereStr}");
            echo json_encode($result);
            break;
        }
    }
    case 'date': {
        $dateSpan = array();
        if (!empty($_POST['from_date'])) {
            array_push($dateSpan, "`created_at` >= '{$_POST['from_date']}'");
        }
        if (!empty($_POST['to_date'])) {
            array_push($dateSpan, "`created_at` <= '{$_POST['to_date']}'");
        }
        $whereStr = '';
        $info = new sentenceInfo();
        if (count($dateSpan) > 0) {
            $whereStr = implode(' and ', $dateSpan);
            $result = $info->select("select * from `sentenceinfo` where {$whereStr}");
        } else {
            $result = $info->select("select * from `sentenceinfo`");
        }
        echo json_encode($result);
        break;
    }
    case 'saveRecord': {
        if (!empty($_POST['params'])) {
            try {
                $params = $_POST['params'][0];
                $info = new sentenceInfo();
                if (!empty($params['sId'])) {
                    $info->loadById($params['sId']);
                }
                $info->setMemo($params['memo']);
                $info->setContent($params['content']);
                $info->setAnswer($params['answer']);
                $info->setTranslation($params['translation']);
                $info->setTips($params['tips']);
                $info->save();
                echo  '[{"succeed":"succeed to save '.$info->getAnswer().'"}] ';
            } catch (Exception $e) {
                echo "[{\"failed\":\"{$e->getMessage()}\"}]";
            }
        }
    }
    case 'acquireAction':{
        if (isset($_POST['key'])) {
            echo prepareFields($_POST['key']);
        }
    }
}
