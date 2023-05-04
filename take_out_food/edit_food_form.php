<?php

require_once('ldfood_fns.php');
session_start();//会话启动

do_html_header("编辑菜品信息");
if (check_access()) {//检查登录状态
  if ($food = get_food_details($_GET['fno'])) {
    display_food_form($food);//展示菜品表格
  } else {
    echo "<p>无法获取菜品信息.</p>";
  }
  if(isset($_SESSION['valid_admin']))
    do_html_url("admin_main.php", "返回管理员主页");//跳转链接
  else if(isset($_SESSION['valid_shop']))
  do_html_url("shop_main.php", "返回商家主页");//跳转链接
  display_button_menu();
} else {
  echo "<p>您未以商家身份登录</p>";
}


do_html_footer();

?>
