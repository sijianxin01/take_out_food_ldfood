<?php

// include function files for this application
require_once('ldfood_fns.php');
session_start();//会话启动

// 创建变量
if(isset($_POST['username']))$username=$_POST['username'];
else $username='';
if(isset($_POST['email']))$email=$_POST['email'];
else $email='';
if(isset($_POST['type']))$type=$_POST['type'];
else $type='';
if(isset($_POST['name']))$name=$_POST['name'];
else $name='';
if(isset($_POST['sex']))$sex=$_POST['sex'];
else $sex='';
if(isset($_POST['age']))$age=$_POST['age'];
else $age='';
if(isset($_POST['phone']))$phone=$_POST['phone'];
else $phone='';
if(isset($_POST['qq']))$qq=$_POST['qq'];
else $qq='';
if(isset($_POST['default_pos']))$default_pos=$_POST['default_pos'];
else $default_pos='';
if(isset($_POST['description']))$description=$_POST['description'];
else $description='';
if(isset($_POST['oldusername']))$oldusername=$_POST['oldusername'];
else $oldusername='';


do_html_header("更新店铺信息");
if (check_access()) {//检查登录状态
  display_search();
  if (filled_out($_POST)) {//检查空值
    if(update_shop($oldusername,$username,$email,$type,$name,$sex,$age,$phone,$qq,$default_pos,$description)) {//更新菜品信息
      if($oldusername!=$username)$_SESSION['valid_shop']=$username;
      echo "<p>店铺信息更新成功。</p>";
    } else {
      echo "<p>店铺信息更新失败。</p>";
    }
  } else {
    echo "<p>您未按要求填写表单，请重新填写。请<a href='edit_shop_form.php'> 返回 </a>重新填写</p>";
  }
  if(isset($_SESSION['valid_admin']))
  $url = 'admin_main.php';
  else if(isset($_SESSION['valid_shop']))
    $url = 'shop_main.php';
  do_html_url($url, "主页");//跳转链接
} else {
  echo "<p>你无权访问该页面。</p>";
}

do_html_footer();

?>
