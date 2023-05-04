<?php

// include function files for this application
require_once('ldfood_fns.php');
session_start();//会话启动

do_html_header("修改菜品状态");

if (check_valid_admin() or check_valid_shop()) {//检查登录状态

  if(isset($_POST['state'])){
    if($_POST['state']=='normal')$state='正常';
    else if($_POST['state']=='sells_out')$state='售罄';
    else if($_POST['state']=='recommend')$state='推荐';
    $_GET['title']=$_POST['title'];
    if(change_state($_POST['title'],$state)){
      echo '<br><h2>状态修改成功</h2><br>';
    }
  }


  if(isset($_GET['title'])){
    $title=$_GET['title'];
  }
  else{
    $title='';
  }

  $state=get_state($title);
  echo '<br><h2>'.$title.'</h2><br>';
display_state_form($title,$state);



  if(isset($_SESSION['valid_admin']))
  do_html_url('admin_main.php', "返回管理员主页");//跳转链接
  else if(isset($_SESSION['valid_admin']))
    do_html_url('shop_main.php', "返回管理员主页");//跳转链接

  display_button_menu();

} else {
  echo "<p>你无权访问该页面。</p>";
}

do_html_footer();

?>
