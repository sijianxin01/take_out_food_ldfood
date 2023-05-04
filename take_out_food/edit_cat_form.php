<?php

// include function files for this application
require_once('ldfood_fns.php');
session_start();//会话启动

if(check_valid_admin()){
  if(isset($_GET['catid'])){
    $catid=$_GET['catid'];
    do_html_header("更新类别");
  }
  else{
    $catid='';
    do_html_header("创建类别");
  }

  display_cat_form($catid);

  display_button_menu();
}
 else {
  echo "<p>您未以商家身份登录</p>";
}
do_html_footer();



?>
