<?php session_start();
$title = 'Tableau de bord : Aperçu général';
$currentPage = 'dashboard';
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/head.php');
?>

<body>
   <?php
   // Check if the user is logged in, if not then redirect him to login page
   if (!isset($_SESSION['login'])) {
      echo "<script type='text/javascript'>document.location.replace('/login.php');</script>";
   } else {
      require_once(__ROOT__ . '/navbar.php');
   }

   // DB connection
   $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
   ?>
   <div class="grid-cols-2 gap-4">
   <div class="ml-80 mr-80 mt-2 px-6 py-6 lg:px-8">
      <h3 class="text-xl font-medium text-gray-900">Effectuer une recherche</h3>
      <h2 class="text-s font-medium text-gray-900 mb-4">Sélectionnez une table</h2>


      <div id="accordion-color" data-accordion="collapse" data-active-classes="bg-blue-100 text-blue-600">
      <h2 id="accordion-color-heading-1"> <!-- CLIENTS -->
            <button type="button"
               class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 hover:bg-blue-100"
               data-accordion-target="#accordion-color-body-1" aria-expanded="false"
               aria-controls="accordion-color-body-1">
               <span>Clients</span>
               <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                     clip-rule="evenodd"></path>
               </svg>
            </button>
         </h2>
         <div id="accordion-color-body-1" class="hidden" aria-labelledby="accordion-color-heading-1">
            <div class="p-5 border border-b-0 border-gray-200">
               <form method="post" action="#">
                  <input type="hidden" name="action" value="clients">
                  <label for="id" class="block mb-2 text-sm font-medium text-gray-900">ID</label>
                  <input type="number" name="id" placeholder="ID" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">Prénom</label>
                        <input type="text" name="first_name" placeholder="Prénom"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Nom</label>
                        <input type="text" name="last_name" placeholder="Nom"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Adresse e-mail</label>
                        <input type="text" name="email" placeholder="Adresse e-mail"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="phone_nb" class="block mb-2 text-sm font-medium text-gray-900">Numéro de
                           téléphone</label>
                        <input type="text" name="phone_nb" placeholder="Numéro de téléphone"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <button type="submit"
                     class="w-full text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Chercher</button>
               </form>
            </div>
         </div>
         <h2 id="accordion-color-heading-2"> <!-- EMPLOYEES -->
            <button type="button"
               class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 hover:bg-blue-100"
               data-accordion-target="#accordion-color-body-2" aria-expanded="false"
               aria-controls="accordion-color-body-2">
               <span>Employés</span>
               <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                     clip-rule="evenodd"></path>
               </svg>
            </button>
         </h2>
         <div id="accordion-color-body-2" class="hidden" aria-labelledby="accordion-color-heading-2">
            <div class="p-5 border border-b-0 border-gray-200">
               <form method="post" action="#">
                  <input type="hidden" name="action" value="employees">
                  <label for="id" class="block mb-2 text-sm font-medium text-gray-900">ID</label>
                  <input type="number" name="id" placeholder="ID" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">Prénom</label>
                        <input type="text" name="first_name" placeholder="Prénom"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Nom</label>
                        <input type="text" name="last_name" placeholder="Nom"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <button type="submit"
                     class="w-full text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Chercher</button>
               </form>
            </div>
         </div>
         <h2 id="accordion-color-heading-3"> <!-- LOCATIONS -->
            <button type="button"
               class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-blue-200 hover:bg-blue-100"
               data-accordion-target="#accordion-color-body-3" aria-expanded="false"
               aria-controls="accordion-color-body-3">
               <span>Lieux</span>
               <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                     clip-rule="evenodd"></path>
               </svg>
            </button>
         </h2>
         <div id="accordion-color-body-3" class="hidden" aria-labelledby="accordion-color-heading-3">
            <div class="p-5 border border-t-0 border-gray-200">
               <form method="post" action="#">
                  <input type="hidden" name="action" value="locations">
                  <label for="id" class="block mb-2 text-sm font-medium text-gray-900">ID</label>
                  <input type="number" name="id" placeholder="ID" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="street" class="block mb-2 text-sm font-medium text-gray-900">Rue</label>
                  <input type="text" name="street" placeholder="Rue" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="city" class="block mb-2 text-sm font-medium text-gray-900">Ville</label>
                        <input type="text" name="city" placeholder="Ville"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="zip" class="block mb-2 text-sm font-medium text-gray-900">Code postal</label>
                        <input type="text" name="zip" placeholder="Code postal"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <label for="country" class="block mb-2 text-sm font-medium text-gray-900">Pays</label>
                  <input type="text" name="country" placeholder="Pays" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="comment" class="block mb-2 text-sm font-medium text-gray-900"> Commentaire</label>
                  <input type="text" name="comment" placeholder="Commentaire"
                     class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <button type="submit"
                     class="w-full text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Chercher</button>
               </form>
            </div>
         </div>
         <h2 id="accordion-color-heading-4"> <!-- EVENTS -->
            <button type="button"
               class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-blue-200 hover:bg-blue-100"
               data-accordion-target="#accordion-color-body-4" aria-expanded="false"
               aria-controls="accordion-color-body-4">
               <span>Événements</span>
               <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                     clip-rule="evenodd"></path>
               </svg>
            </button>
         </h2>
         <div id="accordion-color-body-4" class="hidden" aria-labelledby="accordion-color-heading-4">
            <div class="p-5 border border-t-0 border-gray-200">
               <form method="post" action="#">
                  <input type="hidden" name="action" value="locations">
                  <label for="id" class="block mb-2 text-sm font-medium text-gray-900">ID</label>
                  <input type="number" name="id" placeholder="ID" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nom</label>
                  <input type="text" name="name" placeholder="Nom" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <div class="block">
                     <div class="absolute inset-y-0 left-0 flex items-center pl-3 mt-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                     </div>
                     <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                     <input datepicker datepicker-autohide datepicker-format="yyyy/mm/dd" type="date" name="date" class="w-full px-4 py-2 mb-4 border rounded-lg pl-10" placeholder="Date">
                  </div>
                  <div class="flex flex-wrap space-x-8">
                     <div class="basis-72">
                        <label for="client_id" class="block mb-2 text-sm font-medium text-gray-900">Client ID</label>
                        <select id="playlist" class="appearance-none border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                           <?php
                           // Get all client name and id column
                           $clients = $bdd->query('SELECT CLIENT_NUMBER, FIRST_NAME, LAST_NAME FROM client');
                           foreach ($clients as $client) {
                              echo "<option value='".$client['CLIENT_NUMBER']."'>".$client['FIRST_NAME']." ".$client['LAST_NAME']."</option>";
                           }
                           ?>
                        </select>
                     </div>
                     <div class="basis-72">
                        <label for="manager_id" class="block mb-2 text-sm font-medium text-gray-900">Manager ID</label>
                        <input type="number" name="id" placeholder="ID" class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div>
                        <label for="ep_id" class="block mb-2 text-sm font-medium text-gray-900">Event Planner ID</label>
                        <input type="number" name="ep_id" placeholder="ID" class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div>
                        <label for="dj_id" class="block mb-2 text-sm font-medium text-gray-900">DJ ID</label>
                        <input type="number" name="dj_id" placeholder="ID" class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div>
                        <label for="location_id" class="block mb-2 text-sm font-medium text-gray-900">Location ID</label>
                        <input type="number" name="location_id" placeholder="ID" class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <div class="basis-1/2">
                     <label for="desc" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                     <input type="text" name="desc" placeholder="Description"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                  </div>
                  <div class="flex space-x-8">
                     <div class="basis-4/12">
                        <label for="theme" class="block mb-2 text-sm font-medium text-gray-900">Thème</label>
                        <select id="theme" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                           <?php
                              // Get all theme name column
                              $theme_names = $bdd->query('SELECT * FROM theme');
                              foreach ($theme_names as $theme) {
                                 echo "<option value='".$theme['NAME']."'>".$theme['NAME']."</option>";
                              }
                           ?>
                        </select>
                     </div>
                     <div class="basis-4/12">
                        <label for="playlist" class="block mb-2 text-sm font-medium text-gray-900"> Playlist</label>
                        <select id="playlist" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                           <?php
                           // Get all playlist name column
                           $playlists_names = $bdd->query('SELECT * FROM playlist');
                           foreach ($playlists_names as $playlist) {
                              echo "<option value='".$playlist['NAME']."'>".$playlist['NAME']."</option>";
                           }
                           ?>
                        </select>
                     </div>
                     <div class="basis-4/12">
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Type</label>
                        <input type="text" name="Type" placeholder="type"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <label for="fees" class="block mb-2 text-sm font-medium text-gray-900">Frais de location</label>
                  <input type="number" name="fees" placeholder="Frais de location" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <button type="submit"
                     class="w-full text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Chercher</button>
               </form>
            </div>
         </div>
         <h2 id="accordion-color-heading-5"> <!-- SONGS -->
            <button type="button"
               class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-blue-200 hover:bg-blue-100"
               data-accordion-target="#accordion-color-body-5" aria-expanded="false"
               aria-controls="accordion-color-body-5">
               <span>Chansons</span>
               <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                     clip-rule="evenodd"></path>
               </svg>
            </button>
         </h2>
         <div id="accordion-color-body-5" class="hidden" aria-labelledby="accordion-color-heading-5">
            <div class="p-5 border border-t-0 border-gray-200">
               <form method="post" action="#">
                  <input type="hidden" name="action" value="song">
                  <label for="cd_number" class="block mb-2 text-sm font-medium text-gray-900">Numéro de CD</label>
                  <input type="number" name="cd_number" placeholder="Numéro de CD" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="track_number" class="block mb-2 text-sm font-medium text-gray-900">Numéro de piste</label>
                  <input type="number" name="track_number" placeholder="Numéro de piste" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Titre</label>
                  <input type="text" name="title" placeholder="Titre" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="artist" class="block mb-2 text-sm font-medium text-gray-900">Artiste</label>
                        <input type="text" name="artist" placeholder="Artiste"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="duration" class="block mb-2 text-sm font-medium text-gray-900">Durée</label>
                        <input type="text" name="duration" placeholder="00:00"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <label for="genre" class="block mb-2 text-sm font-medium text-gray-900">Genre</label>
                  <input type="text" name="genre" placeholder="Genre" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <button type="submit"
                     class="w-full text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Chercher</button>
               </form>
            </div>
         </div>
         <h2 id="accordion-color-heading-6"> <!-- CDs -->
            <button type="button"
               class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-blue-200 hover:bg-blue-100"
               data-accordion-target="#accordion-color-body-6" aria-expanded="false"
               aria-controls="accordion-color-body-6">
               <span>CDs</span>
               <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd"
                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                     clip-rule="evenodd"></path>
               </svg>
            </button>
         </h2>
         <div id="accordion-color-body-6" class="hidden" aria-labelledby="accordion-color-heading-6">
            <div class="p-5 border border-t-0 border-gray-200">
               <form method="post" action="#">
                  <input type="hidden" name="action" value="locations">
                  <label for="id" class="block mb-2 text-sm font-medium text-gray-900">ID</label>
                  <input type="number" name="id" placeholder="ID" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="street" class="block mb-2 text-sm font-medium text-gray-900">Rue</label>
                  <input type="text" name="street" placeholder="Rue" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="city" class="block mb-2 text-sm font-medium text-gray-900">Ville</label>
                        <input type="text" name="city" placeholder="Ville"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="zip" class="block mb-2 text-sm font-medium text-gray-900">Code postal</label>
                        <input type="text" name="zip" placeholder="Code postal"
                           class="w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <label for="country" class="block mb-2 text-sm font-medium text-gray-900">Pays</label>
                  <input type="text" name="country" placeholder="Pays" class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="comment" class="block mb-2 text-sm font-medium text-gray-900"> Commentaire</label>
                  <input type="text" name="comment" placeholder="Commentaire"
                     class="w-full px-4 py-2 mb-4 border rounded-lg">
                  <button type="submit"
                     class="w-full text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Chercher</button>
               </form>
            </div>
         </div>
      </div>

      <?php
      if (isset($_POST['action'])) {
         echo '<h3 class="text-xl mt-4 font-medium text-gray-900 mb-4">Résultats de la recherche</h3>';
         switch ($_POST['action']) {
            case 'clients':
               $sql = "SELECT * FROM client WHERE FIRST_NAME LIKE :fname OR LAST_NAME LIKE :lname OR CLIENT_NUMBER = :id OR EMAIL_ADDRESS LIKE :email OR PHONE_NUMBER LIKE :phone";
               $query = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
               empty($_POST['first_name']) ? $fname = NULL : $fname = "%" . $_POST['first_name'] . "%";
               empty($_POST['last_name']) ? $lname = NULL : $lname = "%" . $_POST['last_name'] . "%";
               empty($_POST['id']) ? $id = NULL : $id = $_POST['id'];
               empty($_POST['email']) ? $email = NULL : $email = "%" . $_POST['email'] . "%";
               empty($_POST['phone']) ? $phone = NULL : $phone = "%" . $_POST['phone'] . "%";
               if (
                  !$query->execute(
                     array(
                        'fname' => $fname,
                        'lname' => $lname,
                        'id' => $id,
                        'email' => $email,
                        'phone' => $phone
                     )
                  )
               ) {
                  echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                  <p class='font-bold'>Erreur</p>
                  <p>Une erreur est survenue. Veuillez vérifier votre entrée.</p>
                  <p>Ce message peut vous aider à résoudre votre erreur : [code " . $query->errorInfo()[0] . "] `" . $query->errorInfo()[2] . "´.</p>
               </div>";
               } else {
                  echo '<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
                  <table class="table-fixed w-full text-sm text-left text-gray-500">
                     <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                           <th scope="col" class="w-1/12 px-6 py-3">
                              ID
                           </th>
                           <th scope="col" class="w-1/12 px-6 py-3">
                              Prénom
                           </th>
                           <th scope="col" class="w-1/12 px-3 py-3">
                              Nom
                           </th>
                           <th scope="col" class="w-1/12 px-6 py-3">
                              Numéro de téléphone
                           </th>
                           <th scope="col" class="w-2/12 px-6 py-3">
                              Adresse e-mail
                           </th>
                        </tr>
                     </thead>
                     <tbody>';
                  $result = $query->fetch();
                  // Show lines
                  while ($result) {
                     echo "
                        <tr class='bg-white border-b hover:bg-gray-50'>
                           <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                              " . $result['CLIENT_NUMBER'] . "
                           </th>
                           <td class='px-6 py-4'>
                              " . $result['FIRST_NAME'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['LAST_NAME'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['PHONE_NUMBER'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['EMAIL_ADDRESS'] . "
                           </td>
                        </tr>";
                     $result = $query->fetch();
                  }
               }
               break;
            case 'employees':
               $sql = "SELECT * FROM employee WHERE FIRSTNAME LIKE :fname OR LASTNAME LIKE :lname OR ID = :id";
               $query = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
               empty($_POST['first_name']) ? $fname = NULL : $fname = "%" . $_POST['first_name'] . "%";
               empty($_POST['last_name']) ? $lname = NULL : $lname = "%" . $_POST['last_name'] . "%";
               empty($_POST['id']) ? $id = NULL : $id = $_POST['id'];
               if (
                  !$query->execute(
                     array(
                        'fname' => $fname,
                        'lname' => $lname,
                        'id' => $id
                     )
                  )
               ) {
                  echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                        <p class='font-bold'>Erreur</p>
                        <p>Une erreur est survenue. Veuillez vérifier votre entrée.</p>
                        <p>Ce message peut vous aider à résoudre votre erreur : [code " . $query->errorInfo()[0] . "] `" . $query->errorInfo()[2] . "´.</p>
                        </div>";
               } else {
                  echo '<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
                           <table class="table-fixed w-full text-sm text-left text-gray-500">
                              <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                 <tr>
                                    <th scope="col" class="w-1/12 px-6 py-3">
                                       ID
                                    </th>
                                    <th scope="col" class="w-1/12 px-6 py-3">
                                       Prénom
                                    </th>
                                    <th scope="col" class="w-1/12 px-3 py-3">
                                       Nom
                                    </th>
                                 </tr>
                              </thead>
                              <tbody>';
                  $result = $query->fetch();
                  // Show lines
                  while ($result) {
                     echo "
                        <tr class='bg-white border-b hover:bg-gray-50'>
                           <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                              " . $result['ID'] . "
                           </th>
                           <td class='px-6 py-4'>
                              " . $result['FIRSTNAME'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['LASTNAME'] . "
                           </td>
                        </tr>";
                     $result = $query->fetch();
                  }
               }
               break;
            case 'locations':
               $sql = "SELECT * FROM location WHERE ID = :id OR STREET LIKE :street OR CITY LIKE :city OR POSTAL_CODE LIKE :zip OR COUNTRY LIKE :country OR COMMENT LIKE :comment";
               $query = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
               empty($_POST['id']) ? $id = NULL : $id = $_POST['id'];
               empty($_POST['street']) ? $street = NULL : $street = "%" . $_POST['street'] . "%";
               empty($_POST['city']) ? $city = NULL : $city = "%" . $_POST['city'] . "%";
               empty($_POST['zip']) ? $zip = NULL : $zip = "%" . $_POST['zip'] . "%";
               empty($_POST['country']) ? $country = NULL : $country = "%" . $_POST['country'] . "%";
               empty($_POST['comment']) ? $comment = NULL : $comment = "%" . $_POST['comment'] . "%";

               if (
                  !$query->execute(
                     array(
                        'id' => $id,
                        'street' => $street,
                        'city' => $city,
                        'zip' => $zip,
                        'country' => $country,
                        'comment' => $comment
                     )
                  )
               ) {
                  echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                        <p class='font-bold'>Erreur</p>
                        <p>Une erreur est survenue. Veuillez vérifier votre entrée.</p>
                        <p>Ce message peut vous aider à résoudre votre erreur : [code " . $query->errorInfo()[0] . "] `" . $query->errorInfo()[2] . "´.</p>
                        </div>";
               } else {
                  echo '<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
                           <table class="table-fixed w-full text-sm text-left text-gray-500">
                              <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                 <tr>
                                    <th scope="col" class="w-1/12 px-6 py-3">
                                       ID
                                    </th>
                                    <th scope="col" class="w-1/12 px-6 py-3">
                                       Rue
                                    </th>
                                    <th scope="col" class="w-1/12 px-3 py-3">
                                       Ville
                                    </th>
                                    <th scope="col" class="w-1/12 px-6 py-3">
                                       Code postal
                                    </th>
                                    <th scope="col" class="w-2/12 px-6 py-3">
                                       Pays
                                    </th>
                                    <th scope="col" class="w-2/12 px-6 py-3">
                                       Commentaires
                                    </th>
                                 </tr>
                              </thead>
                              <tbody>';
                  $result = $query->fetch();
                  // Show lines
                  while ($result) {
                     echo "
                        <tr class='bg-white border-b hover:bg-gray-50'>
                           <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                              " . $result['ID'] . "
                           </th>
                           <td class='px-6 py-4'>
                              " . $result['STREET'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['CITY'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['POSTAL_CODE'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['COUNTRY'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['COMMENT'] . "
                           </td>
                        </tr>";
                     $result = $query->fetch();
                  }
               }
               break;
            case 'song':
               $ssql = "SELECT * FROM song WHERE CD_NUMBER = :cd_number OR TRACK_NUMBER = :track_number OR TITLE LIKE :title OR ARTIST LIKE :artist OR DURATION LIKE :duration OR GENRE LIKE :genre";
               $query = $bdd->prepare($ssql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
               empty($_POST['cd_number']) ? $cd_number = NULL : $cd_number = $_POST['cd_number'];
               empty($_POST['track_number']) ? $track_number = NULL : $track_number = $_POST['track_number'];
               empty($_POST['title']) ? $stitle = NULL : $stitle = "%" . $_POST['title'] . "%";
               empty($_POST['artist']) ? $artist = NULL : $artist = "%" . $_POST['artist'] . "%";
               empty($_POST['duration']) ? $duration = NULL : $duration = $_POST['duration'];
               empty($_POST['genre']) ? $genre = NULL : $genre = "%" . $_POST['genre'] . "%";
               if (
                  !$query->execute(
                     array(
                        'cd_number' => $cd_number,
                        'track_number' => $track_number,
                        'title' => $stitle,
                        'artist' => $artist,
                        'duration' => $duration,
                        'genre' => $genre
                     )
                  )
               ) {
                  echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                  <p class='font-bold'>Erreur</p>
                  <p>Une erreur est survenue. Veuillez vérifier votre entrée.</p>
                  <p>Ce message peut vous aider à résoudre votre erreur : [code " . $query->errorInfo()[0] . "] `" . $query->errorInfo()[2] . "´.</p>
               </div>";
               } else {
                  echo '<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
                  <table class="table-fixed w-full text-sm text-left text-gray-500">
                     <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                           <th scope="col" class="w-1/12 px-6 py-3">
                              Numéro de CD
                           </th>
                           <th scope="col" class="w-1/12 px-6 py-3">
                              Numéro de piste
                           </th>
                           <th scope="col" class="w-1/12 px-3 py-3">
                              Titre
                           </th>
                           <th scope="col" class="w-1/12 px-6 py-3">
                              Artiste
                           </th>
                           <th scope="col" class="w-2/12 px-6 py-3">
                              Durée
                           </th>
                           <th scope="col" class="w-2/12 px-6 py-3">
                              Genre
                           </th>
                        </tr>
                     </thead>
                     <tbody>';
                  $result = $query->fetch();
                  // Show lines
                  while ($result) {
                     echo "
                        <tr class='bg-white border-b hover:bg-gray-50'>
                           <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                              " . $result['CD_NUMBER'] . "
                           </th>
                           <td class='px-6 py-4'>
                              " . $result['TRACK_NUMBER'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['TITLE'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['ARTIST'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['DURATION'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['GENRE'] . "
                           </td>
                        </tr>";
                     $result = $query->fetch();
                  }
               }
               break;
            default:
               break;
         }
      }
      ?>
      </tbody>
      </table>
   </div>


   <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/datepicker.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
   <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>