<?php 
session_start();
$title = 'À propos';
$currentPage = 'index';
require_once('head.php'); 
?>

<link rel="stylesheet" href="index.css">

<body>
   <?php
         include('navbar.php');
   ?>

<div class="container mx-auto my-6 p-6 bg-gray-100">
      <h1 class="text-3xl font-bold mb-6">Bienvenue chez WeND(Y)</h1>
      <p>Nous sommes une entreprise d'organisation de fêtes et d'événements, dirigée par des milléniaux pour
         des milléniaux, avec une passion pour la musique douteuse et les CD obscurs.</p>
      <p>WeND(Y), signifie "We’re not dead (yet)".</p>
      <p>Merci d'avoir choisi WeND(Y) pour votre événement. Nous sommes impatients de vous créer des souvenirs inoubliables.</p>
   </div>
</body>