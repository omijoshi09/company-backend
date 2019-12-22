<?php
include "db.php";
try {
    $query_in_process = "SELECT orderNumber, orderDate, status FROM `orders` WHERE status = 'In process'";
    $orders_in_process = mysqli_query($connection, $query_in_process);

    $query_canceled = "SELECT orderNumber, orderDate, status FROM `orders` WHERE status = 'Cancelled'";
    $orders_cancelled = mysqli_query($connection, $query_canceled);

    $query_latest= "SELECT orderNumber, orderDate, status FROM `orders` ORDER BY orderDate DESC LIMIT 20";
    $orders_latest= mysqli_query($connection, $query_latest);


    if(!$orders_in_process || !$orders_cancelled || !$orders_latest) {
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
include "head.php";
?>
<body>
<header class="orders">
    <!--Include Navbar File-->
    <?php
    include "navbar.php";
    ?>
    <div class="title-text">
        <h1>Order is Heaven's first law.</h1>
    </div>

</header>
<br><br>

<h2>Order In Process: </h2>
<br>
<table id="dialog-table">
    <tr>
        <th><h3>Order Number</h3></th>
        <th><h3>Order Date</h3></th>
        <th><h3>Order Status</h3></th>
    </tr>
    <?php
    while ($order_pro = mysqli_fetch_assoc($orders_in_process)){
        ?>
        <tr style="cursor: pointer" onclick="openModal(document.getElementById('<?php printf($order_pro['orderNumber']) ?>'))">
            <td id="<?php printf($order_pro['orderNumber']) ?>"><?php printf($order_pro['orderNumber']); ?></td>
            <td><?php printf($order_pro['orderDate']); ?></td>
            <td><?php printf($order_pro['status']); ?></td>
        </tr>
        <?php
    }
    ?>
</table>

<br>
<h2>Order Cancelled: </h2>
<br>

<table id="dialog-table2">
    <tr>
        <th><h3>Order Number</h3></th>
        <th><h3>Order Date</h3></th>
        <th><h3>Order Status</h3></th>
    </tr>
    <?php
    while ($order_can = mysqli_fetch_assoc($orders_cancelled)){
        ?>
        <tr style="cursor: pointer" onclick="openModal(document.getElementById('<?php printf($order_can['orderNumber']) ?>'))">
            <td id="<?php printf($order_can['orderNumber']) ?>"><?php printf($order_can['orderNumber']); ?></td>
            <td><?php printf($order_can['orderDate']); ?></td>
            <td><?php printf($order_can['status']); ?></td>
        </tr>
        <?php
    }
    ?>
</table>

<br>
<h2>Top 20 Orders: </h2>
<br>

<table id="dialog-table3">
    <tr>
        <th><h3>Order Number</h3></th>
        <th><h3>Order Date</h3></th>
        <th><h3>Order Status</h3></th>
    </tr>
    <?php
    while ($order_lst = mysqli_fetch_assoc($orders_latest)){
        ?>
        <tr style="cursor: pointer" onclick="openModal(document.getElementById('<?php printf($order_lst['orderNumber']) ?>'))">
            <td id="<?php printf($order_lst['orderNumber']) ?>"><?php printf($order_lst['orderNumber']); ?></td>
            <td><?php printf($order_lst['orderDate']); ?></td>
            <td><?php printf($order_lst['status']); ?></td>
        </tr>
        <?php
    }
    ?>
</table>
<!--Footer File-->
<?php
include "footer.php";
?>


<!-- Dialog -->
<dialog id="myFirstDialog" >
    <div class="details">
        <h3 id="dialog_person">Details About Order</h3>
        <hr>
        <!-- Filtered table start -->
        <table id="dialog-table-show">
            <tr>
                <th><h3>Product Code</h3></th>
                <th><h3>Product Line</h3></th>
                <th><h3>Product Name</h3></th>
                <th><h3>Comments</h3></th>
            </tr>
        </table>
        <!-- Filtered table End -->

        <div style="text-align: center; padding-top: 10px"><button id="hide" onclick="close_dialog()"><h3>Close</h3></button></div>
    </div>
</dialog>
<!-- End of Dialog -->

<script type="text/javascript">
    function openModal(item) {
        var order_id = item.innerHTML;
        ajax.call( this, '/omkar_joshi_A3_COMP30680/order_detail.php',order_id );
    }

    function ajax(url,order_id){
        var req=new XMLHttpRequest();
        req.open( 'POST', url, true );
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState === 4 || this.status === 200){
                if(this.responseText) {
                    var data = JSON.parse(this.responseText);
                    console.log('data', data);
                    createModal(data)
                }

            }
        };
        req.send("id=" + order_id);

    }

    function createModal(order_data) {
        var dialog = document.getElementById('myFirstDialog');
        close_dialog();
        dialog.show();
        // Table operation
        var inner_table = document.getElementsByTagName('table')[3];

        // Append new row with data
        order_data.forEach(function(data, outerindex)  {
            var filtered_table = inner_table.insertRow(outerindex + 1);
            filtered_table.classList.add('dialog-table-val');
            var cel1 = filtered_table.insertCell(0);
            var cel2 = filtered_table.insertCell(1);
            var cel3 = filtered_table.insertCell(2);
            var cel4 = filtered_table.insertCell(3);
            cel1.innerHTML = data.productCode ? data.productCode : '-';
            cel2.innerHTML = data.productLine ? data.productLine : '-';
            cel3.innerHTML = data.productName ? data.productName : '-';
            cel4.innerHTML = data.comments ? data.comments : '-';

        });

    }

    function close_dialog() {
        // Close the dialog box
        //clear table data
        // Get table attributes

        var elmtTable = document.getElementById('dialog-table-show');
        var tableRows = elmtTable.getElementsByTagName('tr');
        var rowCount = tableRows.length;

        // clear all the previous data from table
        for (var x=rowCount-1; x>0; x--) {
            document.getElementById("dialog-table-show").deleteRow(x);
        }
        document.getElementById('myFirstDialog').close();
    }

</script>
</body>
</html>
