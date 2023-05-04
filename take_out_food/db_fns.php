<!-- // 链接数据库的函数 -->
<?php

function db_connect(){
    $result=new mysqli('localhost','root','','ldfood');
    if (!$result) {
        throw new Exception("无法连接数据库");
    }else {
        return $result;
    }
}

function db_result_to_array($result) {
    $res_array = array();

    for ($count=0; $row = $result->fetch_assoc(); $count++) {
        $res_array[$count] = $row;
    }
    return $res_array;
}
?>