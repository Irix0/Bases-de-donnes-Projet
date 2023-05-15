<?php session_start();
$title = 'Tableau de bord : cd';
$currentPage = 'dashboard'; 
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/head.php');
$resultsPerPage = 10;
?>

<body>
   <?php
   if(!isset($_SESSION['login'])) {
      echo "<script type='text/javascript'>document.cd.replace('/login.php');</script>";
   } else {
      require_once(__ROOT__.'/navbar.php');
   }

   $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
   $trackNumber = $_GET['track_number'];

   if (isset($_POST['title'])) { // Add new song
      // Check if ZIP is numeric
      if (!is_numeric($_POST['duration'])) {
         echo "<div class='ml-80 mr-80 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                <p class='font-bold'>Mauvaise entrée</p>
                <p>La durée donnée n'est pas numérique.</p>
              </div>";
      } else {
         if(empty($_POST['artist'])) $_POST['artist'] = NULL; // If artist is empty, set it to NULL (to avoid SQL error)
         if(empty($_POST['genre'])) $_POST['genre'] = NULL; // If genre is empty, set it to NULL (to avoid SQL error)
         if(empty($_POST['track_number'])) $_POST['track_number'] = NULL; // If track_number is empty, set it to NULL (to avoid SQL error)

         $sql = 'INSERT INTO `song` (`CD_NUMBER`, `TRACK_NUMBER`, `TITLE`, `ARTIST`, `DURATION`, `GENRE`) VALUES (:cd_number, :track_number, :title, :artist, :duration, :genre);';
         $sth = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
         if(!$sth->execute(array('cd_number' => $_POST["cd_number"], 'track_number' => $_POST["track_number"], 'title' => $_POST["title"], 'artist' => $_POST["artist"], 'duration' => $_POST["duration"], 'genre' => $_POST["genre"]))){
            echo "<div class='ml-80 mr-80 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                  <p class='font-bold'>Erreur</p>
                  <p>Une erreur est survenue. Veuillez vérifier votre entrée.</p>
                  <p>Ce message peut vous aider à résoudre votre erreur : [code " . $sth->errorInfo()[0] . "] `" . $sth->errorInfo()[2] . "´.</p>
               </div>";
         }
      }
}

   if(isset($_POST['cd_number_delete'])){ // Delete location
      // Check if song is used in a reservation
      $sql = 'SELECT COUNT(*) FROM `song` WHERE `song`.`CD_NUMBER` = :cd_number';
      $sth = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute(array('cd_number' => $_POST["cd_number_delete"]));
      $result = $sth->fetch();
      if($result[0] == 0){
      $sql = 'DELETE FROM `song` WHERE `song`.`CD_NUMBER` = :cd_number AND `song`.`TRACK_NUMBER` = :track_number';
      $sth = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      if(!$sth->execute(array('cd_number' => $_POST["cd_number_delete"]))){
         echo "<div class='ml-80 mr-80 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                <p class='font-bold'>Erreur</p>
                <p>Une erreur est survenue. Veuillez réessayer.</p>
              </div>";
         } else {
            echo "<div class='ml-80 mr-80 bg-green-100 border-l-4 border-green-500 text-green-700 p-4' role='alert'>
                   <p class='font-bold'>Succès</p>
                   <p>Chanson supprimée avec succès.</p>
                 </div>";
         }
      } else {
         echo "<div class='ml-80 mr-80 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4' role='alert'>
                <p class='font-bold'>Erreur</p>
                <p>Impossible de supprimer cette chanson car elle est utilisée dans une réservation.</p>
              </div>";
      }
   }
?>

   <!-- Add song modal toggle -->
   <button data-modal-target="add-song-modal" data-modal-toggle="add-song-modal"
      class="ml-80 mr-80 mt-10 block bg-blue-50 rounded text-sm font-medium text-blue-500 hover:bg-blue-100 hover:text-blue-600 px-5 py-2.5 text-center"
      type="button">
      Ajouter une chanson
   </button>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6 ml-80 mr-80">
   <table class="table-fixed w-full text-sm text-left text-gray-500">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50">
         <tr>
            <th scope="col" class="w-1/12 px-6 py-3">
               Titre de la chason
            </th>
            <th scope="col" class="w-1/12 px-6 py-3">
               Artiste
            </th>
            <th scope="col" class="w-1/12 px-6 py-3">
               Durée
            </th>
            <th scope="col" class="w-1/12 px-6 py-3">
               Genre
            </th>
            <th scope="col" class="w-1/12">
            </th>
         </tr>
      </thead>
      <tbody>
         <?php
             if (!isset ($_GET['page']) ) {  
               $page = 1;  
           } else {  
               $page = $_GET['page'];  
           }  
         $pageFirstResult = ($page-1) * $resultsPerPage;
         $rows_nb = $bdd->query('SELECT COUNT(*) FROM song s INNER JOIN cd cd ON cd.cd_number = s.cd_number')->fetchColumn();

         $page_nb = ceil($rows_nb / $resultsPerPage);

         $req = $bdd->query('SELECT * FROM cd LIMIT ' . $pageFirstResult . ',' . $resultsPerPage);

         while($row = $req->fetch()) {
            echo "
            <tr class='bg-white border-b hover:bg-gray-50'>
               <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                  ".$row['TITLE']."
               </th>
               <td class='px-6 py-4'>
                  ".$row['ARTIST']."
               </td>
               <td class='px-6 py-4'>
                  ".$row['DURATION']."
               </td>
               <td class='px-6 py-4'>
                  ".$row['GENRE']."
               </td>
               <td class='py-2'>
                  <div class='flex'>
                  <a href='edit-song.php?cd_number=".$row['CD_NUMBER']."&track_number=".$row['TRACK_NUMBER']."'>
                     <button type='button' class='text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center mr-2 mb-2'><i class='fa-solid fa-pen'></i></button>
                  </a>
                    <form method='post' action='#'>
                        <input type='hidden' name='cd_number_delete' value='".$row['CD_NUMBER']."'>
                        <button type='submit' class='text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center mr-2 mb-2'><i class='fa-sharp fa-solid fa-trash'></i></button>
                     </form>
                  </div>
               </th>
            </tr>
            ";
         }

         ?>
      </tbody>
   </table>

   <div class="mt-3 flex flex-col items-center">
      <!-- Help text -->
      <span class="text-sm text-gray-700">
         <span class="font-semibold text-gray-900"><?php echo $pageFirstResult+1; ?> </span> à <span
            class="font-semibold text-gray-900"><?php 
            if(($pageFirstResult + $resultsPerPage) > $rows_nb){
               echo $rows_nb;
            } else {
               echo ($pageFirstResult + $resultsPerPage);
            } ?></span> résultats montrés sur <span
            class="font-semibold text-gray-900"><?php echo "$rows_nb"; ?></span>
      </span>
   </div>
</div>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
   <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>

</html>
