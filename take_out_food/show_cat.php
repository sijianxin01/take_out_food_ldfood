<!--商品类别展示页面-->
<?php
  include('ldfood_fns.php');
  session_start();//启动会话
  $catid = $_GET['catid'];
  $name = get_category_name($catid);

  do_html_header($name);//输出头部html代码
  check_access();
  display_search();

  $food_array = get_foods($catid);//获取图书信息

  display_foods($food_array);//输出餐品列表html代码


  if(isset($_SESSION['valid_user'])) {//检验有效用户
    display_button("index.php", "cart", "继续购物");
    display_button("user_main.php", "main", "主页");
  } else if(isset($_SESSION['valid_shop'])){
    display_button("shop_main.php", "main", "回到首页");
  }else if(isset($_SESSION['valid_admin'])){
    display_button("admin_main.php", "main", "回到首页");
  }

display_button_menu();
  do_html_footer();
?>
