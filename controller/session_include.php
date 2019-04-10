<?php
session_start();
if(isset($_GET['logout'])){
  session_destroy();
  header('Location:login.php');
}

if(!isset($_SESSION['data'])){
  header('Location:login.php');
}
?>
