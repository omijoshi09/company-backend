<?php
include "db.php";

try {
    $query_customers_group_by = "SELECT customerName, country, city, phone FROM `customers`  GROUP BY country";
    $result_group_by = mysqli_query($connection, $query_customers_group_by);

    if(!$result_group_by) {
        header('Location: /omkar_joshi_A3_COMP30680/404.php');
    }

}catch (Exception $error) {
    header('Location: /omkar_joshi_A3_COMP30680/404.php');

}


?>

<!DOCTYPE html>
<html lang="en">
<!--Include HeaderFile-->
<?php
include "head.php"
?>
<body>
<header class="customer">
    <!--Include Navbar File-->
    <?php
    include "navbar.php";
    ?>
    <div class="title-text">
        <h1>Make a customer,<br>Not a sale.</h1>
    </div>

</header>
<br><br>
<?php

while ($customer_group_by = mysqli_fetch_assoc($result_group_by) ){
    if($customer_group_by['country']){
        ?>
        <br>
        <h2> Customers From: <?php printf($customer_group_by['country']) ?> </h2>
        <table id="dialog-table">
            <tr>
                <th><h3>Customer Name</h3></th>
                <th><h3>Customer Country</h3></th>
                <th><h3>Customer City</h3></th>
                <th><h3>Customer Phone Number</h3></th>
            </tr>
            <?php
            try {
                $get_country_name = sprintf($customer_group_by['country']);
                $query_customers = "SELECT customerName, country, city, phone FROM `customers` where country = '$get_country_name' ORDER BY country";
                $result = mysqli_query($connection, $query_customers);
            }catch (Exception $error) {
                header('Location: /omkar_joshi_A3_COMP30680/404.php');
            }

            while ($customer = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php printf($customer['customerName']); ?></td>
                    <td><?php printf($customer['country']); ?></td>
                    <td><?php printf($customer['city']); ?></td>
                    <td><?php printf($customer['phone']); ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
    ?>
    <?php
}
?>

<!--Footer File-->
<?php
include "footer.php";
?>


</body>
</html>
