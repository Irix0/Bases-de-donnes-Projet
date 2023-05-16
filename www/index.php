<?php 
session_start();
$title = 'A propos';
$currentPage = 'index';
require_once('head.php'); 
?>

<link rel="stylesheet" href="index.css">

<body>
   <?php
         include('navbar.php');
   ?>

   <div class="container mx-auto my-6 p-6 bg-gray-100">
      <h1 class="text-3xl font-bold mb-6">Bienvenue chez WeND(Y)'s</h1>
      <p>Nous sommes votre entreprise d'organisation de fêtes et d'événements préférée, dirigée par des milléniaux pour
         des milléniaux, avec une passion pour la musique douteuse et les CD obscurs.</p>
      <p>Nous avons commencé comme une petite entreprise, mais grâce à notre dévouement envers nos clients et à notre
         engagement envers la qualité, notre entreprise a connu une croissance rapide et continue d'attirer de nouveaux
         clients fidèles.</p>
      <p>Pour offrir le meilleur service possible à nos clients, nous* avons développé un système de gestion de fêtes
         sophistiqué, conçu pour garantir que chaque événement est planifié et exécuté sans accroc. Avec notre système,
         nous pouvons suivre les événements, les DJ, les organisateurs d'événements, les clients et leurs événements de
         manière efficace et organisée.</p>
      <p>Notre nom, WeND(Y)'s, signifie "We’re not dead (yet)", reflétant notre engagement à célébrer la vie et à offrir
         des événements qui ne manqueront pas de faire bouger les foules. Que vous cherchiez à organiser une fête intime
         ou un événement d'entreprise majeur, nous avons l'expertise et les compétences pour faire de votre événement un
         succès.</p>
      <p>Merci d'avoir choisi WeND(Y)'s pour votre prochain événement. Nous sommes impatients de travailler avec vous pour
         créer des souvenirs inoubliables.</p>
   </div>

   <div style="text-align: center; font-size: 12px;">
      <p>*Merci aux goats Nashroudi Roxane, Phemba Morgan et Robert Louan</p>
   </div>
</body>