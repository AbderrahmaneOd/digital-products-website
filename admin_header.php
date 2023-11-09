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

   <div class="flex">

      <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="admin_page.php">Accueil</a>
         <a href="admin_products.php">Produits</a>
         <a href="admin_orders.php">Commandes</a>
         <a href="admin_users.php">Utilisateurs</a>
      </nav>

      <div class="icons">
      </div>
      <div> <a href="logout.php" class="delete-btn">Se déconnecter</a></div>

   </div>

</header>