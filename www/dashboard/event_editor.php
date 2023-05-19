<?php session_start();
$title = 'Tableau de bord : lieux';
$currentPage = 'dashboard';
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/head.php');
?>

<body>
   <?php
   if (!isset($_SESSION['login'])) {
      echo "<script type='text/javascript'>document.location.replace('/login.php');</script>";
      die("Please login first. If you see this the JavaScript script didn't redirect you properly. Try to enable JavaScript in your browser.");
   } else {
      require_once(__ROOT__ . '/navbar.php');
   }

   $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
   $id = $_GET['id'];
   $req = $bdd->query('SELECT * FROM event WHERE ID = ' . $id);
   $row = $req->fetch();

   // On vérifie que l'événement existe
   if (empty($row)) {
      echo "<div class='2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
      <p class='font-bold'>Erreur</p>
      <p>L'événement n'a pas été trouvé. (ID :" . $id . ")</p>
    </div>";
   } else {

      // On vérifie que l'événement n'est pas déjà passé
      $today = date("Y-m-d");
      if ($row['DATE'] < $today) {
         echo "<div class='2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
      <p class='font-bold'>Erreur</p>
      <p>L'événement est déjà passé. (ID :" . $id . ")</p>
    </div>";
      } else if ($row['DATE'] == $today) {
         echo "<div class='2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
      <p class='font-bold'>Erreur</p>
      <p>L'événement est aujourd'hui. Trop tard pour le modifier. (ID :" . $id . ")</p>
    </div>";
      } else {

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

         if (empty($row)) {
            echo "<div class='2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
      <p class='font-bold'>Erreur</p>
      <p>L'événement n'a pas été trouvé. (ID :" . $id . ")</p>
    </div>";
         } 
         else {
            if ($_POST['action'] == 'edit') {

               // We need to check if the manager supervises the event planner and the dj
               $supervised_employees_req = $bdd->query('SELECT EMPLOYEE_ID FROM supervision WHERE SUPERVISOR_ID = ' . $_POST['manager']);
               $supervised_employees = $supervised_employees_req->fetchAll();
               $supervised_employees_ids = array_column($supervised_employees, 'EMPLOYEE_ID');

               $manager_name_req = $bdd->query('SELECT FIRSTNAME, LASTNAME FROM employee WHERE ID = ' . $_POST['manager']);
               $manager_name = $manager_name_req->fetch();
               if(!in_array($_POST['eventPlanner'], $supervised_employees_ids) || !in_array($_POST['dj'], $supervised_employees_ids)){
                  echo "<div class='2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                  <p class='font-bold'>Erreur</p>
                  <p>Le manager " . $manager_name['FIRSTNAME'] . " " . $manager_name['LASTNAME'] . " ne peut superviser que les employés suivants : ";
                  foreach($supervised_employees as $employee){
                     $employee_name_req = $bdd->query('SELECT FIRSTNAME, LASTNAME FROM employee WHERE ID = ' . $employee['EMPLOYEE_ID']);
                     $employee_name = $employee_name_req->fetch();
                     // Si c'est le dernier employé de la liste, on ne met pas de virgule
                     if($employee == end($supervised_employees))
                        echo "et " . $employee_name['FIRSTNAME'] . " " . $employee_name['LASTNAME'] . ".";
                     else
                        echo $employee_name['FIRSTNAME'] . " " . $employee_name['LASTNAME'] . ", ";
                  }
                  echo "</p>
                  </div>";
               } else {

               $sql = "UPDATE event SET ID = :new_id, NAME = :new_name, DATE = :new_date, DESCRIPTION = :new_description, MANAGER = :new_manager, EVENT_PLANNER = :new_eventPlanner, DJ = :new_dj, THEME = :new_theme, TYPE = :new_type, LOCATION = :new_location, RENTAL_FEE = :new_rentalFee, PLAYLIST = :new_playlist WHERE ID = :id";
               $sth = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
               $res = $sth->execute(array(
                  ':new_id' => $_POST['id'],
                  ':new_name' => $_POST['name'],
                  ':new_date' => $_POST['date'],
                  ':new_description' => $_POST['description'],
                  ':new_manager' => $_POST['manager'],
                  ':new_eventPlanner' => $_POST['eventPlanner'],
                  ':new_dj' => $_POST['dj'],
                  ':new_theme' => $_POST['theme'],
                  ':new_type' => $_POST['type'],
                  ':new_location' => $_POST['location'],
                  ':new_rentalFee' => $_POST['rentalFee'],
                  ':new_playlist' => $_POST['playlist'],
                  ':id' => $id
               ));



               if ($_POST['id'] != $id && $res) {
                  $id = $_POST['id'];
                  echo "<script type='text/javascript'>document.location.replace('/dashboard/modify_event.php?id=" . $id . "');</script>";
               }

               if ($res) {
                  echo "<div class='2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 bg-green-100 border-l-4 border-green-500 text-green-700 p-4' role='alert'>
            <p class='font-bold'>Succès</p>
            <p>L'événement a été modifié.</p>
            </div>";
                  $req = $bdd->query('SELECT * FROM event WHERE ID = ' . $id);
                  $row = $req->fetch();
               } else {
                  echo "<div class='2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
            <p class='font-bold'>Erreur</p>
            <p>L'événement n'a pas pu être modifié.</p>
            <p>Référer vous à l'erreur suivante : [code " . $sth->errorInfo()[0] . "] `" . $sth->errorInfo()[2] . "´.</p>
            </div>";
               }
            }
            }
   ?>
            <div class="2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 mt-2 px-6 py-6 lg:px-8">
               <div class="flex content-center items-center">
                  <div class="basis-1/12">
                     <button onclick="document.location.replace('/dashboard/update_eventBoard.php')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm px-3 py-5 inline-flex items-center">
                        <i class="fa-solid fa-angle-left fa-2xl"></i>
                        <span class="sr-only">Retour</span>
                     </button>
                  </div>
                  <div class="basis-11/12 ml-2">
                     <h3 class="text-xl font-medium text-gray-900">Modifier un événement</h3>
                  </div>
               </div>
               <form id="form" method="post" class="mt-3 space-y-6" action="#">
                  <!-- Name -->
                  <div>
                     <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nom de l'événement*</label>
                     <input type="text" name="name" id="name" value="<?php echo $row['NAME']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                  </div>
                  <!-- Date -->
                  <div>
                     <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date de l'événement</label>
                     <input type="date" name="date" id="date" value="<?php echo $row['DATE']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" min="<?php echo date('Y-m-d'); ?>">
                  </div>
                  <!-- Client -->
                  <div>
                     <label for="client" class="block mb-2 text-sm font-medium text-gray-900">Client</label>
                     <?php
                     $client_name = $bdd->query('SELECT FIRST_NAME, LAST_NAME FROM client WHERE CLIENT_NUMBER = ' . $row['CLIENT']);
                     $client_name = $client_name->fetch();
                     ?>
                     <input type="text" name="client" id="client" value="<?php echo $client_name['FIRST_NAME'] . " " . $client_name['LAST_NAME']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" disabled>
                  </div>
                  <!-- Manager and Event planner and DJ-->
                  <div class="flex space-x-4">
                     <!-- Manager -->
                     <div class="w-1/3">
                        <label for="manager" class="block mb-2 text-sm font-medium text-gray-900">Manager*</label>
                        <select name="manager" id="manager" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                           <?php
                           foreach ($manager_table as $manager) {
                              if ($manager['ID'] == $row['MANAGER']) {
                                 $manager_name = $bdd->query('SELECT FIRSTNAME, LASTNAME FROM employee WHERE ID = ' . $manager['ID']);
                                 $manager_name = $manager_name->fetch();
                                 echo "<option value='" . $manager['ID'] . "' selected>" . $manager_name['FIRSTNAME'] . " " . $manager_name['LASTNAME'] . "</option>";
                              } else {
                                    $manager_name = $bdd->query('SELECT FIRSTNAME, LASTNAME FROM employee WHERE ID = ' . $manager['ID']);
                                    $manager_name = $manager_name->fetch();
                                    echo "<option value='" . $manager['ID'] . "'>" . $manager_name['FIRSTNAME'] . " " . $manager_name['LASTNAME'] . "</option>";
                              }
                           }
                           ?>
                        </select>
                     </div>
                     <!-- Event planner -->
                     <div class="w-1/3">
                        <label for="eventPlanner" class="block mb-2 text-sm font-medium text-gray-900">Planificateur d'événement*</label>
                        <select name="eventPlanner" id="eventPlanner" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                           <?php
                           foreach ($eventPlanner_table as $eventPlanner) {
                              if ($eventPlanner['ID'] == $row['EVENT_PLANNER']) {
                                 $eventPlanner_name = $bdd->query('SELECT FIRSTNAME, LASTNAME FROM employee WHERE ID = ' . $eventPlanner['ID']);
                                 $eventPlanner_name = $eventPlanner_name->fetch();
                                 echo "<option value='" . $eventPlanner['ID'] . "' selected>" . $eventPlanner_name['FIRSTNAME'] . " " . $eventPlanner_name['LASTNAME'] . "</option>";
                              } else {
                                 foreach ($all_events_table as $event) {
                                    if ($event['ID'] != $row['ID'] && $event['DATE'] == $row['DATE'] && $eventPlanner['ID'] == $event['EVENT_PLANNER']) {
                                       $eventPlanner['ID'] = -1;
                                    }
                                 }
                                 if ($eventPlanner['ID'] != -1) {
                                    $eventPlanner_name = $bdd->query('SELECT FIRSTNAME, LASTNAME FROM employee WHERE ID = ' . $eventPlanner['ID']);
                                    $eventPlanner_name = $eventPlanner_name->fetch();
                                    echo "<option value='" . $eventPlanner['ID'] . "'>" . $eventPlanner_name['FIRSTNAME'] . " " . $eventPlanner_name['LASTNAME'] . "</option>";
                                 }
                              }
                           }
                           ?>
                        </select>
                     </div>
                     <!-- DJ -->
                     <div class="w-1/3">
                        <label for="dj" class="block mb-2 text-sm font-medium text-gray-900">DJ*</label>
                        <select name="dj" id="dj" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                           <?php
                           foreach ($dj_table as $dj) {
                              if ($dj['ID'] == $row['DJ']) {
                                 $dj_name = $bdd->query('SELECT FIRSTNAME, LASTNAME FROM employee WHERE ID = ' . $dj['ID']);
                                 $dj_name = $dj_name->fetch();
                                 echo "<option value='" . $dj['ID'] . "' selected>" . $dj_name['FIRSTNAME'] . " " . $dj_name['LASTNAME'] . "</option>";
                              } else {
                                 foreach ($all_events_table as $event) {
                                    if ($event['ID'] != $row['ID'] && $event['DATE'] == $row['DATE'] && $dj['ID'] == $event['DJ']) {
                                       $dj['ID'] = -1;
                                    }
                                 }
                                 if ($dj['ID'] != -1) {
                                    $dj_name = $bdd->query('SELECT FIRSTNAME, LASTNAME FROM employee WHERE ID = ' . $dj['ID']);
                                    $dj_name = $dj_name->fetch();
                                    echo "<option value='" . $dj['ID'] . "'>" . $dj_name['FIRSTNAME'] . " " . $dj_name['LASTNAME'] . "</option>";
                                 }
                              }
                           }
                           ?>
                        </select>
                     </div>
                  </div>
                  <!-- Theme et Playlist-->
                  <div class="flex space-x-4">
                     <!-- Theme -->
                     <div class="w-1/2">
                        <label for="theme" class="block mb-2 text-sm font-medium text-gray-900">Thème</label>
                        <select name="theme" id="theme" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                           <?php
                           foreach ($theme_table as $theme) {
                              if ($theme['NAME'] == $row['THEME']) {
                                 echo "<option value='" . $theme['NAME'] . "' selected>" . $theme['NAME'] . "</option>";
                              } else {
                                 echo "<option value='" . $theme['NAME'] . "'>" . $theme['NAME'] . "</option>";
                              }
                           }
                           ?>
                        </select>
                     </div>
                     <!-- Playlist -->
                     <div class="w-1/2">
                        <label for="playlist" class="block mb-2 text-sm font-medium text-gray-900">Playlist</label>
                        <select name="playlist" id="playlist" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                           <?php
                           foreach ($playlist_table as $playlist) {
                              if ($playlist['NAME'] == $row['PLAYLIST']) {
                                 echo "<option value='" . $playlist['NAME'] . "' selected>" . $playlist['NAME'] . "</option>";
                              } else {
                                 echo "<option value='" . $playlist['NAME'] . "'>" . $playlist['NAME'] . "</option>";
                              }
                           }
                           ?>
                        </select>
                     </div>
                  </div>
                  <!-- Location -->
                  <div>
                     <label for="location" class="block mb-2 text-sm font-medium text-gray-900">Lieu</label>
                     <select name="location" id="location" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <?php
                        foreach ($location_table as $location) {
                           if ($location['ID'] == $row['LOCATION']) {
                              echo "<option value='" . $location['ID'] . "' selected>" .  $location['STREET'] . ", " . $location['CITY'] . " " . $location['POSTAL_CODE'] . " " . $location['COUNTRY'] . "</option>";
                           } else {
                              // We need to check if the location is available. 
                              foreach ($all_events_table as $event) {
                                 if ($event['ID'] != $row['ID'] && $event['DATE'] == $row['DATE'] && $location['ID'] == $event['LOCATION']) {
                                    $location['ID'] = -1;
                                 }
                              }
                              if ($location['ID'] != -1) {
                                 echo "<option value='" . $location['ID'] . "'>" .  $location['STREET'] . ", " . $location['CITY'] . " " . $location['POSTAL_CODE'] . " " . $location['COUNTRY'] . "</option>";
                              }
                           }
                        }
                        ?>
                     </select>
                  </div>
                  <!-- Type and Rental Fee-->
                  <div class="flex space-x-4">
                     <!-- Type -->
                     <div class="w-1/2">
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Type</label>
                        <input type="text" name="type" id="type" value="<?php echo $row['TYPE']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                     </div>
                     <!-- Rental Fee -->
                     <div class="w-1/2">
                        <label for="rentalFee" class="block mb-2 text-sm font-medium text-gray-900">Frais de location</label>
                        <input type="number" name="rentalFee" id="rentalFee" value="<?php echo $row['RENTAL_FEE']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                     </div>
                  </div>
                  <!-- Description -->
                  <div>
                     <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description de l'événement</label>
                     <textarea name="description" id="description" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Description de l'événement"><?php echo $row['DESCRIPTION']; ?></textarea>
                  </div>
                  <!-- ID -->
                  <div>
                     <label for="id" class="block mb-2 text-sm font-medium text-gray-900">ID*</label>
                     <input type="number" name="id" id="id" value="<?php echo $row['ID']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                  </div>
                  <!-- Submit -->
                  <div>
                     <input type="hidden" name="action" value="edit">
                     <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Editer</button>
                  </div>
               </form>
            </div>

         <?php
         }
         ?>
         <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>

<?php
      }
   }
?>

</html>