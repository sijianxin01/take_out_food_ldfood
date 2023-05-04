<!-- // 密码重置脚本 -->
<?php
require_once("ldfood_fns.php");
do_html_header("重置密码");

// 创建变量
$username=$_POST['username'];

try{
    $password=reset_password($username);
    notify_password($username,$password);
    echo '新密码将通过邮件发送给你';
}

catch(Exception $e){
    echo '无法重置密码，请返回重试';
}
do_html_url('login.php','Login');
do_html_footer();
?>