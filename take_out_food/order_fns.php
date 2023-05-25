<?php

//获取订单信息信息
function get_order_info() {

  $conn = db_connect();
  $query = "select order_items.orderid orderid,fno,item_price,quantity,username,date,order_status,name,phone,position from orders,order_items where fno in (select fno from foods where username= '".$_SESSION['valid_shop']."' ) and orders.orderid=order_items.orderid";

  $result = @$conn->query($query);
  if (!$result) {
    return false;
  }
  $num_books = @$result->num_rows;
  if ($num_books == 0) {
    return false;
  }
  $result = db_result_to_array($result);

  return $result;
}


//获取销售信息信息
function get_sales_info() {
  // query database for all details for a particular book
  $conn = db_connect();
  if(isset($_SESSION['valid_shop']))
    $query = "select foods.fno,username,title,catid,price,description,s.sq from foods left join (select fno,sum(quantity) sq from order_items where fno in ("."select fno from foods where username = '".$conn->real_escape_string($_SESSION['valid_shop'])."'".") group by fno) s on foods.fno=s.fno order by s.sq desc";
  else if(isset($_SESSION['valid_admin']))
    $query = "select foods.fno,username,title,catid,price,description,s.sq from foods left join (select fno,sum(quantity) sq from order_items where fno in ("."select fno from foods ) group by fno) s on foods.fno=s.fno order by s.sq desc";

  $result = @$conn->query($query);
  if (!$result) {
    return false;
  }
  $num_books = @$result->num_rows;
  if ($num_books == 0) {
    return false;
  }
  $result = db_result_to_array($result);

  return $result;
}


//额外费用（配送费）
function calculate_shipping_cost() {
  // as we are shipping products all over the world
  // via teleportation, shipping is fixed
  return 3.00;
}


//支付
function process_card($card_details) {
  // connect to payment gateway or
  // use gpg to encrypt and mail or
  // store in DB if you really want to

  return true;
}
//记录订单信息
function insert_order($order_details) {
  // extract order_details out as variables
  extract($order_details);

  $conn = db_connect();

  // we want to insert the order as a transaction
  // start one by turning off autocommit
  $conn->autocommit(FALSE);


  $date = date("Y-m-d H:i:s");

  $query = "insert into orders(`username`, `total`, `date`, `order_status`, `name`, `phone`, `position`) values
            ('".$conn->real_escape_string($_SESSION['valid_user'])."', '". $conn->real_escape_string($_SESSION['total_price']) .
             "', '". $conn->real_escape_string($date) ."', 'PARTIAL',
             '" . $conn->real_escape_string($name) . "', '" . $conn->real_escape_string($phone) .
             "', '". $conn->real_escape_string($pos)."')";

  $result = $conn->query($query);
  if (!$result) {
    return false;
  }

  $query = "select orderid from orders where
               username = '". $conn->real_escape_string($_SESSION['valid_user'])."' and
               total > (".(float)$_SESSION['total_price'] ."-.001) and
               total < (". (float)$_SESSION['total_price']."+.001) and
               date = '".$conn->real_escape_string($date)."' and
               order_status = 'PARTIAL' and
               name = '".$conn->real_escape_string($name)."' and
               phone = '".$conn->real_escape_string($phone)."' and               
               position = '".$conn->real_escape_string($pos)."'";

  $result = $conn->query($query);

  if($result->num_rows>0) {
    $order = $result->fetch_object();
    $orderid = $order->orderid;
  } else {
    return false;
  }

  foreach($_SESSION['cart'] as $fno => $quantity) {
    $detail = get_food_details($fno);
    $query = "delete from order_items where
              orderid = '". $conn->real_escape_string($orderid)."' and fno = '". $conn->real_escape_string($fno)."'";

    $result = $conn->query($query);
    $query = "insert into order_items values('". $conn->real_escape_string($orderid) ."', '". $conn->real_escape_string($fno) . "', ". $conn->real_escape_string($detail['price']) .", " . $conn->real_escape_string($quantity). ")";

    $result = $conn->query($query);
    if(!$result) {

      return false;
    }
  }

  $conn->commit();
  $conn->autocommit(TRUE);

  return $orderid;
}

?>
