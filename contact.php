<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $email = $_POST['email'];
   $subject = $_POST['subject'];
   $msg = $_POST['message'];

   $email_subject = 'Nouvelle soumission de formulaire (Contactez-nous)';
   $email_to = 'abdoouaday361@gmail.com';

   $email_body = "ID de l'utilisateur : ".$_SESSION['user_id']."\n";
   $email_body .= "E-mail : $email\n";
   $email_body .= "Nom : $name\n";
   $email_body .= "Sujet : $subject\n";
   $email_body .= "Message : $msg\n";

   mail($email_to, $email_subject, $email_body);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>contactez-nous</h3>
   <p> <a href="home.php">accueil</a> / contact </p>
</div>

<section class="contact">

   <form method="post">
      <h3>veuillez remplir<br>le formulaire</h3>
      <input type="text" name="name" required placeholder="entrez votre nom" class="box">
      <input type="email" name="email" required placeholder="entrez votre email" class="box">
      <input type="text" name="subject" required placeholder="entrez le sujet" class="box">
      <textarea name="message" class="box" required placeholder="entrez votre message" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="envoyer le message" name="send" class="btn">
   </form>

</section>





<?php include 'footer.php'; ?>


</body>
</html>