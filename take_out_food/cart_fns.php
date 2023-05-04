<?php
//计算菜品价格
function calculate_price($cart) {
    $price = 0.0;
    if(is_array($cart)) {
        $conn = db_connect();
        foreach($cart as $isbn => $qty) {
            $query = "select price from foods where fno='".$conn->real_escape_string($isbn)."'";
            $result = $conn->query($query);
            if ($result) {
                $item = $result->fetch_object();
                $item_price = $item->price;
                $price +=$item_price*$qty;
            }
        }
    }
    return $price;
}
//计算物品件数
function calculate_items($cart) {
    // sum total items in shopping cart
    $items = 0;
    if(is_array($cart))   {
        foreach($cart as $isbn => $qty) {
            $items += $qty;
        }
    }
    return $items;
}




?>
