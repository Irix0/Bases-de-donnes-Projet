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
      echo "<script type='text/javascript'>document.location.replace('/login.php');</script>";
   } else {
      require_once(__ROOT__.'/navbar.php');
   }

   $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
   if(isset($_GET['cd_number']))
      $cdNumber = $_GET['cd_number'];
   else {
      echo "<div class='ml-80 mr-80 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
      <p class='font-bold'>Mauvais accès</p>
      <p>Les accès directs à cette page sont interdits.</p>
      </div>";
      die();
   }
      

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

if(isset($_POST['cd_number_delete'])){ // Delete song
   $sql = 'DELETE FROM `song` WHERE `song`.`CD_NUMBER` = :cd_number AND `song`.`TRACK_NUMBER` = :track_number';
   $sth = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
   if(!$sth->execute(array('cd_number' => $_POST["cd_number_delete"], 'track_number' => $_POST["track_number_delete"]))){
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
}
?>

<!-- Add location modal toggle -->
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
               Numéro de piste
            </th>
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
         $rows_nb = $bdd->query('SELECT COUNT(*) FROM `song` WHERE CD_NUMBER=' . $cdNumber)->fetchColumn();

         $page_nb = ceil($rows_nb / $resultsPerPage);

         $req = $bdd->query('SELECT DISTINCT * FROM cd INNER JOIN song ON cd.CD_NUMBER = song.CD_NUMBER WHERE cd.CD_NUMBER = ' . $_GET['cd_number'] . ' LIMIT ' . $pageFirstResult . ',' . $resultsPerPage);

         while($row = $req->fetch()) {
            echo "
            <tr class='bg-white border-b hover:bg-gray-50'>
               <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                  ".$row['TRACK_NUMBER']."
               </th>
               <th class='px-6 py-4'>
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
                  <a href='edit-song.php?cd_number=".$row['CD_NUMBER']. "&track_number=".$row['TRACK_NUMBER']."'>
                     <button type='button' class='text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center mr-2 mb-2'><i class='fa-solid fa-pen'></i></button>
                  </a>
                    <form method='post' action='#'>
                        <input type='hidden' name='cd_number_delete' value='".$row['CD_NUMBER']."'>
                        <input type='hidden' name='track_number_delete' value='".$row['TRACK_NUMBER']."'>
                        <button type='submit' class='text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center mr-2 mb-2'><i class='fa-sharp fa-solid fa-trash'></i></button>
                     </form>
                  </div>
               </td>
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
         <!-- Buttons -->

         <nav class="mt-1 mb-2">
            <ul class="list-style-none flex">
               <?php
               for($i = 1; $i<= $page_nb; $i++) {
                  if($i == $page){
                     echo '<li>
                     <a
                        class="relative block rounded bg-blue-100 px-3 py-1.5 text-sm font-medium text-primary-700 transition-all duration-300"
                        href = "edit-cd.php?page=' . $i . '&cd_number='.$cdNumber.'"> ' . $i . ' <span
          class="absolute -m-px h-px w-px overflow-hidden border-0 p-0 [clip:rect(0,0,0,0)]"
          >(current)</span></a>
          </li>';
                  } else {
                  echo '<li>
                  <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100"
                     href = "edit-cd.php?page=' . $i . '&cd_number='.$cdNumber.'">' . $i . ' </a>
               </li>';
                  }
               }
               ?>
            </ul>
         </nav>

      </div>

      <!-- Add modal -->
      <div id="add-song-modal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
         <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
               <button
                  class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                  data-modal-hide="add-song-modal">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                  </svg>
                  <span class="sr-only">Fermer le modal</span>
               </button>
               <div class="px-6 py-6 lg:px-8">
                  <h3 class="mb-4 text-xl font-medium text-gray-900">Ajouter une chanson</h3>
                  <form method="post" class="space-y-6" action="#">
                     <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Titre*</label>
                        <input type="text" name="street" id="title"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           placeholder="The Queen is Dead" required>
                     </div>
                     <div class="flex space-x-8">
                        <div>
                           <label for="artist" class="block mb-2 text-sm font-medium text-gray-900">Artiste*</label>
                           <input type="text" name="artist" id="artist" placeholder="The Smiths"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                              required>
                        </div>
                        <div>
                           <label for="duration" class="block mb-2 text-sm font-medium text-gray-900">Durée*</label>
                           <input type="text" name="duration" id="duration" placeholder="00:00:00"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                              required maxlength="8">
                        </div>
                     </div>
                     <div>
                        <label for="genre" class="block mb-2 text-sm font-medium text-gray-900">Genre*</label>
                        <input type="text" name="genre" id="genre"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           placeholder="Pop" required>
                     </div>
                     <div>
                        <label for="track_number" class="block mb-2 text-sm font-medium text-gray-900">Track Number</label>
                        <input type="number" name="track_number" id="track_number"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           placeholder="20">
                     </div>
                     <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Ajouter</button>
                  </form>
               </div>
            </div>
         </div>
      </div>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
   <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>

</html>
