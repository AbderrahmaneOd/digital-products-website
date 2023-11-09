<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = $mysqli->real_escape_string( $_POST['email'] );
   $pass = $mysqli->real_escape_string( md5($_POST['password']) );

   $select_users = $mysqli->query("SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if($select_users->num_rows > 0){
      
      $row = $select_users->fetch_assoc();

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['user_id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['user_name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_tel'] = $row['telephone'];
         $_SESSION['user_id'] = $row['user_id'];
         header('location:home.php');

      }

   }else{
      $message[] = 'email ou mot de passe incorrect!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Se connecter</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

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
   
<div class="form-container">

   <form action="" method="post">
      <h3>connectez-vous</h3>
      <input type="email" name="email" placeholder="entrez votre email" required class="box">
      <input type="password" name="password" placeholder="entrez votre mot de passe" required class="box">
      <input type="submit" name="submit" value="se connecter" class="btn">
      <p>Vous n'avez pas de compte?  <a href="register.php">S'inscrire maintenant</a></p>
   </form>

</div>

</body>
</html>