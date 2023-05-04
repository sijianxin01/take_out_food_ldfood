<!-- // 用户主页面，包含该用户所有当前书签 -->
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



if (!isset($_SESSION['valid_shop']))
    if ($username && $passwd) {
        //尝试登陆
        try{
            // 在user_auth_fns.php库中定义了这个函数login
            if(login($username,$passwd,2))
            //如果在数据库包含注册用户ID
            // 用户名保存到会话变量中
            $_SESSION['valid_shop']=$username;
        }
        catch(Exception $e){
            // 未成功登陆
            do_html_header("遇到一些问题：");
            echo '您未能成功登录，<br> 您应该点击以下网址登录';
            do_html_url('login.php','Login');
            do_html_footer();
            exit;
        }
    }

do_html_header('主页');


// 检查用户是否拥有一个注册的对话 针对没有登录却处于会话中的用户
if(check_access()){
    display_search();
    echo '<br><h2>请选择功能：</h2><br>';

    display_shop_menu();
    $conn = db_connect();

// 显示菜单设置
    display_button_menu();
}
else{
    echo "<p>你无权访问该页面。</p>";
}


do_html_footer();
?>