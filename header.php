<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">Produit<span>Digitale</span></a>

         <nav class="navbar">
            <a href="home.php">Accueil</a>
            <a href="about.php">A propos de nous</a>
            <a href="shop.php">Produits</a>
            <a href="contact.php">Contact</a>
            <a href="orders.php">Commandes</a>
         </nav>

         <div class="icons">
            <?php
               $select_cart_number = $mysqli->query("SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = $select_cart_number->num_rows; 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>
         <div> <a href="logout.php" class="delete-btn">Se déconnecter</a></div>
         
      </div>
   </div>

</header>