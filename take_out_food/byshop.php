<!-- // 用户主页面，包含该用户所有当前书签 -->
<?php

// 在这个应用中包含函数文件
require_once('ldfood_fns.php');
session_start();


do_html_header('选择店铺');


if(check_access()){
    display_search();


    if(isset($_SESSION['valid_admin'])){
        if(isset($_GET['delete_username'])){
            delete_shop($_GET['delete_username']);
        }
    }

    echo '<br><h2>请选择店铺：</h2><br>';
    $shop_array = get_shops('');//从数据库获取类别
    display_shops($shop_array);//输出菜品列表html代码


    display_button_menu();
}
else{
    echo "<p>你无权访问该页面。</p> <a href='login.php'>前往登录</a>";
}




do_html_footer();
?>