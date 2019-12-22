<?php
include "db.php";


// Error Handling Via Try Catch
try {
    $query = "SELECT * FROM productlines";
    $result = mysqli_query($connection, $query);
    if(!$result) {
        header('Location: /omkar_joshi_A3_COMP30680/404.php');
    }
}catch (Exception $error){
    header('Location: /omkar_joshi_A3_COMP30680/404.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<!--Header File-->
<?php
include "head.php"
?>
<body>
<header>
    <!--Nav bar File-->
    <?php
    include "navbar.php";
    ?>
    <div class="title-text">
        <h1>Happiness is not a goal,<br> It is a by-product.</h1>
    </div>

</header>
<section class="section-features" id="features">
    <div class="row">
        <h2>Our Major Products</h2>
    </div>
</section>


<div id="accordion">
    <!--Loop to iterate all result value-->
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="panel"> <!-- first panel -->
            <div style="display:block">
                <div class='header'><h3>Product: <?php printf($row['productLine']) ?></h3></div>
                <br>
                <div class='header'><h3>Description :<?php printf($row['textDescription']) ?></h3></div>
            </div>
            <!--Sorted the data according to the product name-->
            <?php
            try {
                $get_name = sprintf($row['productLine']);
                $get_products = "SELECT * FROM products where productLine ='$get_name'";
                $products_result = mysqli_query($connection, $get_products);
            }catch (Exception $error){
                header('Location: /omkar_joshi_A3_COMP30680/404.php');

            }
            ?>
            <div class="body">
                <table id="dialog-table">
                    <tr>
                        <th><h3>Product Code</h3></th>
                        <th><h3>Product Name</h3></th>
                        <th><h3>Product Description</h3></th>
                    </tr>
                    <?php
                    while ($product = mysqli_fetch_assoc($products_result)){
                        ?>
                        <tr>
                            <td><?php printf($product['productCode']); ?></td>
                            <td><?php printf($product['productName']); ?></td>
                            <td><?php printf($product['productDescription']); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<!--Footer File-->
<?php
include "footer.php";
?>


<script type="text/javascript">
    function initAccordion(accordionElem){

        //when panel is clicked, handlePanelClick is called.

        function handlePanelClick(event){
            showPanel(event.currentTarget);
        }

        //Hide currentPanel and show new panel.

        function showPanel(panel){
            //Hide current one. First time it will be null.
            var expandedPanel = accordionElem.querySelector(".active");
            if (expandedPanel){
                expandedPanel.classList.remove("active");
            }

            //Show new one
            panel.classList.add("active");

        }

        var allPanelElems = accordionElem.querySelectorAll(".panel");
        for (var i = 0, len = allPanelElems.length; i < len; i++){
            allPanelElems[i].addEventListener("click", handlePanelClick);
        }


    }
    // Load this function
    window.onload = function () {
        initAccordion(document.getElementById("accordion"));
    }
</script>
</body>
</html>
