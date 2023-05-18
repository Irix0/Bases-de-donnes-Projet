<?php session_start();
$title = 'Tableau de bord : lieux';
$currentPage = 'dashboard'; 
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/head.php');
?>

<body>
   <?php
   if(!isset($_SESSION['login'])) {
      echo "<script type='text/javascript'>document.location.replace('/login.php');</script>";
   } else {
      require_once(__ROOT__.'/navbar.php');
   }

   $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
   $id = $_GET['id'];
   $req = $bdd->query('SELECT * FROM event WHERE ID = ' . $id);
   $row = $req->fetch();

   // We need some data to fill the dropdown lists
   $client_req = $bdd->query('SELECT * FROM client');
   $client_table = $client_req->fetchAll();
   $manager_req = $bdd->query('SELECT * FROM manager');
   $manager_table = $manager_req->fetchAll();
   $eventPlanner_req = $bdd->query('SELECT * FROM event_planner');
   $eventPlanner_table = $eventPlanner_req->fetchAll();
   $dj_req = $bdd->query('SELECT * FROM dj');
   $dj_table = $dj_req->fetchAll();
   $theme_req = $bdd->query('SELECT * FROM theme');
   $theme_table = $theme_req->fetchAll();
   $location_req = $bdd->query('SELECT * FROM location');
   $location_table = $location_req->fetchAll();
   $playlist_req = $bdd->query('SELECT * FROM playlist');
   $playlist_table = $playlist_req->fetchAll();
   // End of dropdown lists

   // We need a table with all the event to avoid conflicts
   $all_events_req = $bdd->query('SELECT * FROM event');
   $all_events_table = $all_events_req->fetchAll();
   // End of table

   if(empty($row)) {
      echo "<div class='ml-80 mr-80 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
      <p class='font-bold'>Erreur</p>
      <p>L'événement n'a pas été trouvé. (ID :" .$id . ")</p>
    </div>";
   } 
   ?>
<div class="ml-80 mr-80 mt-2 px-6 py-6 lg:px-8">
    <div class="flex content-center items-center">
        <div class="basis-1/12">
            <button onclick="document.location.replace('/dashboard/event.php')"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm px-3 py-5 inline-flex items-center">
                <i class="fa-solid fa-angle-left fa-2xl"></i>
                <span class="sr-only">Retour</span>
            </button>
        </div>
        <div class="basis-11/12 ml-2">
            <h3 class="text-xl font-medium text-gray-900">Détails de l'événement</h3>
        </div>
    </div>
    <div class="mt-3 space-y-6">
        <!-- Name -->
        <div>
            <h4 class="block mb-2 text-sm font-medium text-gray-900">Nom de l'événement:</h4>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"><?php echo $row['NAME']; ?></p>
        </div>
        <!-- Date -->
        <div>
            <h4 class="block mb-2 text-sm font-medium text-gray-900">Date de l'événement:</h4>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"><?php echo date('l j F Y', strtotime($row['DATE'])); ?></p>
        </div>
        <!-- Client -->
        <div>
            <h4 class="block mb-2 text-sm font-medium text-gray-900">Client:</h4>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <?php 
                foreach ($client_table as $client) {
                    if($client['CLIENT_NUMBER'] == $row['CLIENT']){
                    $client_name = $bdd->query('SELECT FIRST_NAME, LAST_NAME FROM client WHERE CLIENT_NUMBER = ' . $client['CLIENT_NUMBER']);
                    $client_name = $client_name->fetch();
                    echo $client_name['FIRST_NAME'] ." ". $client_name['LAST_NAME'];
                    }
                }
            ?>
        </div>
        <!-- Manager, Event planner, DJ -->
        <div class="flex space-x-4">
        <!-- Manager -->
        <div class="w-1/3">
            <label class="block mb-2 text-sm font-medium text-gray-900">Manager</label>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg px-2.5 py-1">
            <?php 
                foreach ($manager_table as $manager) {
                    if($manager['ID'] == $row['MANAGER']){
                    $manager_name = $bdd->query('SELECT FIRSTNAME, LASTNAME FROM employee WHERE ID = ' . $manager['ID']);
                    $manager_name = $manager_name->fetch();
                    echo $manager_name['FIRSTNAME'] ." ". $manager_name['LASTNAME'];
                    }
                }
            ?>
            </p>
        </div>
        <!-- Event planner -->
        <div class="w-1/3">
            <label class="block mb-2 text-sm font-medium text-gray-900">Planificateur d'événement</label>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg px-2.5 py-1">
            <?php 
                foreach ($eventPlanner_table as $eventPlanner) {
                    if($eventPlanner['ID'] == $row['EVENT_PLANNER']){
                    $eventPlanner_name = $bdd->query('SELECT FIRSTNAME, LASTNAME FROM employee WHERE ID = ' . $eventPlanner['ID']);
                    $eventPlanner_name = $eventPlanner_name->fetch();
                    echo $eventPlanner_name['FIRSTNAME'] ." ". $eventPlanner_name['LASTNAME'];
                    }
                }
            ?>
            </p>
        </div>
        <!-- DJ -->
        <div class="w-1/3">
            <label class="block mb-2 text-sm font-medium text-gray-900">DJ</label>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg px-2.5 py-1">
            <?php 
                foreach ($dj_table as $dj) {
                    if($dj['ID'] == $row['DJ']){
                    $dj_name = $bdd->query('SELECT FIRSTNAME, LASTNAME FROM employee WHERE ID = ' . $dj['ID']);
                    $dj_name = $dj_name->fetch();
                    echo $dj_name['FIRSTNAME'] ." ". $dj_name['LASTNAME'];
                    }
                }
            ?>
            </p>
        </div>
        </div>
        <!-- Theme, Playlist -->
        <div class="flex space-x-4">
        <!-- Theme -->
        <div class = "w-1/2">
            <h4 class="block mb-2 text-sm font-medium text-gray-900">Thème:</h4>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <?php 
                foreach ($theme_table as $theme) {
                    if($theme['NAME'] == $row['THEME']){
                    echo $theme['NAME'];
                    }
                }
            ?>
            </p>
        </div>
        <!-- Playlist -->
        <div class = "w-1/2">
            <h4 class="block mb-2 text-sm font-medium text-gray-900">Playlist:</h4>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <?php 
                foreach ($playlist_table as $playlist) {
                    if($playlist['NAME'] == $row['PLAYLIST']){
                    echo $playlist['NAME'];
                    }
                }
            ?>
            </p>
        </div>
        </div>
        <!-- Location -->
        <div>
            <h4 class="block mb-2 text-sm font-medium text-gray-900">Lieu:</h4>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <?php 
                foreach ($location_table as $location) {
                    if($location['ID'] == $row['LOCATION']){
                    echo $location['STREET'] .", ". $location['CITY'] ." ". $location['POSTAL_CODE'] ." ". $location['COUNTRY'];
                    }
                }
            ?>
            </p>
        </div>
        <!-- Type and Rental fee-->
        <div class="flex space-x-4">
        <!-- Type -->
        <div class = "w-1/2">
            <h4 class="block mb-2 text-sm font-medium text-gray-900">Type:</h4>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <?php 
                echo $row['TYPE'];
            ?>
            </p>
        </div>
        <!-- Rental fee -->
        <div class = "w-1/2">
            <h4 class="block mb-2 text-sm font-medium text-gray-900">Coût:</h4>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            <?php 
                echo $row['RENTAL_FEE'] ." €";
            ?>
            </p>
        </div>
        </div>
        <!-- Description -->
        <div>
            <h4 class="block mb-2 text-sm font-medium text-gray-900">Description de l'événement:</h4>
            <p class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"><?php echo $row['DESCRIPTION']; ?></p>
        </div>
        <!-- ID -->
        <div>
            <h4 class="block mb-2 text-sm font-medium text-gray-900">ID:</h4>
            <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"><?php echo $row['ID']; ?></p>
        </div>
    </div>
</div>


   <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>

</html>