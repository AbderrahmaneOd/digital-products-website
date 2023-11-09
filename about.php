<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>A propos de nous</h3>
   <p> <a href="home.php">accueil</a> / à propos </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg">
      </div>

      <div class="content">
         <h3>Pourquoi nous ?</h3>
         <p>Lorem, ipsum dolor sit . Id quaerat quasi, velit laborum delectus possimus reiciendis? Ipsum, porro.<br><br>Dignissimos eveniet aperiam quo laborum repellat impedit quidem nostrum minima quibusdam, ex id beatae nesciunt et expedita, libero omnis, recusandae cum eligendi.</p>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima corporis ratione saepe sed adipisci?</p>
         <a href="contact.php" class="btn">contactez-nous</a>
      </div>

   </div>

</section>




<?php include 'footer.php'; ?>


</body>
</html>