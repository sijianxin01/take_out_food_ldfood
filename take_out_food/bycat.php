<!-- // 用户主页面，包含该用户所有当前书签 -->
<?php

// 在这个应用中包含函数文件
require_once('ldfood_fns.php');
session_start();


do_html_header('餐品类别');


if(check_access()){
    display_search();
    echo '<br><h2>请选择食物类别：</h2><br>';
    if(isset($_GET['deleteid'])){
        delete_cat($_GET['deleteid']);
    }

    $cat_array = get_categories('');//从数据库获取类别

    display_categories($cat_array);//输出展示类别信息的html代码

    display_button_menu();
}
else{
    echo "<p>你无权访问该页面。</p> <a href='login.php'>前往登录</a>";
}


do_html_footer();
?>