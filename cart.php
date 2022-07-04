<?php

session_start();

require_once("php/createdb.php");
require_once("php/component.php");

$db = new CreateDb("Shoppingdb", "ProductTb");

if(isset($_POST['remove'])){
    if($_GET['action'] == 'remove'){
        foreach($_SESSION['cart'] as $key => $value){
            if($value['product_id'] == $_GET['id']){
                unset($_SESSION['cart'][$key]);
                echo "<script>alert('Product has been Removed..!')</script>";
                echo "<script>window.location = 'cart.php'</script>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- fontowesome -->
    <link href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="jquery.min.js">
    <link href="bootstrap/js/bootstrap.min.js" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link  href="bootstrap/css/bootstrap.min.css" rel="stylesheet" >

    <link rel="stylesheet" href="style.css">
    <title>Cart</title>
</head>
<body class="bg-light">
    
<?php 
require_once ("php/header.php");
?>

<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart">
                <h6 class="text-center">My Shopping List</h6>
                <hr>

                <?php

                $total = 0;

               if(isset($_SESSION['cart'])){
                    $product_id = array_column($_SESSION['cart'], "product_id");

                    $result = $db->getdata();
                    while($row = mysqli_fetch_assoc($result)){
                        foreach($product_id as $id){
                            if($row['id'] == $id){
                                cartElement($row['product_image'], $row['product_name'], $row['product_price'], $row['id']);
                                $total = $total + (int)$row['product_price'];
                            }
                        }
                    }
               }else{
                   echo "<h5>Cart is Empty</h5>";
               }

                ?>
                
            </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
            <div class="pt-4">
                <h6>PRICE DETAILS</h6>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                        if(isset($_SESSION['cart'])){
                            $count = count($_SESSION['cart']);
                            echo "<h6>Price ($count items)</h6>";
                        }else{
                            echo "<h6>Price (0 items)</h6>";
                        }
                        ?>
                        <h6>Delivery Charges</h6>
                        <hr>
                        <h6>Amount Payable</h6>
                    </div>
                    <div class="col-md-6">
                        <h6>Ksh<?php echo $total; ?></h6>
                        <h6 class="text-success">FREE</h6>
                        <hr>
                        <h6>Ksh<?php echo $total;?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="js1/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
