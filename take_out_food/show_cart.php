<!--购物车展示页面-->
<?php
  include('ldfood_fns.php');

  session_start();//启动会话

  @$new = $_GET['new'];

  //设置变量
  if($new) {
    //new item selected
    if(!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = array();
      $_SESSION['items'] = 0;
      $_SESSION['total_price'] ='0.00';
    }

    if(isset($_SESSION['cart'][$new])) {
      $_SESSION['cart'][$new]++;
    } else {
      $_SESSION['cart'][$new] = 1;
    }

    $_SESSION['total_price'] = calculate_price($_SESSION['cart']);
    $_SESSION['items'] = calculate_items($_SESSION['cart']);
  }

  if(isset($_POST['save'])) {
    foreach ($_SESSION['cart'] as $isbn => $qty) {
      if($_POST[$isbn] == '0') {
        unset($_SESSION['cart'][$isbn]);
      } else {
        $_SESSION['cart'][$isbn] = $_POST[$isbn];
      }
    }

    $_SESSION['total_price'] = calculate_price($_SESSION['cart']);
    $_SESSION['items'] = calculate_items($_SESSION['cart']);
  }

  do_html_header("你的购物车");//输出头部html代码

  if(isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) {
    display_cart($_SESSION['cart']);//输出购物车html代码
  } else {
    echo "<p>当前购物车为空</p><hr/>";
  }

  $target = "user_main.php";

  if($new)   {
    $details =  get_food_details($new);
    if($details['catid']) {
      $target = "show_cat.php?catid=".urlencode($details['catid']);
    }
  }
  display_button($target, "cart", "继续购物");//展示按钮

  display_button("checkout.php", "checkout", "付款");//展示按钮

display_button_menu();

  do_html_footer();
?>
