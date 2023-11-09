<?php

$mysqli = new mysqli('localhost:3307','root', '','shop_db'); 

if($mysqli->connect_error){
    die('connection failed : ' . $mysqli->connect_error);
}

?>