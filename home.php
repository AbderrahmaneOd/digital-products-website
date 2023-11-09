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
   <title>Accueil</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Jeux PC, logiciels, clé...</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quod? Reiciendis ut porro iste totam.</p>
      <a href="about.php" class="white-btn">découvrir plus</a>
   </div>

</section>

<section class="products">

   <h1 class="title">Derniers produits</h1>

   <div class="box-container">

      <?php  
         $select_products = $mysqli->query("SELECT * FROM `products` LIMIT 6") or die('query failed');
         if($select_products->num_rows > 0){
            while($fetch_products = $select_products->fetch_assoc()){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['product_name']; ?></div>
      <div class="price">$<?php echo $fetch_products['price']; ?></div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_id" value="<?php echo $fetch_products['product_id']; ?>">
      <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">aucun produit n\'est ajouté pour le moment !</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">charger plus</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>À propos de nous</h3>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
         <a href="about.php" class="btn">Lire la suite</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Avez-vous des questions?</h3>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p>
      <a href="contact.php" class="white-btn">Contactez-nous</a>
   </div>

</section>





<?php include 'footer.php'; ?>


</body>
</html>