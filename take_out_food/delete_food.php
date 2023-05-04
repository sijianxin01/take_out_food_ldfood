<?php

require_once('ldfood_fns.php');
session_start();//启动会话

do_html_header("删除菜品");//输出头部html代码
if (isset($_SESSION['valid_shop']) or isset($_SESSION['valid_admin'])) {//检查管理员用户是否登录
  if (isset($_POST['fno'])) {
    $fno = $_POST['fno'];
    if(delete_food($fno)) {//删除
      echo "<p>菜品成功删除。</p>";
    } else {
      echo "<p>该菜品无法删除。</p>";
    }
  } else {
    echo "<p>请指定特定菜品进行删除。</p>";
  }
  if(isset($_SESSION['valid_shop']))
  do_html_url("shop_main.php", "返回商家管理页面");
  else if(isset($_SESSION['valid_admin']))
    do_html_url("admin_main.php", "返回商家管理页面");
} else {
  echo "<p>无法访问该页面。</p>";
}

do_html_footer();

?>
