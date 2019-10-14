<?php 
session_start();
  if (!isset($_SESSION['user'])) {
    header('Location: ../EspaceSecretaire.php'); 
    die;
  }  
session_destroy();
header('Location: ../EspaceSecretaire.php');
?>