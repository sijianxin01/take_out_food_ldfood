<!-- // 用户登出脚本 -->
<?php

// 该应用中包含的函数文件
require_once('ldfood_fns.php');
session_start();
if(isset($_SESSION['valid_user']))
$old_user=$_SESSION['valid_user'];
else $old_user='';
if(isset($_SESSION['valid_shop']))
$old_shop=$_SESSION['valid_shop'];
else $old_shop='';
if(isset($_SESSION['valid_admin']))
    $old_shop=$_SESSION['valid_admin'];
else $old_admin='';

// 存储以测试他们是否已经登录
unset($_SESSION['valid_user']);
unset($_SESSION['valid_shop']);
unset($_SESSION['valid_admin']);
$result_dest=session_destroy();

// 开始输出网页
do_html_header('退出');

if (!empty($old_user) or !empty($old_shop) or !empty($old_admin)) {
    if ($result_dest) {
        // 如果用户已经登录现在退出
        echo '退出<br>';
        do_html_url('login.php','login');
    }else{
        // 用户已经登录无法退出
        echo '无法退出<br>';
    }
}else{
    // 如果用户没有登录却以某种方式来到该页
    echo '您未登录，因此无法退出<br>';
    do_html_URL('login.php','login');
}
do_html_footer();
?>