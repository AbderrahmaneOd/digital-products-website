<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>commandes</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>vos commandes</h3>
   <p> <a href="home.php">accuel</a> / commandes </p>
</div>

<section class="placed-orders">

   <h1 class="title">commandes effectuées</h1>

   <div class="box-container">

      <?php
         $order_query = $mysqli->query( "SELECT * FROM `orders` NATURAL JOIN `users` WHERE user_id = '$user_id'") or die('query failed');
         if( $order_query->num_rows > 0){
            while($fetch_orders = $order_query->fetch_assoc()){
      ?>
      <div class="box">
         <p> date : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> nom : <span><?php echo $fetch_orders['user_name']; ?></span> </p>
         <p> Télé : <span><?php echo $fetch_orders['telephone']; ?></span> </p>
         <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> methode de paiement : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> votre commande(s) : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> prix total : <span>$<?php echo $fetch_orders['total_price']; ?></span> </p>
         <p> statue de paiement: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         </div>
      <?php
       }
      }else{
         echo '<p class="empty">pas encore de commandes passées !</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>


</body>
</html>