<?php

class sentenceInfo
{
    private $host = "127.0.0.1";
    private $user = "root";
    private $password = "";
    private $dbname = "sentencetest";


    public $sId = null;
    public $memo = null;
    public $content = null;
    public $answer=null;
    public $translation = null;
    public $tips = null;
    public $created_at = null;
    public $updated_at = null;

    function __construct()
    {
        date_default_timezone_set('PRC');
    }

    function __destruct()
    {
    }

    public function getId()
    {
        return $this->sId;
    }

    public function getMemo()
    {
        return $this->memo;
    }

    public function setMemo($memo)
    {
        $this->memo = $memo;
        return $memo;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $content;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function setAnswer($answer)
    {
        $this->answer = $answer;
        return $answer;
    }


    public function getTranslation()
    {
        return $this->translation;
    }

    public function setTranslation($translation)
    {
        $this->translation = $translation;
        return $translation;
    }

    public function getTips()
    {
        return $this->tips;
    }

    public function setTips($tips)
    {
        $this->tips = $tips;
        return $tips;
    }

    public function loadById($id)
    {
        //connect
        $link = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($link->connect_errno) {
            throw new Exception("Connect failed: {$link->connect_error}");
        }
        $sql = "select * from `sentenceinfo` where `sId`={$id}";
        $result = $link->query($sql);
        if ($result) {
            // Cycle through results
            if ($row = $result->fetch_object()) {
                $arrRow = (array)$row;
                $this->sId = $arrRow['sId'];
                $this->memo = $arrRow['memo'];
                $this->content = $arrRow['content'];
                $this->answer = $arrRow['answer'];
                $this->translation = $arrRow['translation'];
                $this->tips = $arrRow['tips'];
                $this->created_at = $arrRow['created_at'];
                $this->updated_at = $arrRow['updated_at'];
            }
            // Free result set
            $result->close();
        }
        //close
        $link->close();
        return $this;
    }

    public function select($sql)
    {
        //connect
        $link = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($link->connect_errno) {
            throw new Exception("Connect failed: {$link->connect_error}");
        }
        $ret = array();
        $result = $link->query($sql);
        if ($result) {
            // Cycle through results
            while ($row = $result->fetch_object()) {
                array_push($ret, (array)$row);
            }
            // Free result set
            $result->close();
        }
        //close
        $link->close();
        return $ret;
    }
    /**get collection*/
    public function getCollection($sql = null)
    {
        //connect
        $link = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($link->connect_errno) {
            throw new Exception("Connect failed: {$link->connect_error}");
        }
        if (empty($sql)) {
            $sql = 'select * from `sentenceinfo`';
        }
        $ret = array();
        $result = $link->query($sql);
        if ($result) {
            // Cycle through results
            while ($row = $result->fetch_object()) {
                $arrRow = (array)$row;
                $info = new sentenceInfo;
                $info->sId = $arrRow['sId'];
                $info->memo = $arrRow['memo'];
                $info->content = $arrRow['content'];
                $info->answer = $arrRow['answer'];
                $info->translation = $arrRow['translation'];
                $info->tips = $arrRow['tips'];
                $info->created_at = $arrRow['created_at'];
                $info->updated_at = $arrRow['updated_at'];
                array_push($ret, $info);
            }
            // Free result set
            $result->close();
        }
        //close
        $link->close();
        return $ret;
    }

    /**save*/
    public function save()
    {
        if (empty($this->content) || empty($this->answer)) {
            throw new Exception('Content or answer is empty');
            return;
        }
        //connect
        $link = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($link->connect_errno) {
            throw new Exception("Connect failed: {$link->connect_error}");
        }

        $today = date('Y-m-d');
        if (empty($this->sId)) {
            //new a record
            $link->query("insert into `sentenceinfo`(`memo`,`content`,`answer`,`translation`,`tips`,`created_at`,`updated_at`)
values ('{$this->memo}','{$this->content}','{$this->answer}','{$this->translation}','{$this->tips}','{$today}','{$today}')");
            $this->sId = $link->insert_id;
        } else {
            //update a existing record
            $link->query("update `sentenceinfo` set `memo`='{$this->memo}',`content`='{$this->content}',`answer`='{$this->answer}',`tips`='{$this->tips}',`updated_at`='{$this->updated_at}' where `sId`={$this->sId}");
        }
        //close
        $link->close();
    }

    /**delete*/
    public function delete()
    {
        if (empty($this->sId)) {
            throw new Exception("Can not delete a record of which id is null");
        }
        //connect
        $link = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($link->connect_errno) {
            throw new Exception("Connect failed: {$link->connect_error}");
        }
        $link->query("delete from `sentenceinfo` where `sId`={$this->sId}");
        //close
        $link->close();
    }

    function test()
    {
        $link = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($link->connect_errno) {
            throw new Exception("Connect failed: {$link->connect_error}");
            return;
        }
        $result = $link->query('select * from `sentenceinfo`');
        $user_arr = array();
        if ($result) {
            // Cycle through results
            while ($row = $result->fetch_object()) {
                $user_arr[] = $row;
            }
            // Free result set
            $result->close();
        }
        $link->close();
    }
}

function readCsv($fileName)
{
    $header = array();
    $csv = array();
    $lineNum = 0;
    if (($handle = fopen($fileName, "r")) !== FALSE) {
        $utf8header = fread($handle, 3);
        if (!empty($utf8header) && !empty($utf8header[0]) && !empty($utf8header[1]) && !empty($utf8header[2])
            && $utf8header[0] == chr(0xEF) && $utf8header[1] == chr(0xBB) && $utf8header[2] == chr(0xBF)
        ) {//the file is utf-8 format

        } else {//the file is not utf-8 format
            fseek($handle, 0);
        }

        while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
            if ($lineNum == 0) {
                $header = $data;
                $csv[$lineNum] = $header;
            } else {
                $line = array();
                for ($i = 0; $i < count($data); ++$i) {
                    $line[$header[$i]] = $data[$i];
                }
                $csv[$lineNum] = $line;
            }
            ++$lineNum;
        }
    }
    fclose($handle);
    return $csv;
}

function toCsvStr($arr)
{
    $str = '"';
    if (count($arr) == 0) {
        return;
    }
    $header = $arr[0];
    $str .= implode('","', $header);
    $str .= "\"\n";
    for ($i = 1; $i < count($arr); ++$i) {
        $line = "";
        foreach ($header as $columnName) {
            $line .= '"' . $arr[$i][$columnName] . '",';
        }
        $line = substr($line, 0, strlen($line) - 1);
        $str .= $line . "\n";
    }
    return $str;
}

