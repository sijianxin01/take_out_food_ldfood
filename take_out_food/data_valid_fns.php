<!-- // 用户输入数据有效性验证函数 -->
<?php
function filled_out($form_vars){
    //检查每个变量是否有值
    // foreach遍历数组
    // isset检查变量是否已经设置并且非null
    foreach($form_vars as $key =>$value){
        if ((!isset($key))||($value=='')) {
            return false;
        }
    }
    return true;
}

function valid_email($address){
    //检查邮箱地址是否有效
    // preg_match 正则表达式
    if (preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/',$address)) {
        return true;
    }else{
        return false;
    }
}
?>