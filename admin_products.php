<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = $mysqli->real_escape_string($_POST['name']);
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = $mysqli->query("SELECT product_name FROM `products` WHERE product_name = '$name'") or die('query failed');

   if( $select_product_name->num_rows > 0){
      $message[] = 'nom du produit déjà ajouté';
   }else{
      $add_product_query = $mysqli->query( "INSERT INTO `products`(product_name, price, image) VALUES('$name', '$price', '$image')") or die('query failed');

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'la taille de l\'image est trop grande!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'le produit est ajouté avec succès !';
         }
      }else{
         $message[] = 'le produit n\'a pas pu être ajouté !';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = $mysqli->query( "SELECT image FROM `products` WHERE product_id = '$delete_id'") or die('query failed');
   $fetch_delete_image = $delete_image_query->fetch_assoc();
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   $mysqli->query( "DELETE FROM `products` WHERE product_id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
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

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product section starts  -->

<section class="add-products">

   <h1 class="title">Produits</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>ajouter un produit</h3>
      <input type="text" name="name" class="box" placeholder="entrez le nom du produit" required>
      <input type="number" min="0" name="price" class="box" placeholder="entrez le prix du produit" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="ajouter" name="add_product" class="btn">
   </form>

</section>

<!-- product section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = $mysqli->query( "SELECT * FROM `products`") or die('query failed');
         if( $select_products->num_rows > 0){
            while($fetch_products = $select_products->fetch_assoc()){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['product_name']; ?></div>
         <div class="price">$<?php echo $fetch_products['price']; ?></div>
         <a href="admin_products.php?delete=<?php echo $fetch_products['product_id']; ?>" class="delete-btn" onclick="return confirm('supprimer ce produit ?');">supprimer</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">aucun produit n\'est ajouté pour le moment !</p>';
      }
      ?>
   </div>

</section>






<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>