<?php

// include function files for this application
require_once('ldfood_fns.php');
session_start();//会话启动


if (check_valid_admin()) {//检查登录状态
  if (filled_out($_POST)) {//检查空值
    $catid = $_POST['catid'];
    $catname = $_POST['catname'];
    if(update_cat($catid, $catname)) {//更新菜品信息
      echo "<p>类别信息更新成功。</p>";
    } else {
      echo "<p>类别信息更新失败。</p>";
    }
  } else {
    echo "<p>您未按要求填写表单，请重新填写。</p>";
  }
  $url = "admin_main.php";
  do_html_url($url, "返回管理员主页");//跳转链接
} else {
  echo "<p>你无权访问该页面。</p>";
}

do_html_footer();

?>
