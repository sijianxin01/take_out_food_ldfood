<!-- // 处理新注册信息脚本 -->
<?php
// 包含此应用程序的函数文件
require_once('ldfood_fns.php');


// 创建变量
if(isset($_POST['username']))$username=$_POST['username'];
else $username='';
if(isset($_POST['passwd']))$passwd=$_POST['passwd'];
else $passwd='';
if(isset($_POST['passwd2']))$passwd2=$_POST['passwd2'];
else $passwd2='';
if(isset($_POST['email']))$email=$_POST['email'];
else $email='';
if(isset($_POST['type']))$type=$_POST['type'];
else $type='';
if(isset($_POST['name']))$name=$_POST['name'];
else $name='';
if(isset($_POST['sex']))$sex=$_POST['sex'];
else $sex='';
if(isset($_POST['age']))$age=$_POST['age'];
else $age='';
if(isset($_POST['phone']))$phone=$_POST['phone'];
else $phone='';
if(isset($_POST['qq']))$qq=$_POST['qq'];
else $qq='';
if(isset($_POST['default_pos']))$default_pos=$_POST['default_pos'];
else $default_pos='';
if(isset($_POST['description']))$description=$_POST['description'];
else $description='';


// 启动会话
session_start();
try{
    //检查填写的表格
    if (!filled_out($_POST)) {
        throw new Exception('您未正确填写表格,请返回重试');
    }
    //检查邮箱地址是否有效
    if (!valid_email($email)) {
        throw new Exception('这不是一个有效的邮箱地址,请返回重试');
    }
    //检查两次输入密码是否相同
    if ($passwd!=$passwd2) {
        throw new Exception('两次密码输入不匹配,请返回重试');
    }
    //检查密码长度是否符合要求
    if ((strlen($passwd)<6)||(strlen($passwd)>16)) {
        throw new Exception('您的密码必须在6到16个字符之间,请返回重试');
    }

    //开始注册
    //这个函数也可以抛出异常
    register($username,$passwd,$email,$type,$name,$sex,$age,$phone,$qq,$default_pos,$description);
    //将用户名注册为会话变量
    if($type==1)
    $_SESSION['valid_user']=$username;
    else if($type==2)
        $_SESSION['valid_shop']=$username;

//保存头像
    if($type!=3 and isset($_FILES['photo'])){

        $allow=array('image/jpeg','image/png','image/gif');
        if(!in_array($_FILES['photo']['type'],$allow)){
            echo "头像格式不正确";
            exit();
        }

        //创建存图片文件夹
        $dir = iconv("UTF-8", "GBK", "images/users/".$username."/");
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
            //echo '创建文件夹成功';
        } else {
            //echo '需创建的文件夹已经存在';
        }

        if(is_uploaded_file($_FILES['photo']['tmp_name'])){
            $filename=$_FILES['photo']['tmp_name'];
//          $des=$_FILES['logo']['name'];
            $des='photo.png';
            move_uploaded_file($filename,$dir.$des);
        }
    }

    //提供会员页面的链接
    do_html_header('注册成功');

    if($type==1){
        echo '注册成功,开始跳转到会员页面';
        do_html_url('user_main.php','跳转至会员页面');
    }
    else if($type==2){
        echo '注册成功,开始跳转到店铺管理页面';
        do_html_url('shop_main.php','跳转至店铺管理页面');
    }
    else if($type==3){
        echo '注册成功,管理员重新登录';
        do_html_url('admin_login.php','跳转至管理员登录页面');
    }

    //页脚
    do_html_footer();
}
catch (Exception $e){
    do_html_header('问题');
    echo $e->getMessage();
    do_html_url('register_form.php?usertype'.$type,'返回重新注册');
    do_html_footer();
    exit;
}