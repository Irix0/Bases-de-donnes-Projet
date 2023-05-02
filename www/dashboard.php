<?php session_start(); ?>
<?php $title = 'Tableau de bord'; ?>
<?php $currentPage = 'dashboard'; ?>
<?php require_once('head.php'); ?>

<body>
   <?php
      // Check if the user is logged in, if not then redirect him to login page
      if(!isset($_SESSION['login'])) {
         echo "<script type='text/javascript'>document.location.replace('login.php');</script>";
      } else {
         require_once('navbar.php');
      }
   ?>
</body>