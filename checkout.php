<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = $mysqli->real_escape_string( $_POST['name']);
   $number = $_POST['number'];
   $email = $mysqli->real_escape_string( $_POST['email']);
   $method = $mysqli->real_escape_string( $_POST['method']);
   $placed_on = date('Y-m-d');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = $mysqli->query( "SELECT * FROM `cart` natural join `products` WHERE user_id = '$user_id'") or die('query failed');
   if( $cart_query->num_rows > 0){
      while($cart_item = $cart_query->fetch_assoc()){
         $cart_products[] = $cart_item['product_name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = $mysqli->query("SELECT * FROM `orders` WHERE user_id='$user_id'  AND method = '$method' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'Votre panier est vide !';
   }else{
      if($order_query->num_rows > 0){
         $message[] = 'commande déjà passée !'; 
      }else{
         $mysqli->query( "INSERT INTO `orders`(user_id, method, total_products, total_price, placed_on) VALUES('$user_id', '$method' , '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'commande passée avec succès!';
         $mysqli->query( "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      }
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>paiement</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>paiement</h3>
   <p> <a href="home.php">accueil</a> / paiement </p>
</div>



<section class="checkout">

   <form method="post">
      <h3>passer votre commande</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Votre nom :</span>
            <input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>" readonly>
         </div>
         <div class="inputBox">
            <span>Votre télé :</span>
            <input type="tel" name="number" value="<?php echo $_SESSION['user_tel']; ?>" readonly>
         </div>
         <div class="inputBox">
            <span>Votre email :</span>
            <input type="email" name="email" value="<?php echo $_SESSION['user_email']; ?>" readonly>
         </div>
         <div class="inputBox">
            <span>Methode de paiement :</span>
            <select name="method">
               <option value="credit card">carte de crédit</option>
               <option value="paypal">PayPal</option>
               <option value="paytm">Paytm</option>
               <option value="paytm">Amazon Pay</option>
               <option value="paytm">Payoneer</option>
            </select>
         </div>
         
      </div>
         
      </div>
      <span><br>Produit(s) commandé : </span>
      <section class="display-order">

         <?php  
            $grand_total = 0;
            $select_cart = $mysqli->query("SELECT * FROM `cart` NATURAL JOIN `products` WHERE user_id = '$user_id'") or die('query failed');
            if( $select_cart->num_rows > 0){
               while($fetch_cart = $select_cart->fetch_assoc()){
                  $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                  $grand_total += $total_price;
         ?>
         <p> <?php echo $fetch_cart['product_name']; ?> <span>(<?php echo '$'.$fetch_cart['price'].' x '. $fetch_cart['quantity']; ?>)</span> </p>
         <?php
            }
         }else{
            echo '<p class="empty">Votre panier est vide</p>';
         }
         ?>
         <div class="grand-total">prix total : <span>$<?php echo $grand_total; ?></span> </div>

      </section>

      <input type="submit" value="commander" class="btn" name="order_btn">
   </form>

</section>









<?php include 'footer.php'; ?>

</body>
</html>