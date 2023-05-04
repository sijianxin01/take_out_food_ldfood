<?php

// include function files for this application
require_once('ldfood_fns.php');
session_start();//会话启动


do_html_header("更新菜品");
if (isset($_SESSION['valid_shop']) or isset($_SESSION['valid_admin'])) {//检查登录状态
  if (filled_out($_POST)) {//检查空值
    $oldfno = $_POST['oldfno'];
    $fno = $_POST['fno'];
    $title = $_POST['title'];
    $username = $_POST['username'];
    $catid = $_POST['catid'];
    $price = $_POST['price'];
    $description = $_POST['description'];
//    $oldfno, $fno, $username, $title, $catid, $price, $description
    if(update_food($oldfno, $fno, $username, $title, $catid, $price, $description)) {//更新菜品信息
      echo "<p>菜品信息更新成功。</p>";
    } else {
      echo "<p>菜品信息更新失败。</p>";
    }
  } else {
    echo "<p>您未按要求填写表单，请重新填写。</p>";
  }
  $url = "show_food.php?fno=" . urlencode($fno);
  do_html_url($url, "返回菜品详情页");//跳转链接
} else {
  echo "<p>你无权访问该页面。</p>";
}

do_html_footer();

?>
