<?php

// include function files for this application
require_once('ldfood_fns.php');
session_start();//会话启动

do_html_header("添加菜品");//输出头部html代码
if (check_access()) {//检查登录状态
  display_food_form();//展示菜品表格
  do_html_url("shop_main.php", "返回商家管理页面");//跳转链接
} else {
  echo "<p>你无法访问该页面。</p>";
}
do_html_footer();

?>
