<?php
//include our function set
include('ldfood_fns.php');

// The shopping cart needs sessions, so start one
session_start();//会话启动

if(isset($_SESSION['valid_shop']))
do_html_header("店铺 ".$_SESSION['valid_shop']." 销售情况：");//输出页面头部html代码
else do_html_header("平台销售情况：");//输出页面头部html代码
check_valid_shop();
check_valid_admin();

$sales_info=get_sales_info();
//print_r($sales_info);

if($sales_info) {
    display_sales_info($sales_info, false, 0);

} else {
    echo "<p>目前无菜品，请添加新的菜品。</p>";
}


if(isset($_SESSION['valid_shop']))
display_button("shop_main.php", "main", "返回首页");
else if(isset($_SESSION['valid_admin']))
    display_button("admin_main.php", "main", "返回首页");

display_button_menu();


do_html_footer();
?>