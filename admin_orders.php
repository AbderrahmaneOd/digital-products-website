<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   $mysqli->query( "UPDATE `orders` SET payment_status = '$update_payment' WHERE order_id = '$order_update_id'") or die('query failed');
   $message[] = 'le statut de paiement a été mis à jour !';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $mysqli->query( "DELETE FROM `orders` WHERE order_id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
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

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">commandes passées</h1>

   <div class="box-container">
      <?php
      $select_orders = $mysqli->query( "SELECT * FROM `orders` NATURAL JOIN `users`") or die('query failed');
      if( $select_orders->num_rows > 0){
         while($fetch_orders = $select_orders->fetch_assoc()){
      ?>
      <div class="box">
         <p> user id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> date : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> nom : <span><?php echo $fetch_orders['user_name']; ?></span> </p>
         <p> Télé : <span><?php echo $fetch_orders['telephone']; ?></span> </p>
         <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> produit(s) : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> prix total : <span>$<?php echo $fetch_orders['total_price']; ?></span> </p>
         <p> methode de paiement : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['order_id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="pending">pending</option>
               <option value="completed">completed</option>
            </select>
            <input type="submit" value="mettre à jour" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['order_id']; ?>" onclick="return confirm('supprimer cette commande ?');" class="delete-btn">supprimer</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">pas encore de commandes passées !</p>';
      }
      ?>
   </div>

</section>










<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>