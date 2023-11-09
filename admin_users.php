<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $mysqli->query("DELETE FROM `orders` WHERE user_id = '$delete_id'") or die('query failed');
   $mysqli->query("DELETE FROM `cart` WHERE user_id = '$delete_id'") or die('query failed');
   $mysqli->query("DELETE FROM `users` WHERE user_id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>utilisateurs</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title">comptes utilisateurs</h1>

   <div class="box-container">
      <?php
         $select_users = $mysqli->query( "SELECT * FROM `users`") or die('query failed');
         while($fetch_users = $select_users->fetch_assoc()){
      ?>
      <div class="box">
         <p> user id : <span><?php echo $fetch_users['user_id']; ?></span> </p>
         <p> username : <span><?php echo $fetch_users['user_name']; ?></span> </p>
         <p> email : <span><?php echo $fetch_users['email']; ?></span> </p>
         <p> Téléphone : <span><?php echo $fetch_users['telephone']; ?></span> </p>
         <p> type d'utilisateur : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $fetch_users['user_id']; ?>" onclick="return confirm('Supprimer cet utilisateur ?');" class="delete-btn">supprimer</a>
      </div>
      <?php
         };
      ?>
   </div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>