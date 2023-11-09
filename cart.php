<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_cart'])){
   $product_id = $_POST['product_id'];
   $cart_quantity = $_POST['cart_quantity'];
   $mysqli->query( "UPDATE `cart` SET quantity = '$cart_quantity' WHERE product_id = '$product_id' and user_id='$user_id'") or die('query failed');
   $message[] = 'mise à jour de la quantité du panier !';
}

if(isset($_GET['product_id'])){
   $product_id = $_GET['product_id'];
   $mysqli->query( "DELETE FROM `cart` WHERE user_id = '$user_id' AND product_id = '$product_id' ") or die('query failed');
   header('location:cart.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>panier</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>panier</h3>
   <p> <a href="home.php">accueil</a> / panier </p>
</div>

<section class="shopping-cart">

   <h1 class="title">produits ajoutés</h1>

   <div class="box-container">
      <?php
         $grand_total = 0;
         $select_cart =$mysqli->query( "SELECT * FROM `cart` NATURAL JOIN `products`  WHERE user_id = '$user_id'") or die('query failed');
         if($select_cart->num_rows > 0){
            while($fetch_cart = $select_cart->fetch_assoc()){   
      ?>
      <div class="box">
         <a href="cart.php?product_id=<?php echo $fetch_cart['product_id']; ?>" class="fas fa-times" onclick="return confirm('supprimer ceci du panier ?');"></a>
         <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_cart['product_name']; ?></div>
         <div class="price"><?php echo $fetch_cart['price']; ?>$</div>
         <form action="" method="post">
            <input type="hidden" name="product_id" value="<?php echo $fetch_cart['product_id']; ?>">
            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" name="update_cart" value="modifier" class="option-btn">
         </form>
         <?php  $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">Votre panier est vide</p>';
      }
      ?>
   </div>


   <div class="cart-total">
      <p>prix total : <span>$<?php echo $grand_total; ?></span></p>
      <div class="flex">
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">passer au paiement</a>
      </div>
   </div>

</section>








<?php include 'footer.php'; ?>

</body>
</html>