<?php

// include function files for this application
require_once('ldfood_fns.php');
session_start();//会话启动

do_html_header("编辑菜品信息");

if (check_access()) {//检查登录状态
  display_search();
if(isset($_SESSION['valid_admin']) and isset($_GET['username'])) {
  if ($shop = get_shop_details($_GET['username'])) {
    display_shop_form($shop);//展示店铺表格
  } else {
    echo "<p>无法获取店铺信息.</p>";
  }
  do_html_url("byshop.php", "返回商家列表");//跳转链接
}else if(isset($_SESSION['valid_shop'])){
    if ($shop = get_shop_details($_SESSION['valid_shop'])) {
      display_shop_form($shop);//展示店铺表格
    } else {
      echo "<p>无法获取店铺信息.</p>";
    }

    do_html_url("shop_main.php", "返回商家主页");//跳转链接

  }else if(isset($_SESSION['valid_user'])){

    if ($shop = get_shop_details($_SESSION['valid_user'])) {
      display_shop_form($shop);//展示店铺表格
    } else {
      echo "<p>无法获取店铺信息.</p>";
    }
    if(isset($_SESSION['valid_shop']))
      do_html_url("shop_main.php", "返回商家主页");//跳转链接
    else if(isset($_SESSION['valid_admin']))
      do_html_url("admin_main.php", "返回管理员主页");//跳转链接


  }


  display_button_menu();

} else {
  echo "<p>您未以商家身份登录</p>";
}
do_html_footer();

?>
