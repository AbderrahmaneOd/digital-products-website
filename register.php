<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = $mysqli->real_escape_string( $_POST['name'] );
   $email = $mysqli->real_escape_string( $_POST['email'] );
   $tel = $mysqli->real_escape_string( $_POST['tel'] );
   $pass = $mysqli->real_escape_string( md5($_POST['password']) );
   $cpass = $mysqli->real_escape_string( md5($_POST['cpassword']) );
   $user_type = $_POST['user_type'];

   $select_users = $mysqli->query( "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass' ") or die('query failed');

   if($select_users->num_rows > 0){
      $message[] = 'utilisateur existe déjà!';
   }else{
      if($pass != $cpass){
         $message[] = 'veuillez confirmer votre mot de passe.';
      }else{
         $mysqli->query( "INSERT INTO `users`(user_name, email, telephone, password, user_type) VALUES('$name', '$email', '$tel', '$cpass', '$user_type') ") or die('query failed');
         $message[] = 'compte crée avec succès!';
         header('location:login.php');
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>S'inscrire</title>

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

   <form method="post">
      <h3>S'inscrire maintenant</h3>
      <input type="text" name="name" placeholder="entrez votre nom" required class="box">
      <input type="email" name="email" placeholder="entrez votre email" required class="box">
      <input type="tel" name="tel" placeholder="entrez votre numero de téléphone" required class="box">      
      <input type="password" name="password" placeholder="entrez votre mot de passe" required class="box">
      <input type="password" name="cpassword" placeholder="confirmez votre mot de passe" required class="box">
      <select name="user_type" class="box">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select>
      <input type="submit" name="submit" value="S'inscrire" class="btn">
      <p>Vous avez déjà un compte? <a href="login.php">Connectez-vous</a></p>
   </form>

</div>

</body>
</html>