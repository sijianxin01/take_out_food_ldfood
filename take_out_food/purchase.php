<?php

  include('ldfood_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();//启动会话

  do_html_header("收款处");//输出头部html代码

  // create short variable names
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $pos = $_POST['pos'];

  // if filled out
  if (($_SESSION['cart']) && ($name) && ($phone) && ($pos)) {
    // able to insert into database
    if(insert_order($_POST) != false ) {
      //display cart, not allowing changes and without pictures
      display_cart($_SESSION['cart'], false, 0);//输出购物车html代码

      display_shipping(calculate_shipping_cost());//输出支付价格信息

      //get credit card details
      display_card_form($name);//输出填写支付账号信息表单html代码

      display_button("show_cart.php", "cart", "Continue Shopping");
    } else {
      echo "<p>Could not store data, please try again.</p>";
      display_button('checkout.php', 'checkout', 'Back');//输出按钮
    }
  } else {
    echo "<p>You did not fill in all the fields, please try again.</p><hr />";
    display_button('checkout.php', 'last', 'Back');//输出按钮
  }

  do_html_footer();
?>
