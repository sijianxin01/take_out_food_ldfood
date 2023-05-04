<!--所有菜品展示页面-->
<?php
require_once('ldfood_fns.php');
session_start();

do_html_header("所有菜品");

if (check_access()) {//检查登录状态
    display_search();
    echo '<br><h2>请选择以下菜品：</h2><br>';
    if(isset($_GET['search'])){
        $food_array = get_search($_GET['search']);
    }else
        if(!isset($_GET['recommend']))
    $food_array = get_foods(0);//获取所有本店菜品信息
    else $food_array = get_recommends();
    display_foods($food_array);//输出菜品列表html代码
    display_button_menu();
} else {
    echo "<p>你无权访问该页面。</p>";
}

do_html_footer();
?>
