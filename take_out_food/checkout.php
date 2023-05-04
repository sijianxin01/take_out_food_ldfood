<?php
  //include our function set
  include('ldfood_fns.php');

  // The shopping cart needs sessions, so start one
  session_start();//会话启动

  do_html_header("付款");//输出页面头部html代码

  if(($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) {//输出购物车html代码
    display_cart($_SESSION['cart'], false, 0);
    display_checkout_form();
  } else {
    echo "<p>当前购物车为空</p>";
  }

  display_button("show_cart.php", "cart", "继续购物");//展示继续购物按钮

  do_html_footer();
?>
