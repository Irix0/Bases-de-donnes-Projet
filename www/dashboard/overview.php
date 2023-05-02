<?php session_start();
$title = 'Tableau de bord : Aperçu général';
$currentPage = 'dashboard'; 
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/head.php'); ?>
?>

<body>
   <?php
      // Check if the user is logged in, if not then redirect him to login page
      if(!isset($_SESSION['login'])) {
         echo "<script type='text/javascript'>document.location.replace('/login.php');</script>";
      } else {
         require_once(__ROOT__.'/navbar.php');
      }
   ?>
</body>