<!-- // 增加和删除书签以及推荐的函数 -->
<?php
require_once('db_fns.php');

//删除菜品
function delete_food($fno) {

    $conn = db_connect();
    $query = "delete from foods
             where fno='".$conn->real_escape_string($fno)."'";
    $result = @$conn->query($query);

    //删除图片
    if (@file_exists("images/foods/{$fno}/"))  {
        deldir("images/foods/{$fno}/");
    }
    if (!$result) {
        return false;
    } else {
        return true;
    }
}


//删除指定文件夹以及文件夹下的所有文件
function deldir($dir) {
    //先删除目录下的文件：
    $dh=opendir($dir);
    while ($file=readdir($dh)) {
        if($file!="." && $file!="..") {
            $fullpath=$dir."/".$file;
            if(!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                deldir($fullpath);
            }
        }
    }
    closedir($dh);
    //删除当前文件夹：
    if(rmdir($dir)) {
        return true;
    } else {
        return false;
    }
}


//菜品信息插入数据库
function insert_food($fno, $username, $title, $catid, $price, $description) {

    $conn = db_connect();

    $query = "select *
             from foods
             where fno='".$conn->real_escape_string($fno)."'";
    $result = $conn->query($query);
    if ((!$result) || ($result->num_rows!=0)) {

        return false;
    }

    // insert new book
    $query = "insert into foods values
            ('".$conn->real_escape_string($fno) ."', '". $conn->real_escape_string($username) .
        "', '". $conn->real_escape_string($title) ."', '". $conn->real_escape_string($catid) .
        "', '". $conn->real_escape_string($price) ."', '" . $conn->real_escape_string($description) ."', '" . $conn->real_escape_string('正常') ."')";

    $result = $conn->query($query);
    if (!$result) {
        return false;
    } else {
        return true;
    }
}


//修改状态
function change_state($title,$state) {
    $conn=db_connect();
    $query="update foods set state='".$state. "' where title='".$title."'";

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    } else {
        return true;
    }
    return db_result_to_array($result);
}


//获取状态
function get_state($title) {
    $conn=db_connect();
    $query='select state from foods where title='.$title;

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    } else {
        return true;
    }
    return db_result_to_array($result);
}


//修改菜品信息
function update_food($oldfno, $fno, $username, $title, $catid, $price, $description) {

    $conn = db_connect();
    $query = "update foods
             set fno= '".$conn->real_escape_string($fno)."',
             username = '".$conn->real_escape_string($username)."',
             title = '".$conn->real_escape_string($title)."',
             catid = '".$conn->real_escape_string($catid)."',
             price = '".$conn->real_escape_string($price)."',
             description = '".$conn->real_escape_string($description)."'
             where fno = '".$conn->real_escape_string($oldfno)."'";

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    } else {
        return true;
    }
}


function get_foods_num($username){
    $conn = db_connect();
    $query = "select count(*) c from foods where username='".$username."'";

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }
    $num_cats = @$result->num_rows;
    if ($num_cats == 0) {
        return false;
    }
    $result = db_result_to_array($result);

    return $result[0]['c'];
}

function get_orders_num($username){
    $conn = db_connect();
    $query = "select sum(s.sq) c from foods left join (select fno,sum(quantity) sq from order_items where fno in ("."select fno from foods where username = '".$conn->real_escape_string($username)."'".") group by fno) s on foods.fno=s.fno order by s.sq desc";

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }
    $num_cats = @$result->num_rows;
    if ($num_cats == 0) {
        return false;
    }
    $result = db_result_to_array($result);

    return $result[0]['c']==''? 0:$result[0]['c'];

}


//获取菜品详细信息
function get_food_details($fno) {
    // query database for all details for a particular book
    if ((!$fno) || ($fno=='')) {
        return false;
    }
    $conn = db_connect();
    $query = "select * from foods where fno='".$conn->real_escape_string($fno)."'";
    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }
    $result = @$result->fetch_assoc();
    return $result;
}



function get_search($key) {

    $conn = db_connect();
    if ($key=='') {
        $query = "select * from foods ";
    }else $query="select * from foods where title like '%".$key."%'";

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }
    $num_books = @$result->num_rows;
    if ($num_books == 0) {
        return false;
    }
    $result = db_result_to_array($result);

    return $result;
}

function get_recommends() {

    $conn=db_connect();
    $query = "select * from foods where state = '推荐'";

    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }
    $num_books = @$result->num_rows;
    if ($num_books == 0) {
        return false;
    }
    $result = db_result_to_array($result);

    return $result;
}

function get_foods($catid,$username='') {

    if ($catid < 0) {
        return false;
    }

    $conn = db_connect();
    if($catid!=0)
    $query = "select * from foods where catid = '".$conn->real_escape_string($catid)."'";
    else {
        if($username!=''){
            $query = "select * from foods where username = '".$username."'";
        }else if(isset($_SESSION['valid_shop']))
        $query = "select * from foods where username = '".$_SESSION['valid_shop']."'";
        else $query = "select * from foods ";

    }
    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }
    $num_books = @$result->num_rows;
    if ($num_books == 0) {
        return false;
    }
    $result = db_result_to_array($result);

    return $result;
}

function get_shops($username = '') {
    $conn = db_connect();
    if($username=='')
        $query = "select * from user where type=2";
    else $query = "select * from user where type=2 and username=".$username;
    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }
    $num_cats = @$result->num_rows;
    if ($num_cats == 0) {
        return false;
    }
    $result = db_result_to_array($result);
    return $result;
}

function get_categories($catid = '') {
    // query database for a list of categories
    $conn = db_connect();
    if($catid=='')
    $query = "select catid, catname from categories";
    else $query = "select catid, catname from categories where catid=".$catid;
    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }
    $num_cats = @$result->num_rows;
    if ($num_cats == 0) {
        return false;
    }
    $result = db_result_to_array($result);
    return $result;
}

//获取类别名字
function get_category_name($catid) {
    // query database for the name for a category id
    $conn = db_connect();
    $query = "select catname from categories
             where catid = '".$conn->real_escape_string($catid)."'";
    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }
    $num_cats = @$result->num_rows;
    if ($num_cats == 0) {
        return false;
    }
    $row = $result->fetch_object();
    return $row->catname;
}

?>