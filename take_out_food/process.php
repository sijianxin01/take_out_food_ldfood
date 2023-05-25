<?php
  include('ldfood_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();//会话启动

  do_html_header('Checkout');//输出头部html代码

  $card_type = $_POST['card_type'];
  $card_number = $_POST['card_number'];
  $card_name = $_POST['card_name'];

  if(($_SESSION['cart']) && ($card_type) && ($card_number) && ($card_name)) {
    //display cart, not allowing changes and without pictures
    display_cart($_SESSION['cart'], false, 0);//输出购物车html代码

    display_shipping(calculate_shipping_cost());//输出支付价格信息

    if(process_card($_POST)) {//支付
      //empty shopping cart
	  unset($_SESSION['items']);
	  unset($_SESSION['total_price']);
	  unset($_SESSION['cart']);
      echo "<p>你的订单已经完成，谢谢惠顾，欢迎再次下单。</p>";
      display_button("user_main.php", "cart", "Continue Shopping");//跳转按钮
    } else {
      echo "<p>无法完成支付，请重试。</p>";
      display_button("purchase.php", "last", "Back");//跳转按钮
    }
  } else {
    echo "<p>你未按要求填写表单，请重试。</p><hr />";
    display_button("purchase.php", "last", "Back");//跳转按钮
  }

  do_html_footer();
?>
