<!--菜品详情页面-->
<?php
  include('ldfood_fns.php');

  session_start();//会话启动

  $fno = $_GET['fno'];

  // get this book out of database
  $food = get_food_details($fno);

  do_html_header('菜品详情');//输出头部html代码

if(!check_access()){
  echo '未登录<br>';
  do_html_url('login.php','Login');
  do_html_footer();
  exit;
}

display_search();
echo '<br><h2>'.$food['title'].'</h2><br>';

  display_food_details($food);

if(isset($_SESSION['valid_admin']))
  {
    $target = "admin_main.php";
    display_button("edit_food_form.php?fno=". urlencode($fno), "edit", "编辑菜品");//设置按钮
    display_button("shop_disp_all.php", "last", "返回上一页");
    display_button($target, "main", "返回主页面");
  }
else if(isset($_SESSION['valid_shop']))
{
  $target = "shop_main.php";
  display_button("edit_food_form.php?fno=". urlencode($fno), "edit", "编辑菜品");//设置按钮
  display_button("shop_disp_all.php", "last", "返回上一页");
  display_button($target, "main", "返回主页面");
}
else if(isset($_SESSION['valid_user'])){
  $target = "user_main.php";
  display_button("show_cart.php?new=". urlencode($fno), "cart", "加入到购物车 ");
  display_button("show_cat.php?catid=".$food['catid'], "last", "返回上一页");
  display_button($target, "main", "返回主页面");
}

display_button_menu();
  do_html_footer();
?>
