<!-- // 用户身份验证函数 -->
<?php

require_once('db_fns.php');

function register($username,$passwd,$email,$type,$name,$sex,$age,$phone,$qq,$default_pos,$description){
    // 将注册的新用户写入数据库
    // 返回true或者error信息

    // 链接数据库
    $conn=db_connect();

    // 检查用户名是否唯一
    $result=$conn->query("select * from user where username='".$username."'");

    if (!$result) {
        throw new Exception("无法执行查询");
    }

    //该用户名已被创建，查询行数大于0
    if ($result->num_rows>0) {
        throw new Exception("该用户名已被使用，请返回重新选择其他用户名");  
    }

    //如果符合要求，写入数据库
    $result=$conn->query("insert into user values('".$username."',sha1('".$passwd."'),'".$email."',".$type.",'".$name."','".$sex."','".$age."','".$phone."','".$qq."','".$default_pos."','".$description."')");

    if (!$result) {
        throw new Exception('您无法在数据库中注册，请稍后重试');
    }

    return true;
}

function login($username,$password,$type){
    // 在数据库中检查用户名和密码
    // 如果有，return true；
    // 否则抛出异常

    //连接数据库
    $conn=db_connect();

    // 检查用户名是否唯一
    $result=$conn->query("select * from user where username='".$username."' and password=sha1('".$password."') and type=".$type);
    if (!$result) {

        throw new Exception('密码错误');
    }

    if ($result->num_rows>0) {
        return true;
    }else{
//        echo "select * from user where username='".$username."' and password=sha1('".$password."') and type=".$type;

        throw new Exception('密码错误');
    }
}

function check_valid_user(){
    // 检查用户是否有有效的会话，如果没有
    if (isset($_SESSION['valid_user'])) {
        if (@file_exists("images/users/{$_SESSION['valid_user']}/photo.png"))  {
            $size = GetImageSize("images/users/{$_SESSION['valid_user']}/photo.png");
            if(($size[0] > 0) && ($size[1] > 0)) {
                echo "<td><img src=\"images/users/".htmlspecialchars($_SESSION['valid_user'])."/photo.png\" style=\"border: 1px solid black\" height=150/></td>";
            }
        }
        else{
            echo "<td><img src=\"images/users/photo.png\"  style=\"border: 1px solid black\" height=150/></td>";
        }
        echo '<br>会员 '.$_SESSION['valid_user'].' 已登录,是否 <a href="logout.php">退出</a><br>';
        return true;
    }else{
        // 未登录
        return false;
    }
}

function check_valid_shop(){
    // 检查用户是否有有效的会话，如果没有
    if (isset($_SESSION['valid_shop'])) {
        if (@file_exists("images/users/{$_SESSION['valid_shop']}/photo.png"))  {
            $size = GetImageSize("images/users/{$_SESSION['valid_shop']}/photo.png");
            if(($size[0] > 0) && ($size[1] > 0)) {
                echo "<td><img src=\"images/users/".htmlspecialchars($_SESSION['valid_shop'])."/photo.png\" style=\"border: 1px solid black\" height=150/></td>";
            }
        }
        else{
            echo "<td><img src=\"images/users/photo.png\"  style=\"border: 1px solid black\" height=150/></td>";
        }
        echo '<br>商家 '.$_SESSION['valid_shop'].' 已登录,是否 <a href="logout.php">退出</a><br>';
        return true;
    }else{
        // 未登录
        return false;
    }
}

function check_valid_admin(){
    // 检查用户是否有有效的会话，如果没有
    if (isset($_SESSION['valid_admin'])) {
        if (@file_exists("images/users/{$_SESSION['valid_admin']}/photo.png"))  {
            $size = GetImageSize("images/users/{$_SESSION['valid_admin']}/photo.png");
            if(($size[0] > 0) && ($size[1] > 0)) {
                echo "<td><img src=\"images/users/".htmlspecialchars($_SESSION['valid_admin'])."/photo.png\" style=\"border: 1px solid black\" height=150/></td>";
            }
        }
        else{
            echo "<td><img src=\"images/users/admin.png\"  style=\"border: 1px solid black\" height=150/></td>";
        }
        echo '<br>商家 '.$_SESSION['valid_admin'].' 已登录,是否 <a href="logout.php">退出</a><br>';
        return true;
    }else{
        // 未登录
        return false;
    }
}

function check_access(){
    if(isset($_SESSION['valid_admin'])){
        unset($_SESSION['valid_shop']);
        unset($_SESSION['valid_user']);
    }else if(isset($_SESSION['valid_shop'])){
        unset($_SESSION['valid_user']);
    }
    if(check_valid_admin() or check_valid_shop() or check_valid_user())
        return true;
    else
        return false;
}



function change_password($username,$old_password,$new_password,$usertype){
    // 修改密码
    // return true or flase

    // 如果旧密码正确
    // 修改为新密码并 return true
    // 否则抛出异常
    login($username,$old_password,$usertype);

    $conn=db_connect();

    $result=$conn->query("update user set password=sha1('".$new_password."') where username='".$username."'");
    if (!$result) {
        throw new Exception('密码未能成功修改');
    }else{
        // 修改成功
        return true;
    }
}

function reset_password($username){
    // 将用户的密码设置为随机值
    // 返回新密码或者失败时返回false
    // 得到一个随机字典单词在6到13个字符之间
    //$new_password=get_random_word(6,13);

    $new_password='new';
    if ($new_password==false) {
        // 给予一个不同的密码
        $new_password="changeMe!";
    }

    // 添加0到999之间一个数字
    // 设置一个稍微复杂的密码
    $rand_number=rand(0,999);
    // .=拼接字符串new_password+rand_number
    $new_password.=$rand_number;

    // 将用户的密码写入数据库否则返回false
    $conn=db_connect();
    $result=$conn->query("update user set password=sha1('".$new_password."') where username='".$username."'");

    if (!$result) {
        throw new Exception('未能修改密码');
        
    }else {
        return $new_password;
    }
}

function get_radom_word($min_lenght,$max_lenght){
    // 从两个长度之间的字典中抓取一个随机单词并将其返回

    // 生成随机单词
    $word='';
    // 记得改变path以适合您的系统
    $dictionary='/usr/dict/words';//拼写检擦字典
    $fp=@fopen($dictionary,'r');
    if (!$fp) {
        return false;
    }
    $size=filesize($dictionary);

    // 选中字典中的随机位置
    $rand_location=rand(0,$size);
    fseek($fp,$rand_location);

    // 在文件中获取正确长度的下一个单词
    while ((strlen($word)<$min_lenght)||(strlen($word)>$max_lenght)||(strstr($word,"'"))){
        if (feof($fp)) {
            fseek($fp,0); //如果结束，立即开始
        }
        $word=fgets($fp,80);    //跳过第一个单词，因为
        $word=fgets($fp,80);    //他可能是潜在密码的一部分
    }
        $word=trim($word);  
        return $word;
}

function notify_password($username,$password){
    // 通知用户密码已经更改
    $conn=db_connect();
    $result=$conn->query("select email from user where username='".$username."'");


    if (!$result) {
        throw new Exception('找不到邮箱地址');
    }else if ($result->num_rows==0) {
        throw new Exception('找不到邮箱地址');
        // 数据库中用户名不存在
    }else{

        $mesg="您的密码已经更改为".$password."<br>"."请使用新密码再次登录<br>";
        echo $mesg;
    }
}
?>