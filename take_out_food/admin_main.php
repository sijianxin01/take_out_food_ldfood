<!-- // 管理员主页 -->
<?php

// 在这个应用中包含函数文件
require_once('ldfood_fns.php');
session_start();

// 创建变量
if (!isset($_POST['username'])) {
    //如果不存在->设置为虚拟值
    $_POST['username']=" ";
}
$username=$_POST['username'];
if (!isset($_POST['passwd'])) {
    //如果不存在->设置为虚拟值
    $_POST['passwd']=" ";
}
$passwd=$_POST['passwd'];


if (!isset($_SESSION['valid_admin']))
    if ($username && $passwd) {
        //尝试登陆
        try{
            // 在user_auth_fns.php库中定义了这个函数login
            if(login($username,$passwd,3))
            //如果在数据库包含注册用户ID
            // 用户名保存到会话变量中
            $_SESSION['valid_admin']=$username;
        }
        catch(Exception $e){
            // 未成功登陆
            do_html_header("遇到一些问题：");
            echo '您未能成功登录，<br> 您应该点击以下网址重新登录管理员';
            do_html_url('admin_login.php','Login');
            do_html_footer();
            exit;
        }
    }

do_html_header('管理员主页');

if(check_access()){
    echo '<br><h2>请选择功能：</h2><br>';
    display_admin_menu();
    display_button_menu();
}else{
    echo "<p>你无权访问该页面。</p> <a href='admin_login.php'>前往登录</a>";
}


do_html_footer();
?>