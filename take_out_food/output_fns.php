<!-- // 以HTML形式格式化输出的函数 -->
<?php


function display_food_form($food = '') {


    $edit = is_array($food);


    ?>
    <br>
    <form method="post"
          action="<?php echo $edit ? 'edit_food.php' : 'insert_food.php';?> " enctype="multipart/form-data">
        <table border="0">
            <tr>
                <input type="hidden" name="oldfno"
                       value="<?php echo htmlspecialchars($edit ? $food['fno'] : '000'); ?>" />
                <td>菜品编号:</td>
                <td><input type="text" name="fno"
                           value="<?php echo htmlspecialchars($edit ? $food['fno'] : ''); ?>" /></td>
            </tr>
            <tr>
                <td>商铺名称:</td>
                <td><input type="text" name="username"
                           value="<?php echo htmlspecialchars($edit ? $food['username'] : ''); ?>" /></td>
            </tr>
            <tr>
                <td>菜品标题:</td>
                <td><input type="text" name="title"
                           value="<?php echo htmlspecialchars($edit ? $food['title'] : ''); ?>" /></td>
            </tr>
            <tr>
                <td>菜品类别:</td>
                <td><select name="catid">
                        <?php
                        $cat_array=get_categories();
                        foreach ($cat_array as $thiscat) {
                            echo "<option value=\"".htmlspecialchars($thiscat['catid'])."\"";
                            // if existing book, put in current catgory
                            if (($edit) && ($thiscat['catid'] == $food['catid'])) {
                                echo " selected";
                            }
                            echo ">".htmlspecialchars($thiscat['catname'])."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>菜品价格:</td>
                <td><input type="text" name="price"
                           value="<?php echo htmlspecialchars($edit ? $food['price'] : ''); ?>" /></td>
            </tr>
            <tr>
                <td>菜品描述:</td>
                <td><textarea rows="3" cols="50"
                              name="description"><?php echo htmlspecialchars($edit ? $food['description'] : ''); ?></textarea></td>
            </tr>

            <tr>
                <td>封面图片：</td>
                <td><input type="file" name="cover"></td>
            </tr>

            <tr>
                <td>其他图片：</td>
                <td><input type="file" name="pic[]" multiple="multiple" /></td>

            </tr>




            <tr>
                <td <?php if (!$edit) { echo "colspan=2"; }?> align="center">
                    <?php
                    if ($edit)
                        // we need the old isbn to find book in database
                        // if the isbn is being updated
                        echo "<input type=\"hidden\" name=\"oldisbn\"
                    value=\"".htmlspecialchars($food['fno'])."\" />";
                    ?>
                    <input type="submit"
                           value="<?php echo $edit ? '更新' : '添加'; ?>菜品" />
    </form></td>
    <?php
    if ($edit) {
        echo "<td>
                   <form method=\"post\" action=\"delete_food.php\">
                   <input type=\"hidden\" name=\"fno\"
                    value=\"".htmlspecialchars($food['fno'])."\" />
                   <input type=\"submit\" value=\"删除菜品\"/>
                   </form></td>";
    }
    ?>
    </td>
    </tr>
    </table>
    </form>
    <?php
}


function display_cat_form($catid = '') {
    if($catid!=''){
        ?>

        <br>
        <form method="post"
              action="edit_cat.php">

            <input type="hidden" name="catid"
                   value="<?php echo $catid; ?>" />
            类别名称:
            <input type="text" name="catname"
                   value="<?php echo get_category_name($catid); ?>" />

            <input type="submit" name="submit"
                   value="更新类别" />
        </form>
        <?php
    }else{
        ?>
        <br>
        <form method="post"
              action="edit_cat.php">

            <input type="hidden" name="catid"
                   value="0" />
            类别名称:
            <input type="text" name="catname"
                   value="<?php echo get_category_name($catid); ?>" />

            <input type="submit" name="submit"
                   value="更新类别" />
        </form>
        <?php
    }
}


function display_shop_form($shop = '') {

    $edit = is_array($shop);

    ?>

    <form action="<?php echo $edit ? 'edit_shop.php' : 'register_new.php';?>" method="post" enctype="multipart/form-data">
        <div class="formblock">
            <h2>店铺信息</h2>

            <input type="hidden" id="type" name="type" value="<?php echo htmlspecialchars($edit ? $shop['type'] : '2'); ?>">

            <p><label for="photo">头像：</label>
                <br/>
                <input type="file" name="photo" id="photo" />
            </p>

            <p><label for="email">邮箱：</label>
                <br/>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($edit ? $shop['email'] : ''); ?>" size+"30" maxlength="100" required />
            </p>

            <p><label for="username"><?php if($shop['type']==1)echo '校园卡号：'; else echo '商铺名：';  ?></label>
                <br/>
                <input type="hidden" name="oldusername" id="oldusername" value="<?php echo htmlspecialchars($edit ? $shop['username'] : ''); ?>" size+"16" maxlength="16" required />

                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($edit ? $shop['username'] : ''); ?>" size+"16" maxlength="16" required />
            </p>


            <?php
            if(!$edit){

                ?>

                <p><label for="passwd">密码：</label>
                    <br/>
                    <input type="password" name="passwd" id="passwd" value="<?php echo htmlspecialchars($edit ? '' : ''); ?>" size+"16" maxlength="16" required />
                </p>

                <p><label for="passwd2">确认密码：</label>
                    <br/>
                    <input type="password" name="passwd2" id="passwd2" size+"16" maxlength="16" required />
                </p>
                <?php
            }

            ?>
            <p>
            <hr>
            </p>

            <p><label for="passwd2">姓名：</label>
                <br/>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($edit ? $shop['name'] : ''); ?>" size+"30" maxlength="30" required />
            </p>
            <p><label for="性别">性别：</label>
                <br/>
                <select name="sex">
                    <option value=0 <?php  echo ($edit and $shop['sex']=='0') ? 'selected':''; ?>>男</option>
                    <option value=1 <?php  echo ($edit and $shop['sex']=='1') ? 'selected':''; ?>>女</option>
                </select>
            </p>

            <p><label for="age">年龄：</label>
                <br/>
                <input type="text" name="age" id="age" value="<?php echo htmlspecialchars($edit ? $shop['age'] : ''); ?>" size+"30" maxlength="30" required />
            </p>
            <p><label for="passwd2">联系电话：</label>
                <br/>
                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($edit ? $shop['phone'] : ''); ?>" size+"20" maxlength="20" required />
            </p>
            <p><label for="qq">QQ：</label>
                <br/>
                <input type="text" name="qq" id="qq" value="<?php echo htmlspecialchars($edit ? $shop['qq'] : ''); ?>" size+"20" maxlength="20" required />
            </p>
            <p><label for="default_pos">默认地址：</label>
                <br/>
                <input type="default_pos" name="default_pos" id="default_pos" value="<?php echo htmlspecialchars($edit ? $shop['default_pos'] : ''); ?>" size+"100" maxlength="100" required />
            </p>

            <?php

            if($shop['type']==2){
                ?>
                <p><label for="description">店铺描述:</label>
                    <br/>
                    <textarea rows="3" cols="25" name="description" ><?php echo htmlspecialchars($edit ? $shop['description'] : ''); ?></textarea>
                </p>
                <?php
            }
            ?>


            <input type="submit"
                   value="<?php echo $edit ? '更新' : '添加'; ?><?php echo isset($_SESSION['valid_user']) ? '用户' : '商家'; ?>" />
        </div>
    </form>


    <?php

}



function display_admin_menu() {

    echo "<ul>";
    //查看本店所有菜品
    $url = "shop_disp_all.php";
    $title = '所有菜品';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //类别
    $url = "bycat.php";
    $title = '查看菜品类别';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //查看店铺
    $url = "byshop.php";
    $title = '查看店铺';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //查看推荐
    $url = "shop_disp_all.php?recommend=1";
    $title = '查看推荐';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //查看销售情况
    $url = "sales_info.php";
    $title = '查看销售情况';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //修改商家信息
    $url = "register_form.php?usertype=3";
    $title = '创建管理员';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //修改密码
    $url = "change_passwd_form.php";
    $title = '修改密码';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";


    echo '<br>';

    echo "</ul>";
    echo "<hr />";


}

function display_user_menu() {

    echo "<ul>";
    //查看所有菜品
    $url = "shop_disp_all.php";
    $title = '所有菜品';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //按分类查找菜品
    $url = "bycat.php";
    $title = '查看分类';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //查看店铺、、、
    $url = "byshop.php";
    $title = '查看店铺';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //查看推荐
    $url = "shop_disp_all.php?recommend=1";
    $title = '查看推荐';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //查看购物车
    $url = "show_cart.php";
    $title = '查看购物车';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //修改个人信息
    $url = "edit_shop_form.php";
    $title = '编辑个人信息';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";









    //修改密码
    $url = "change_passwd_form.php";
    $title = '修改密码';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";


    echo '<br>';

    echo "</ul>";
    echo "<hr />";




}

function display_shop_menu() {

    echo "<ul>";
    //查看本店所有菜品
    $url = "shop_disp_all.php";
    $title = '本店菜品';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //添加菜品
    $url = "insert_food_form.php";
    $title = '添加菜品';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //查看销售情况
    $url = "sales_info.php";
    $title = '查看销售情况';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //查看订单信息
    $url = "order_info.php";
    $title = '查看订单';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //修改商家信息
    $url = "edit_shop_form.php";
    $title = '编辑商家信息';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";

    //修改密码
    $url = "change_passwd_form.php";
    $title = '修改密码';
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";


    echo '<br>';

    echo "</ul>";
    echo "<hr />";


}


//输出购物车html代码
function display_orders_info($cart, $change = true, $images = 1) {
    // display items in shopping cart
    // optionally allow changes (true or false)
    // optionally include images (1 - yes, 0 - no)

    echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
         <form action=\"show_cart.php\" method=\"post\">
         <tr><th colspan=\"".(1 + $images)."\" bgcolor=\"#cccccc\">订单编号</th>
         <th bgcolor=\"#cccccc\">编号</th>
         <th bgcolor=\"#cccccc\">菜品编号</th>
         <th bgcolor=\"#cccccc\">单价</th>
         <th bgcolor=\"#cccccc\">数量</th>
         <th bgcolor=\"#cccccc\">用户</th>
         <th bgcolor=\"#cccccc\">时间</th>
         <th bgcolor=\"#cccccc\">订单状态</th>
         <th bgcolor=\"#cccccc\">姓名</th>
         <th bgcolor=\"#cccccc\">电话</th>
         <th bgcolor=\"#cccccc\">地址</th>
         </tr>";

    $i=1;
    //display each item as a table row
    foreach ($cart as $food)  {
        echo "<tr>";
        echo "<td align=\"center\">".$i."</td>";
        echo "<td align=\"center\">".$food['orderid']."</td>";
        echo "<td align=\"center\">".$food['fno']."</td>";
//        echo "<td align=\"center\">".$food['username']."</td>";
        echo "<td align=\"center\">".$food['item_price']."</td>";
        echo "<td align=\"center\">".$food['quantity']."</td>";
        echo "<td align=\"center\">".$food['username']."</td>";
        echo "<td align=\"center\">".$food['date']."</td>";
        echo "<td align=\"center\">".$food['order_status'].' <select name="state">
                <option value="PARTIAL">PARTIAL</option>
                <option value="FINISHED">FINISHED</option>
                <option value="SENDING">SENDING</option>
            </select>'."</td>";
        echo "<td align=\"center\">".$food['name']."</td>";
        echo "<td align=\"center\">".$food['phone']."</td>";
        echo "<td align=\"center\">".$food['position']."</td>";
        $i=$i+1;
    }


    // display save change button
    if($change == true) {
        echo "<tr>
          <td colspan=\"".(2+$images)."\">&nbsp;</td>
          <td align=\"center\">
             <input type=\"hidden\" name=\"save\" value=\"true\"/>
             <input type=\"image\" src=\"images/save-changes.gif\"
                    border=\"0\" alt=\"Save Changes\"/>
          </td>
          <td>&nbsp;</td>
          </tr>";
    }
    echo "</form></table>";
}

//输出销售情况
function display_sales_info($cart, $change = true, $images = 1) {
    // display items in shopping cart
    // optionally allow changes (true or false)
    // optionally include images (1 - yes, 0 - no)

    echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
         <form action=\"show_cart.php\" method=\"post\">
         <tr><th colspan=\"".(1 + $images)."\" bgcolor=\"#cccccc\">编号</th>
         <th bgcolor=\"#cccccc\">菜品编号</th>
         <th bgcolor=\"#cccccc\">标题</th>
         <th bgcolor=\"#cccccc\">类别</th>
         <th bgcolor=\"#cccccc\">单价</th>
         <th bgcolor=\"#cccccc\">售出数量</th>
         <th bgcolor=\"#cccccc\">总计金额</th>
         </tr>";

    //display each item as a table row
    $i=1;
    $sum_money=0;
    $sum_item=0;
    foreach ($cart as $food)  {
        if(!$food['sq'])$food['sq']=0;
        $food_sum=$food['sq']*$food['price'];
        $sum_money=$sum_money+$food_sum;
        $sum_item=$sum_item+$food['sq'];
        echo "<tr>";
        echo "<td align=\"center\">".$i."</td>";
        echo "<td align=\"center\">".$food['fno']."</td>";
//        echo "<td align=\"center\">".$food['username']."</td>";
        echo "<td align=\"center\">".$food['title']."</td>";
        echo "<td align=\"center\">".$food['catid']."</td>";
        echo "<td align=\"center\">".$food['price']."</td>";
        echo "<td align=\"center\">".$food['sq']."</td>";
        echo "<td align=\"center\">".$food_sum."</td>";
        $i=$i+1;
    }
    // display total row
    echo "<tr>
        <th colspan=\"".(5)."\" bgcolor=\"#cccccc\">&nbsp;</td>
        <th align=\"center\" bgcolor=\"#cccccc\">".htmlspecialchars($sum_item)."</th>
        <th align=\"center\" bgcolor=\"#cccccc\">
            ￥".number_format($sum_money, 2)."
        </th>
        </tr>";

    // display save change button
    if($change == true) {
        echo "<tr>
          <td colspan=\"".(2+$images)."\">&nbsp;</td>
          <td align=\"center\">
             <input type=\"hidden\" name=\"save\" value=\"true\"/>
             <input type=\"image\" src=\"images/save-changes.gif\"
                    border=\"0\" alt=\"Save Changes\"/>
          </td>
          <td>&nbsp;</td>
          </tr>";
    }
    echo "</form></table>";
}



//输出购物车html代码
function display_cart($cart, $change = true, $images = 1) {
    // display items in shopping cart
    // optionally allow changes (true or false)
    // optionally include images (1 - yes, 0 - no)

    echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
         <form action=\"show_cart.php\" method=\"post\">
         <tr><th colspan=\"".(1 + $images)."\" bgcolor=\"#cccccc\">Item</th>
         <th bgcolor=\"#cccccc\">Price</th>
         <th bgcolor=\"#cccccc\">Quantity</th>
         <th bgcolor=\"#cccccc\">Total</th>
         </tr>";

    //display each item as a table row
    foreach ($cart as $isbn => $qty)  {
        $book = get_food_details($isbn);
        echo "<tr>";
        if($images == true) {
            echo "<td align=\"left\">";
            if (file_exists("images/{$isbn}.jpg")) {
                $size = GetImageSize("images/{$isbn}.jpg");
                if(($size[0] > 0) && ($size[1] > 0)) {
                    echo "<img src=\"images/".htmlspecialchars($isbn).".jpg\"
                  style=\"border: 1px solid black\"
                  width=\"".($size[0]/3)."\"
                  height=\"".($size[1]/3)."\"/>";
                }
            } else {
                echo "&nbsp;";
            }
            echo "</td>";
        }
        echo "<td align=\"left\">
          <a href=\"show_book.php?fno=".urlencode($isbn)."\">".htmlspecialchars($book['title'])."</a>
          by ".htmlspecialchars($book['username'])."</td>
          <td align=\"center\">\$".number_format($book['price'], 2)."</td>
          <td align=\"center\">";

        // if we allow changes, quantities are in text boxes
        if ($change == true) {
            echo "<input type=\"text\" name=\"".htmlspecialchars($isbn)."\" value=\"".htmlspecialchars($qty)."\" size=\"3\">";
        } else {
            echo $qty;
        }
        echo "</td><td align=\"center\">\$".number_format($book['price']*$qty,2)."</td></tr>\n";
    }
    // display total row
    echo "<tr>
        <th colspan=\"".(2+$images)."\" bgcolor=\"#cccccc\">&nbsp;</td>
        <th align=\"center\" bgcolor=\"#cccccc\">".htmlspecialchars($_SESSION['items'])."</th>
        <th align=\"center\" bgcolor=\"#cccccc\">
            \$".number_format($_SESSION['total_price'], 2)."
        </th>
        </tr>";

    // display save change button
    if($change == true) {
        echo "<tr>
          <td colspan=\"".(2+$images)."\">&nbsp;</td>
          <td align=\"center\">
             <input type=\"hidden\" name=\"save\" value=\"true\"/>
             <input type=\"image\" src=\"images/save-changes.gif\"
                    border=\"0\" alt=\"Save Changes\"/>
          </td>
          <td>&nbsp;</td>
          </tr>";
    }
    echo "</form></table>";
}



function display_password_form() {
//显示html更改密码表单
?>
<br>
<form action="change_passwd.php" method="post">

    <div class="formblock">
        <h2>更改密码</h2>

        <p><label for="old_passwd">旧密码</label><br/>
            <input type="password" name="old_passwd" id="old_passwd"
                   size="16" maxlength="16" required /></p>

        <p><label for="passwd2">新密码:</label><br/>
            <input type="password" name="new_passwd" id="new_passwd"
                   size="16" maxlength="16" required /></p>

        <p><label for="passwd2">确认密码:</label><br/>
            <input type="password" name="new_passwd2" id="new_passwd2"
                   size="16" maxlength="16" required /></p>


        <button type="submit">修改密码</button>

    </div>
    <br>
    <?php
    }

//输出展示类别信息的html代码
function display_categories($cat_array) {
    if (!is_array($cat_array)) {
        echo "<p>暂无类别可选。</p>";
        return;
    }
    echo "<ul>";
    foreach ($cat_array as $row)  {
        $url = "show_cat.php?catid=".urlencode($row['catid']);
        $title = $row['catname'];
        echo "<li>";
        do_html_url($url, $title);
        if(isset($_SESSION['valid_admin'])){
            echo '<a href="edit_cat_form.php?catid='.$row["catid"].'">编辑</a><a href="bycat.php?deleteid='.$row["catid"].'">  删除</a>';
        }
        echo "</li>";
    }
    echo "</ul>";
    echo "<hr />";

    if(isset($_SESSION['valid_admin'])){
        do_html_url('edit_cat_form.php', '创建新类别');
    }
}


function display_foods($food_array) {
    //display all books in the array passed in
    if (!is_array($food_array)) {
        echo "<p>本店还未推出任何菜品，请添加菜品。</p>";
    } else {
        //create table
        echo "<table width=\"20%\" border=\"0\">";

        //create a table row for each book
        foreach ($food_array as $row) {
            $url = "show_food.php?fno=" . urlencode($row['fno']);
            echo "<tr><td>";

            if (@file_exists("images/foods/{$row['fno']}/cover.png"))  {
                $size = GetImageSize("images/foods/{$row['fno']}/cover.png");
                if(($size[0] > 0) && ($size[1] > 0)) {
                    echo "<td><img src=\"images/foods/".htmlspecialchars($row['fno'])."/cover.png\" style=\"border: 1px solid black\" height=150/></td>";
                }
            }
            else{
                echo "<td><img src=\"images/foods/cat/".htmlspecialchars($row['catid']).".png\"  style=\"border: 1px solid black\" height=150/></td>";
            }


            echo "</td><td>";
            $title = htmlspecialchars($row['title']);
            do_html_url($url, $title);
            echo '店铺：'.$row['username'];
            echo '<br>类别：'.get_categories($row['catid'])[0]['catname'];
            echo '<br>状态：'.$row['state'];
            if(isset($_SESSION['valid_admin']) or isset($_SESSION['valid_shop']))
                echo " <a href=\"change_state.php?title=".$row['title']."\"'>修改状态</a>";
            echo '<br>单价：'.$row['price'];
            echo '<br>描述：'.$row['description'];
            echo "</td></tr>";
        }

        echo "</table>";
    }

    echo "<hr />";
}

    function display_shops($shop_array) {
        //display all books in the array passed in
        if (!is_array($shop_array)) {
            echo "<p>本店还未推出任何菜品，请添加菜品。</p>";
        } else {
            //create table
            echo "<table width=\"20%\" border=\"0\">";

            //create a table row for each book
            foreach ($shop_array as $row) {
                $url = "show_shop.php?username=" . urlencode($row['username']);
                echo "<tr><td>";

                if (@file_exists("images/users/{$row['username']}/photo.png"))  {
                    $size = GetImageSize("images/users/{$row['username']}/photo.png");
                    if(($size[0] > 0) && ($size[1] > 0)) {
                        echo "<td><img src=\"images/users/".htmlspecialchars($row['username'])."/photo.png\" style=\"border: 1px solid black\" height=150/></td>";
                    }
                }
                else{
                    echo "<td><img src=\"images/users/photo.png\"  style=\"border: 1px solid black\" height=150/></td>";
                }

                echo "</td><td>";
                $username = htmlspecialchars($row['username']);
                do_html_url($url, $username);
                if(isset($_SESSION['valid_admin'])){
                    echo "<a href=\"edit_shop_form.php?username=$username\">编辑店铺</a>";
                    echo "<a href=\"byshop.php?delete_username=$username\">  删除店铺</a><br>";
                }

                echo '联系电话：'.$row['phone'];
                echo '<br>位置：'.$row['default_pos'];
                echo '<br>描述：'.($row['description']==''? $row['username']:$row['description']);
                echo '<br>菜品数量：'.get_foods_num($row['username']);
                echo '<br>订单数量：'.get_orders_num($row['username']);
                echo "</td></tr>";
            }

            echo "</table>";
        }

        echo "<hr />";
    }


//展示书籍详细信息
function display_food_details($food) {

    if (is_array($food)) {
        echo "<table><tr>";

        //display the picture if there is one
        if (@file_exists("images/foods/{$food['fno']}/cover.png"))  {
            $size = GetImageSize("images/foods/{$food['fno']}/cover.png");
            if(($size[0] > 0) && ($size[1] > 0)) {
                echo "<td><img src=\"images/foods/".htmlspecialchars($food['fno'])."/cover.png\" style=\"border: 1px solid black\" height=150/></td>";
            }
        }
        else{
            echo "<td><img src=\"images/foods/cat/".htmlspecialchars($food['catid']).".png\"  style=\"border: 1px solid black\" height=150/></td>";

        }

        echo "<td><ul>";
        echo "<li><strong>商家:</strong> ";
        echo htmlspecialchars($food['username']);
        echo "</li><li><strong>标题:</strong> ";
        echo htmlspecialchars($food['title']);
        echo "</li><li><strong>类别:</strong> ";
        echo htmlspecialchars(get_categories($food['catid'])[0]['catname']);

        echo "</li><li><strong>状态:</strong> ";
        echo htmlspecialchars($food['state']);
        if(isset($_SESSION['valid_admin']) or isset($_SESSION['valid_shop']))
            echo " <a href=\"change_state.php?title=".$food['title']."\"'>修改状态</a>";

        echo "</li><li><strong>价格:</strong> ";
        echo number_format($food['price'], 2);
        echo "</li><li><strong>描述:</strong> ";
        echo htmlspecialchars($food['description']);
        echo "</li></ul></td></tr>";

        echo "<tr>";
        echo "<td><h3>更多图片：</h3></td>";
        echo "</tr>";
        echo "<tr>";
        if (@file_exists("images/foods/".$food['fno']."/")){
            $dir = iconv("UTF-8", "GBK", "images/foods/".$food['fno']."/");
            $handle = opendir($dir); //当前目录
            while (false !== ($file = readdir($handle))) { //遍历该php文件所在目录
                list($filesname,$kzm)=explode(".",$file);//获取扩展名
                if($kzm=="gif" or $kzm=="jpg" or $kzm=="JPG" or $kzm=="png") { //文件过滤
                    if (!is_dir('./'.$file)) { //文件夹过滤
                        $array[]=$file;//把符合条件的文件名存入数组
                    }
                }
            }
            foreach($array as $j) {//循环条件控制显示图片张数
                //echo "<img widht=800 height=600 src=\".$path"\".$array[$j].">";//输出图片数组
                echo "<td><a href=".$dir."/".$j."><img height=300 src=".$dir."/".$j."></a></td>";
            }

        }

        else {
            echo "<td><a href=\"images/foods/cat/".$food['catid'].".png\"><img src=\"images/foods/cat/".htmlspecialchars($food['catid']).".png\"  height=300/></a></td>";
//            $dir = iconv("UTF-8", "GBK", "images/foods/cat/");
        }
        echo "</tr>";
        echo "</table>";
    } else {
        echo "<p>The details of this book cannot be displayed at this time.</p>";
    }
    echo "<hr />";
}


    function display_state_form($title,$state){


        $state_array=['正常','售罄','推荐'];


    ?>
        <form method="post" action="change_state.php">
            菜品名称：<?php echo $title; ?><br>
            <input type="hidden" name="title" value="<?php echo $title; ?>">

            菜品类别<br>
            <select name="state">
                <option value="normal">正常</option>
                <option value="sells_out">售罄</option>
                <option value="recommend">推荐</option>
            </select>
            <input type="submit">
        </form>

        <?php

    }



    function do_html_header($title){
    // 输出页眉
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
    <style>
      body { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      li, td { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      hr { color: #3333cc;}
      a { color: #000 }
      div.formblock
         { background: #ccc; width: 300px; padding: 6px; border: 1px solid #000;}
    </style>
</head>
<body>

<table width="100%" border="0" cellspacing="0" bgcolor="f19303">
    <tr>
        <td rowspan="2">
            <a href="index.php">    <img  src="images\ldfood.png" alt="ldfood logo" height="70" width="75" style="float:left; padding_right:6px;"/>
            </a><h1>&nbsp;&nbsp;兰大外卖</h1>
        </td>

        <?php
        if(!isset($_SESSION['valid_user'])){
            echo '</tr>';
        }
        else{
        ?>


        <td align="right" valign="bottom">
            <?php
            if(isset($_SESSION['admin_user'])) {
                echo "&nbsp;";
            } else {
                if(!isset($_SESSION['items']))$_SESSION['items']=0;
                echo "总计件数 = " . htmlspecialchars($_SESSION['items']);
            }
            ?>
        </td>
        <td align="right" rowspan="2" width="135">
            <?php
            if(isset($_SESSION['valid_shop']) or isset($_SESSION['valid_admin'])) {
                display_button('logout.php', 'logout', 'Log Out');
            } else {
                display_button('show_cart.php', 'cart', '查看购物车');
            }
            ?>
    </tr>
    <tr>
        <td align="right" valign="top">
            <?php
            if(isset($_SESSION['admin_user'])) {
                echo "&nbsp;";
            } else {
                if(!isset($_SESSION['total_price']))$_SESSION['total_price']=0;
                echo "总计价格 = ￥".number_format($_SESSION['total_price'],2);
            }
            ?>
        </td>
    </tr>
    <?php
    }
    ?>
</table>
    <hr/>
    <?php
        if ($title) {
            do_html_heading($title);
    }
}

function do_html_footer(){
    ?>

    </body>
</html>
<?php
}

function do_html_heading($heading){
    ?>
    <h2><?php echo $heading;?></h2>
    <?php
}

function display_button($target, $image, $alt) {
    echo "<div align=\"center\"><a href=\"".htmlspecialchars($target)."\">
          <img src=\"images/".htmlspecialchars($image).".png\"
           alt=\"".htmlspecialchars($alt)."\" border=\"0\" height=\"50\" style=\"border-radius: 20px\"
           /></a></div>";
}

function do_html_url($url,$name){
    ?>
    <h3><a  href="<?php echo $url;?>"><?php echo $name;?></a><br></h3>
    <?php
}

function display_site_info(){
    ?>
    <ul>
    <li>兰州大学外卖平台</li>
    <li>吃的安心，用的放心</li>
    <li>做最好的外卖平台</li>
    </ul>
<?php
}

function display_admin_login_form(){

?>

    <form method="post" action="admin_main.php">
        <div class="formblock">
            <h2>管理员登录</h2>

            <p><label for="username">用户名：</label>
                <br/>
                <input type="text" name="username" id="username"></p>

            <p><label for="passwd">密码：</label>
                <br/>
                <input type="password" name="passwd" id="passwd"></p>

            <button type="submit">登录</button>

            <p><a href="forgot_form.php">忘记密码？</a></p>
        </div>

    </form>

    <?php
        }


function display_login_form(){
    if (!isset($_GET['usertype'])) {
        //如果不存在->设置为虚拟值
        $_GET['usertype']=1;
        $login_type="会员登陆";
    }
    if($_GET['usertype']=='2')  {
        $login_type="商家登陆";
    }
    else{
        $login_type="会员登陆";
    }
?>
    <p><a href="register_form.php?usertype=1">注册会员</a>&nbsp;
        <a href="login.php?usertype=1">会员登录</a></p>
    <p>    <a href="register_form.php?usertype=2">商家入驻</a>&nbsp;
        <a href="login.php?usertype=2">商家登录</a></p>

    <?php
    if($_GET['usertype']=='2'){

    ?>

    <form method="post" action="shop_main.php">
    <?php
    }
    else{
    ?>
    <form method="post" action="user_main.php">
    <?php
    }
    ?>
    <div class="formblock">
    <h2><?php  echo $login_type;  ?></h2>

    <p><label for="username">用户名：</label>
    <br/>
    <input type="text" name="username" id="username"></p>

    <p><label for="passwd">密码：</label>
    <br/>
    <input type="password" name="passwd" id="passwd"></p>

    <button type="submit">登录</button>

    <p><a href="forgot_form.php">忘记密码？</a></p>
    </div>

    </form>
<?php
}

function display_registration_form(){
    ?>
    <form action="register_new.php" method="post" enctype="multipart/form-data">
    <div class="formblock">
    <h2>立即注册</h2>
        <input type="hidden" id="type" name="type" value="<?php  echo $_GET['usertype']; ?>">

        <?php

        if($_GET['usertype']==3){
            ;
        }
        else{
        ?>

        <p><label for="photo">头像：</label>
            <br/>
            <input type="file" name="photo" id="photo" />
        </p>
        <?php
        }
        ?>

    <p><label for="email">邮箱：</label>
    <br/>
    <input type="email" name="email" id="email" size+"30" maxlength="100" required />
    </p>

    <p><label for="username"><?php if($_GET['usertype']==1)echo '校园卡号：'; else if($_GET['usertype']==2)echo '商铺名：'; else if($_GET['usertype']==3)echo '管理员：'; ?></label>
    <br/>
    <input type="text" name="username" id="username" size+"16" maxlength="16" required />
    </p>

    <p><label for="passwd">密码：</label>
    <br/>
    <input type="password" name="passwd" id="passwd" size+"16" maxlength="16" required />
    </p>

    <p><label for="passwd2">确认密码：</label>
    <br/>
    <input type="password" name="passwd2" id="passwd2" size+"16" maxlength="16" required />
    </p>

        <?php
        if($_GET['usertype']==3){
            ;
        }
        else{
        ?>
        <p>
            <hr>
        </p>

        <p><label for="passwd2">姓名：</label>
            <br/>
            <input type="text" name="name" id="name" size+"30" maxlength="30" required />
        </p>
        <p><label for="性别">性别：</label>
            <br/>
            <select name="sex">
                <option value=0 >男</option>
                <option value=1 >女</option>
            </select>
        </p>

        <p><label for="age">年龄：</label>
            <br/>
            <input type="text" name="age" id="age" size+"30" maxlength="30" required />
        </p>
        <p><label for="passwd2">联系电话：</label>
            <br/>
            <input type="text" name="phone" id="phone" size+"20" maxlength="20" required />
        </p>
        <p><label for="qq">QQ：</label>
            <br/>
            <input type="text" name="qq" id="qq" size+"20" maxlength="20" required />
        </p>
        <p><label for="default_pos">默认地址：</label>
            <br/>
            <input type="default_pos" name="default_pos" id="default_pos" size+"100" maxlength="100" required />
        </p>

        <?php
        }
        if($_GET['usertype']==2){
        ?>
        <p><label for="description">店铺描述:</label>
            <br/>
            <textarea rows="3" cols="25" name="description"></textarea>
        </p>
        <?php
        }

        ?>

        <button type="submit">注册</button>
    </div>
</form>
<?php
}

function display_search(){

    ?>
        <br><hr><br>
        <form method="get" action="shop_disp_all.php">
            <input type="text" name="search">
            <input type="submit" name="sub">
        </form>

        <br>
        <hr>
    <?php
    }


function display_button_menu() {
  //显示此页面上的菜单选项
    $target='shop_main.php';
    if(isset($_SESSION['valid_user'])){

?>
        <hr>
        <a href="user_main.php">主页</a> &nbsp;|&nbsp;
        <a href="shop_disp_all.php">所有菜品</a> |
        <a href="bycat.php">查看分类</a> |
        <a href="byshop.php">查看店铺</a> |
        <a href="shop_disp_all.php?recommend=1">查看推荐</a> <br>
        <a href="show_cart.php">查看购物车</a> |
        <a href="edit_shop_form.php">编辑个人信息</a> |
        <a href="change_passwd_form.php">修改密码</a> |
        <a href="logout.php">退出</a>
        <hr>
<?php
}else if(isset($_SESSION['valid_shop'])){
        ?>
        <hr>
        <a href="shop_main.php">主页</a> &nbsp;|&nbsp;
        <a href="shop_disp_all.php">本店菜品</a> |
        <a href="insert_food_form.php">添加菜品</a> |
        <a href="sales_info.php">查看销售情况</a> |
        <a href="order_info.php">查看订单</a><br>
        <a href="edit_shop_form.php">编辑商家信息</a> |
        <a href="change_passwd_form.php">修改密码</a> |
        <a href="logout.php">退出</a>
        <hr>

        <?php
    }else if(isset($_SESSION['valid_admin'])){
        ?>
        <hr>
        <a href="admin_main.php">主页</a> &nbsp;|&nbsp;
        <a href="shop_disp_all.php">所有菜品</a> |
        <a href="bycat.php">查看菜品类别</a> |
        <a href="byshop.php">查看店铺</a> |
        <a href="shop_disp_all.php?recommend=1">查看推荐</a><br>
        <a href="sales_info.php">查看销售情况</a> |

        <a href="register_form.php?usertype=3">创建管理员</a> |
        <a href="change_passwd_form.php">修改密码</a> |
        <a href="logout.php">退出</a>
        <hr>

        <?php
    }
}


function display_forgot_form() {
 //显示HTML表单以重置和发送电子邮件密码
?>
   <br>
   <form action="forgot_passwd.php" method="post">
 <div class="formblock">
    <h2>忘记密码?</h2>
    <p><label for="username">请输入用户名:</label><br/>
    <input type="text" name="username" id="username" 
      size="16" maxlength="16" required /></p>
    <button type="submit">更改密码</button>
   </div>
   <br>
<?php
}


//输出支付信息表格html代码
function display_checkout_form() {
    //display the form that asks for name and address
    $conn = db_connect();
    $query = "select * from user where username = '".$_SESSION['valid_user']."'";
    $result = @$conn->query($query);
    $result = db_result_to_array($result)[0];

    ?>
    <br />
    <table border="0" width="100%" cellspacing="0">
        <form action="purchase.php" method="post">
            <tr><th colspan="2" bgcolor="#cccccc">配送信息</th></tr>
            <tr>
                <td>姓名</td>
                <td><input type="text" name="name" maxlength="40" size="40" value="<?php echo $result['name'];?>"/></td>
            </tr>
            <tr>
                <td>电话</td>
                <td><input type="text" name="phone" maxlength="40" size="40" value="<?php echo $result['phone'];?>"/></td>
            </tr>
            <tr>
                <td>地址</td>
                <td><input type="text" name="pos" maxlength="20" size="40" value="<?php echo $result['default_pos'];?>"/></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><p><strong>点击下方按钮确认订单，或者你可以继续购物：</strong></p>
                    <?php display_form_button("checkout", "支付订单"); ?>
                </td>
            </tr>
        </form>
    </table><hr />
    <?php
}


//展示表单按钮
function display_form_button($image, $alt) {
    echo "<div align=\"center\"><input type=\"image\"
           src=\"images/".htmlspecialchars($image).".png\"
           alt=\"".htmlspecialchars($alt)."\" border=\"0\" height=\"50\"
           width=\"135\" style=\"border-radius: 20px\"/></div>";
}

//输出支付价格信息
function display_shipping($shipping) {
    // display table row with shipping cost and total price including shipping
    ?>
    <table border="0" width="100%" cellspacing="0">
        <tr><td align="left">Shipping</td>
            <td align="right"> <?php echo number_format($shipping, 2); ?></td></tr>
        <tr><th bgcolor="#cccccc" align="left">TOTAL INCLUDING SHIPPING</th>
            <th bgcolor="#cccccc" align="right">$ <?php echo number_format($shipping+$_SESSION['total_price'], 2); ?></th>
        </tr>
    </table><br />
    <?php
}

//输出填写支付账号信息表单html代码
function display_card_form($name) {
    //display form asking for credit card details
    ?>
    <table border="0" width="100%" cellspacing="0">
        <form action="process.php" method="post">
            <tr><th colspan="2" bgcolor="#cccccc">Credit Card Details</th></tr>
            <tr>
                <td>Type</td>
                <td><select name="card_type">
                        <option value="VISA">VISA</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="American Express">American Express</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Number</td>
                <td><input type="text" name="card_number" value="" maxlength="16" size="40"></td>
            </tr>
            <tr>
                <td>AMEX code (if required)</td>
                <td><input type="text" name="amex_code" value="" maxlength="4" size="4"></td>
            </tr>
            <tr>
                <td>Name on Card</td>
                <td><input type="text" name="card_name" value = "<?php echo $name; ?>" maxlength="40" size="40"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <p><strong>点击下方按钮付款，或者选择继续购物：</strong></p>
                    <?php display_form_button('checkout', 'Purchase These Items'); ?>
                </td>
            </tr>
    </table>
    <?php
}

?>
