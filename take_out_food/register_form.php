<!-- // 用户注册表单 -->
<?php
require_once('ldfood_fns.php');

$reg_type="用户注册";
if (!isset($_GET['usertype'])) {
    //如果不存在->设置为虚拟值
    $_GET['usertype']='1';
    $reg_type="用户注册";
}
if($_GET['usertype']=='2')  {
    $reg_type="商家注册";
}else if($_GET['usertype']=='3')  {
    $reg_type="管理员注册";
}

do_html_header($reg_type);

display_registration_form();

do_html_url('login.php?usertype='.$_GET['usertype'],'返回登录页面');

do_html_footer();
?>