<?php

//start session
session_start();

require_once ('./php/createdb.php');
require_once ('./php/component.php');

// create instance of createdb class
$database = new CreateDb("Shoppingdb", "ProductTb");


//if the card button is clicked execute this

if(isset($_POST['add'])){
 //print_r($_POST['product_id']);

    if(isset($_SESSION['cart'])){

        $item_array_id = array_column($_SESSION['cart'], "product_id");
        
        
        if(in_array($_POST['product_id'], $item_array_id)){
            echo "<script>alert('Product is already added in the cart...!')</script>";
            echo "<script>window.location = \"index.php\"</script>";
        }else{
            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id' => $_POST['product_id']
            );

            $_SESSION['cart'][$count] = $item_array;
            echo "<script>alert('Product has been added to Cart....!')</script>";
            echo "<script>window.location = \'index.php\'</script>";
            
        }

    }else{
        $item_array = array(
            'product_id' => $_POST['product_id']
        );

        // create new session variable
        $_SESSION['cart'][0] = $item_array;
        
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
    <title>Shopping cart</title>
</head>
<body>

<?php require_once("php/header.php");?>
    
<div class="container">
    <div class="row text-center py-5">
       <?php
       $result = $database->getData();
       while($row = mysqli_fetch_assoc($result)){
           component($row['product_name'], $row['product_price'],$row['product_image'],$row['id']);
       }
       ?> 
    </div>
</div>

 



<script src="js1/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>