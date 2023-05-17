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
                  <input type="number" name="id" placeholder="ID" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">Prénom</label>
                        <input type="text" name="first_name" placeholder="Prénom"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Nom</label>
                        <input type="text" name="last_name" placeholder="Nom"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Adresse e-mail</label>
                        <input type="text" name="email" placeholder="Adresse e-mail"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="phone_nb" class="block mb-2 text-sm font-medium text-gray-900">Numéro de
                           téléphone</label>
                        <input type="text" name="phone_nb" placeholder="Numéro de téléphone"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
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
                  <input type="number" name="id" placeholder="ID" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">Prénom</label>
                        <input type="text" name="first_name" placeholder="Prénom"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Nom</label>
                        <input type="text" name="last_name" placeholder="Nom"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
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
                  <input type="number" name="id" placeholder="ID" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="street" class="block mb-2 text-sm font-medium text-gray-900">Rue</label>
                  <input type="text" name="street" placeholder="Rue" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="city" class="block mb-2 text-sm font-medium text-gray-900">Ville</label>
                        <input type="text" name="city" placeholder="Ville"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="zip" class="block mb-2 text-sm font-medium text-gray-900">Code postal</label>
                        <input type="text" name="zip" placeholder="Code postal"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <label for="country" class="block mb-2 text-sm font-medium text-gray-900">Pays</label>
                  <input type="text" name="country" placeholder="Pays" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="comment" class="block mb-2 text-sm font-medium text-gray-900"> Commentaire</label>
                  <input type="text" name="comment" placeholder="Commentaire"
                     class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
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
                  <input type="hidden" name="action" value="events">
                  <div class="flex space-x-8">
                     <div class="basis-4/12">
                        <label for="id" class="block mb-2 text-sm font-medium text-gray-900">ID</label>
                        <input type="number" name="id" placeholder="ID" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-4/12">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nom</label>
                        <input type="text" name="name" placeholder="Nom" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-4/12">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                        <input type="date" name="date" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg pl-10" placeholder="Date">
                     </div>
                  </div>
                  <div class="flex space-x-8">
                     <div class="basis-4/12">
                        <label for="client" class="block mb-2 text-sm font-medium text-gray-900">Client</label>
                        <input type="text" name="client" placeholder="Nom du Client"
                           class="bg-gray-50 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                     </div>
                     <div class="basis-4/12">
                        <label for="manager" class="block mb-2 text-sm font-medium text-gray-900">Manager</label>
                        <input type="text" name="manager" placeholder="Nom du Manager"
                           class="bg-gray-50 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                     </div>
                     <div class="basis-4/12">
                        <label for="ep" class="block mb-2 text-sm font-medium text-gray-900">Plannificateur d'événements</label>
                        <input type="text" name="ep" placeholder="Nom du PE" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <div class="flex space-x-8">
                     <div class="basis-4/12">
                        <label for="dj" class="block mb-2 text-sm font-medium text-gray-900">DJ</label>
                        <input type="text" name="dj" placeholder="Nom du DJ" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-4/12">
                        <label for="location_id" class="block mb-2 text-sm font-medium text-gray-900">Lieu</label>
                        <input type="number" name="location_id" placeholder="ID du Lieu" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-4/12">
                        <label for="fees" class="block mb-2 text-sm font-medium text-gray-900">Frais de location</label>
                        <input type="number" name="fees" placeholder="Frais de location" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <div class="flex space-x-8">
                     <div class="basis-4/12">
                        <label for="theme" class="block mb-2 text-sm font-medium text-gray-900">Thème</label>
                        <select id="theme" name="theme" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="null" selected>Sélectionnez une option</option>
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
                        <select id="playlist" name="playlist" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                           <option value="null" selected>Sélectionnez une option</option>
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
                        <input type="text" name="yype" placeholder="Type"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <label for="desc" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                  <input type="text" name="desc" placeholder="Description"
                        class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
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
                  <input type="number" name="cd_number" placeholder="Numéro de CD" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="track_number" class="block mb-2 text-sm font-medium text-gray-900">Numéro de piste</label>
                  <input type="number" name="track_number" placeholder="Numéro de piste" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Titre</label>
                  <input type="text" name="title" placeholder="Titre" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="artist" class="block mb-2 text-sm font-medium text-gray-900">Artiste</label>
                        <input type="text" name="artist" placeholder="Artiste"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="duration" class="block mb-2 text-sm font-medium text-gray-900">Durée</label>
                        <input type="text" name="duration" placeholder="00:00:00"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <label for="genre" class="block mb-2 text-sm font-medium text-gray-900">Genre</label>
                  <input type="text" name="genre" placeholder="Genre" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
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
                  <input type="hidden" name="action" value="cd">
                  <label for="cd_number" class="block mb-2 text-sm font-medium text-gray-900">Numéro du CD</label>
                  <input type="number" name="cd_number" placeholder="Numéro du CD" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                  <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Titre</label>
                  <input type="text" name="title" placeholder="Titre" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                  <div class="flex space-x-8">
                     <div class="basis-1/2">
                        <label for="producer" class="block mb-2 text-sm font-medium text-gray-900">Producteur</label>
                        <input type="text" name="producer" placeholder="Producteur"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                     <div class="basis-1/2">
                        <label for="year" class="block mb-2 text-sm font-medium text-gray-900">Année de sortie</label>
                        <input type="number" name="year" placeholder="1999"
                           class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
                     </div>
                  </div>
                  <label for="copies" class="block mb-2 text-sm font-medium text-gray-900">Nombre de copies</label>
                  <input type="number" name="copies" placeholder="Nombre de copies" class="bg-gray-50 w-full px-4 py-2 mb-4 border rounded-lg">
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
         case 'events':
            $sql = "SELECT e.ID as ID, e.NAME as NAME, e.DATE as DATE, e.DESCRIPTION as DESCRIPTION, e.THEME as THEME, e.TYPE as TYPE, e.LOCATION as LOC, e.RENTAL_FEE as FEE, e.PLAYLIST as PLAYLIST, c.FIRST_NAME as cfname, c.LAST_NAME as clname, m.FIRSTNAME as mfname, m.LASTNAME as mlname, ep.FIRSTNAME as epfname, ep.LASTNAME as eplname, dj.FIRSTNAME as djfname, dj.LASTNAME as djlname
            FROM `event` e
            JOIN client c ON e.CLIENT = c.CLIENT_NUMBER
            JOIN employee m ON e.MANAGER = m.ID
            JOIN employee ep ON e.EVENT_PLANNER = ep.ID
            JOIN employee dj ON e.DJ = dj.ID
            WHERE 0 OR";
            $params = array();
            if(!empty($_POST['id'])){
               $sql .= " e.ID = :id AND";
               $params['id'] = $_POST['id'];
            }
            if(!empty($_POST['name'])){
               $sql .= " e.NAME LIKE :name AND";
               $params['name'] = "%" . $_POST['name'] . "%";
            }
            if(!empty($_POST['date'])){
               $sql .= " e.DATE = :date AND";
               $params['date'] = $_POST['date'];
            }
            if(!empty($_POST['client'])){
               $sql .= " e.CLIENT IN (SELECT CLIENT_NUMBER FROM client WHERE FIRST_NAME LIKE :cname OR LAST_NAME LIKE :cname) AND";
               $params['cname'] = "%" . $_POST['client'] . "%";
            }
            if(!empty($_POST['manager'])){
               $sql .= " e.MANAGER IN (SELECT ID FROM employee NATURAL JOIN manager WHERE FIRSTNAME LIKE :mname OR LASTNAME LIKE :mname) AND";
               $params['mname'] = "%" . $_POST['manager'] . "%";
            }
            if(!empty($_POST['ep'])){
               $sql .= " e.EVENT_PLANNER IN (SELECT ID FROM employee NATURAL JOIN event_planner WHERE FIRSTNAME LIKE :epname OR LASTNAME LIKE :epname) AND";
               $params['epname'] = "%" . $_POST['ep'] . "%";
            }
            if(!empty($_POST['dj'])){
               $sql .= " e.DJ IN (SELECT ID FROM employee NATURAL JOIN dj WHERE FIRSTNAME LIKE :djname OR LASTNAME LIKE :djname) AND";
               $params['djname'] = "%" . $_POST['dj'] . "%";
            }
            if(!empty($_POST['location_id'])){
               $sql .= " e.LOCATION = :location AND";
               $params['location'] = $_POST['location_id'];
            }
            if(!empty($_POST['fees'])){
               $sql .= " e.RENTAL_FEE = :fees AND";
               $params['fees'] = $_POST['fees'];
            }
            if(!empty($_POST['theme'] && $_POST['theme'] != 'null')){
               $sql .= " e.THEME LIKE :theme AND";
               $params['theme'] = "%" . $_POST['theme'] . "%";
            }
            if(!empty($_POST['playlist'] && $_POST['playlist'] != 'null')){
               $sql .= " e.PLAYLIST LIKE :playlist AND";
               $params['playlist'] = "%" . $_POST['playlist'] . "%";
            }
            if(!empty($_POST['type'])){
               $sql .= " e.TYPE LIKE :type AND";
               $params['type'] = "%" . $_POST['type'] . "%";
            }
            $sql .= " 1";
            $sql .= " ORDER BY e.ID ASC";
            echo $sql;
            // Print array
            echo "<pre>";
            print_r($params);
            echo "</pre>";

            $query = $bdd->prepare($sql);

            if (
               !$query->execute($params)
            ) {
               echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                     <p class='font-bold'>Erreur</p>
                     <p>Une erreur est survenue. Veuillez vérifier votre entrée.</p>
                     <p>Ce message peut vous aider à résoudre votre erreur : [code " . $query->errorInfo()[0] . "] `" . $query->errorInfo()[2] . "´.</p>
                     </div>";
            } else {
               echo '<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
                        <table class="table-auto w-full text-sm text-left text-gray-500">
                           <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                              <tr>
                                 <th scope="col" class="px-6 py-3">
                                    ID
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    Nom
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    Date
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    Description
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    Client
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    Manager
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    Plannificateur d\'événements
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    DJ
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    Thème
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    Type
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    Lieu
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    Frais de location
                                 </th>
                                 <th scope="col" class="px-6 py-3">
                                    Playlist
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
                           " . $result['NAME'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $result['DATE'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $result['DESCRIPTION'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $result['cfname'] . " " . $result['clname'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $result['mfname'] . " " . $result['mlname'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $result['epfname'] . " " . $result['eplname'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $result['djfname'] . " " . $result['djlname'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $result['THEME'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $result['TYPE'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $result['LOC'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $result['FEE'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $result['PLAYLIST'] . "
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
            case 'cd':
               $sql = "SELECT * FROM cd WHERE CD_NUMBER LIKE :cd_number OR TITLE LIKE :title OR PRODUCER LIKE :producer OR YEAR LIKE :year OR COPIES LIKE :copies";
               $query = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
               empty($_POST['cd_number']) ? $cd_number = NULL : $cd_number = $_POST['cd_number'];
               empty($_POST['title']) ? $title = NULL : $title = "%" . $_POST['title'] . "%";
               empty($_POST['producer']) ? $producer = NULL : $producer = "%" . $_POST['producer'] . "%";
               empty($_POST['year']) ? $year = NULL : $year = $_POST['year'];
               empty($_POST['copies']) ? $copies = NULL : $copies = $_POST['copies'];
               if (
                  !$query->execute(
                     array(
                        'cd_number' => $cd_number,
                        'title' => $title,
                        'producer' => $producer,
                        'year' => $year,
                        'copies' => $copies
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
                              Titre
                           </th>
                           <th scope="col" class="w-1/12 px-3 py-3">
                              Producteur
                           </th>
                           <th scope="col" class="w-1/12 px-6 py-3">
                              Année de sortie
                           </th>
                           <th scope="col" class="w-2/12 px-6 py-3">
                              Nombre de copies
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
                              " . $result['TITLE'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['PRODUCER'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['YEAR'] . "
                           </td>
                           <td class='px-6 py-4'>
                              " . $result['COPIES'] . "
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

   <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
   <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>