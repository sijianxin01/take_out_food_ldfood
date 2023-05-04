<?php

// include function files for this application
require_once('ldfood_fns.php');
session_start();//会话启动



do_html_header("添加菜品");//输出头部html代码
if ($_SESSION['valid_shop']) {//检查登录状态
  if (filled_out($_POST)) {//检查空值
    $fno = $_POST['fno'];
    $title = $_POST['title'];
    $username = $_POST['username'];
    $catid = $_POST['catid'];
    $price = $_POST['price'];
    $description = $_POST['description'];


    if(insert_food($fno, $username, $title, $catid, $price, $description)) {//插入菜品
      echo "<p>菜品 <em>".htmlspecialchars($title)."</em> 成功加入数据库。</p>";

      if(isset($_FILES['cover'])){
        $allow=array('image/jpeg','image/png','image/gif');
        if(!in_array($_FILES['cover']['type'],$allow)){
          echo "上传文件不是图片";
          exit();
        }

        //创建存图片文件夹
        $dir = iconv("UTF-8", "GBK", "images/foods/".$fno."/");
        if (!file_exists($dir)){
          mkdir ($dir,0777,true);
          //echo '创建文件夹成功';
        } else {
          //echo '需创建的文件夹已经存在';
        }

        if(is_uploaded_file($_FILES['cover']['tmp_name'])){
          $filename=$_FILES['cover']['tmp_name'];
//          $des=$_FILES['logo']['name'];
          $des='cover.png';
          move_uploaded_file($filename,$dir.$des);
        }

        if(isset($_FILES['pic']) and !empty($_FILES['pic'])){

          foreach($_FILES['pic']['type'] as $t){
            if(!in_array($t,$allow)){
              //echo "上传文件不是图片";
              exit();
            }
          }

          for($i=0;$i<count($_FILES['pic']['name']);$i++){
            if(is_uploaded_file($_FILES['pic']['tmp_name'][$i])){
              $filename=$_FILES['pic']['tmp_name'][$i];
              $des=$_FILES['pic']['name'][$i];
//              $des='cover.png';
              move_uploaded_file($filename,$dir.$des);
            }
          }
        }


      }

    } else {
      echo "<p>菜品 <em>".htmlspecialchars($title)."</em> 无法加入数据库。</p>";
    }
  } else {
    echo "<p>您未按规范填写表单，请重试。</p>";
  }

  do_html_url("shop_main.php", "返回商家管理页面");//跳转链接
} else {
  echo "<p>你无权访问本页面。</p>";
}

do_html_footer();

?>
