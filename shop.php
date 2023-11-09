<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_id = $_POST['product_id'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = $mysqli->query("SELECT * FROM `cart` WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('query failed');

   if($check_cart_numbers->num_rows > 0){
      $message[] = 'produit est déjà ajouté au panier !';
   }else{
      $mysqli->query("INSERT INTO `cart`(user_id, product_id, quantity) VALUES('$user_id', '$product_id', '$product_quantity')") or die('query failed');
      $message[] = 'produit est ajouté au panier !';
   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>produits</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>notre produits</h3>
   <p> <a href="home.php">accueil</a> / produits </p>
</div>

<section class="products">

   <h1 class="title">derniers produits</h1>

   <div class="box-container">

      <?php  
         $select_products = $mysqli->query( "SELECT * FROM `products`") or die('query failed');
         if( $select_products->num_rows > 0){
            while($fetch_products = $select_products->fetch_assoc()){
      ?>
     <form method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>">
      <div class="name"><?php echo $fetch_products['product_name']; ?></div>
      <div class="price">$<?php echo $fetch_products['price']; ?></div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_id" value="<?php echo $fetch_products['product_id']; ?>">
      <input type="submit" value="ajouter au panier" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">aucun produit n\'est disponible pour le moment !</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

</body>
</html>