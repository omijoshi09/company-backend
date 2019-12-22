<?php
include "db.php";

$order_id = $_POST['id'];
$query_order= "SELECT orderdetails.productCode,products.productLine,products.productName, orders.comments
                FROM `orders`, `orderdetails`, `products`
                WHERE orders.orderNumber = '$order_id' AND orderdetails.orderNumber  = orders.orderNumber AND 
                orderdetails.productCode = products.productCode";
$order_detail= mysqli_query($connection, $query_order);

$order_array = array();

while($row = mysqli_fetch_assoc($order_detail)) {
    $order_array[] = $row;
}
echo json_encode($order_array);





