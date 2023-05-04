<!-- // 用户修改密码时候要填的表单 -->
<?php
require_once('ldfood_fns.php');
session_start();
do_html_header('修改密码');

// 创建变量
$old_passwd=$_POST['old_passwd'];
$new_passwd=$_POST['new_passwd'];
$new_passwd2=$_POST['new_passwd2'];



try{
    if(!isset($_SESSION['valid_user']) and !isset($_SESSION['valid_shop'])){
        throw new Exception('您无法访问该页面。');
    }
    if (!filled_out($_POST)) {
        throw new Exception('你还没有完整的填写表格，请再试一次');
    }
    if ($old_passwd==$new_passwd) {
        throw new Exception('新旧密码不能相同，请修改');
    }
    if ($new_passwd!=$new_passwd2) {
        throw new Exception('两次输入密码不相同，请修改');
    }
    if ((strlen($new_passwd)>16)||(strlen($new_passwd)<6)){
        throw new Exception('新密码必须在6到16个字符之间，请重试');

    }

    // 更新密码
    if(isset($_SESSION['valid_user']))
    change_password($_SESSION['valid_user'],$old_passwd,$new_passwd,1);
    else if(isset($_SESSION['valid_shop']))
    change_password($_SESSION['valid_shop'],$old_passwd,$new_passwd,2);
    echo '密码已修改';
}
catch(Exception $e){
    echo $e->getMessage();
}
display_button_menu();
do_html_footer();
?>