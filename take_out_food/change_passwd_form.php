<!-- // 用户修改密码时候要填的表单 -->
<?php
require_once('ldfood_fns.php');
session_start();
do_html_header('修改密码');

display_password_form();

display_button_menu();
    do_html_footer();
    ?>