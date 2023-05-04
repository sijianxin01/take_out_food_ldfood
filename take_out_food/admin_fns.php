<?php

//删除店铺
function delete_shop($username) {
    $conn=db_connect();
    $query1="delete from foods where username='.$username.'";
    $query2="delete from user where username='.$username.'";
    $result1 = @$conn->query($query1);
    $result2 = @$conn->query($query2);
    if ($result1 and $result2) {
        return true;
    } else {
        return false;
    }
}
//修改类别信息
function delete_cat($deleteid) {
    $conn=db_connect();
    $query='delete from categories where catid='.$deleteid;

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    } else {
        return true;
    }
}

//添加类别
function update_cat($catid, $catname) {
    $conn = db_connect();
    if($catid==0){
        $query="insert into categories values('','".$catname."') ";
    }
    else{
        $query="update categories set catname='".$catname."' where catid=".$catid;
    }

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    } else {
        return true;
    }
}



//修改商家信息
function update_shop($oldusername, $username,$email,$type,$name,$sex,$age,$phone,$qq,$default_pos,$description) {

    $conn = db_connect();

    $query = "update user
             set username= '".$conn->real_escape_string($username)."',
             username = '".$conn->real_escape_string($username)."',
             email = '".$conn->real_escape_string($email)."',
             type = '".$conn->real_escape_string($type)."',
             name = '".$conn->real_escape_string($name)."',
             sex = '".$conn->real_escape_string($sex)."',
             age = '".$conn->real_escape_string($age)."',
             phone = '".$conn->real_escape_string($phone)."',
             qq = '".$conn->real_escape_string($qq)."',
             default_pos = '".$conn->real_escape_string($default_pos)."',
             description = '".$conn->real_escape_string($description)."'
             where username = '".$conn->real_escape_string($oldusername)."'";

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    } else {
        return true;
    }
}



//获取店铺详细信息
function get_shop_details($username) {
    // query database for all details for a particular book
    if ((!$username) || ($username=='')) {
        return false;
    }
    $conn = db_connect();
    $query = "select * from user where username='".$conn->real_escape_string($username)."'";
    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }
    $result = @$result->fetch_assoc();
    return $result;
}
?>