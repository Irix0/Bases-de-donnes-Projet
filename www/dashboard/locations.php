<?php session_start();
$title = 'Tableau de bord : lieux';
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

   if (isset($_POST['street'])) {
      if(empty($_POST['id'])){
         $_POST['id'] = NULL;
      }
   
      if(empty($_POST['comment'])){
         $_POST['comment'] = NULL;
      }

      $sql = 'INSERT INTO `location` (`ID`, `STREET`, `CITY`, `POSTAL_CODE`, `COUNTRY`, `COMMENT`) VALUES (:id, :street, :city, :postal, :country, :comment);';
      $sth = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
      $sth->execute(array('id' => NULL, 'street' => $_POST["street"], 'city' => $_POST["city"], 'postal' => $_POST["zip"], 'country' => $_POST["country"], 'comment' => $_POST["comment"]));
   }
?>

   <!-- Add location modal toggle -->
   <button data-modal-target="add-location-modal" data-modal-toggle="add-location-modal"
      class="ml-80 mr-80 mt-10 block bg-blue-50 rounded text-sm font-medium text-blue-500 hover:bg-blue-100 hover:text-blue-600 px-5 py-2.5 text-center"
      type="button">
      Ajouter un lieu
   </button>
   <!-- Main table -->
   <div class="table-auto overflow-x-auto shadow-md sm:rounded-lg mt-6 ml-80 mr-80">
      <table class="w-full text-sm text-left text-gray-500">
         <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
               <th scope="col" class="px-6 py-3">
                  Rue
               </th>
               <th scope="col" class="px-6 py-3">
                  Ville
               </th>
               <th scope="col" class="px-3 py-3">
                  Code postal
               </th>
               <th scope="col" class="px-6 py-3">
                  Pays
               </th>
               <th scope="col" class="px-6 py-3">
                  Commentaires
               </th>
               <th scope="col" class="">
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
            $rows_nb = $bdd->query('SELECT COUNT(*) FROM location')->fetchColumn();

            $page_nb = ceil($rows_nb / $resultsPerPage);  

            $req = $bdd->query('SELECT * FROM location LIMIT ' . $pageFirstResult . ',' . $resultsPerPage);

            while($row = $req->fetch()) {
               echo "
               <tr class='bg-white border-b hover:bg-gray-50'>
                  <th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap'>
                     ".$row['STREET']."
                  </th>
                  <td class='px-6 py-4'>
                     ".$row['CITY']."
                  </td>
                  <td class='px-6 py-4'>
                     ".$row['POSTAL_CODE']."
                  </td>
                  <td class='px-6 py-4'>
                     ".$row['COUNTRY']."
                  </td>
                  <td class='px-6 py-4'>
                     ".$row['COMMENT']."
                  </td>
                  <td class='px-6 py-4'>
                     <a href='/edit-location.php?id=".$row['ID']."'>
                        <button type='button' class='text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2'>Editer</button>
                     </a>
                  </td>
               </tr>
               ";
            }

            ?>
         </tbody>
      </table>

      <div class="flex flex-col items-center">
         <!-- Help text -->
         <span class="text-sm text-gray-700">
            <span class="font-semibold text-gray-900"><?php echo $pageFirstResult+1; ?> </span> à <span
               class="font-semibold text-gray-900"><?php 
               if(($pageFirstResult + $resultsPerPage) > $rows_nb){
                  echo $rows_nb;
               } else {
                  echo ($pageFirstResult + $resultsPerPage);
               } ?></span> entitées montrées sur <span
               class="font-semibold text-gray-900"><?php echo "$rows_nb"; ?></span>
         </span>
         <!-- Buttons -->

         <nav>
            <ul class="list-style-none flex">
               <?php
               for($i = 1; $i<= $page_nb; $i++) {
                  if($i == $page){
                     echo '<li>
                     <a
                        class="relative block rounded bg-blue-100 px-3 py-1.5 text-sm font-medium text-primary-700 transition-all duration-300"
                        href = "locations.php?page=' . $i . '"> ' . $i . ' <span
          class="absolute -m-px h-px w-px overflow-hidden whitespace-nowrap border-0 p-0 [clip:rect(0,0,0,0)]"
          >(current)</span></a>
          </li>';
                  } else {
                  echo '<li>
                  <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100"
                     href = "locations.php?page=' . $i . '">' . $i . ' </a>
               </li>';
                  }
               }
               ?>
            </ul>
         </nav>

      </div>


      <!-- Main modal -->
      <div id="add-location-modal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
         <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
               <button
                  class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                  data-modal-hide="add-location-modal">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                  </svg>
                  <span class="sr-only">Fermer le modal</span>
               </button>
               <div class="px-6 py-6 lg:px-8">
                  <h3 class="mb-4 text-xl font-medium text-gray-900">Ajouter un lieu</h3>
                  <form method="post" class="space-y-6" action="locations.php">
                     <div>
                        <label for="street" class="block mb-2 text-sm font-medium text-gray-900">Rue*</label>
                        <input type="text" name="street" id="street"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           placeholder="Rue Fond des Tawes 251" required>
                     </div>
                     <div class="flex space-x-8">
                        <div>
                           <label for="city" class="block mb-2 text-sm font-medium text-gray-900">Ville*</label>
                           <input type="text" name="city" id="city" placeholder="Liège"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                              required>
                        </div>
                        <div>
                           <label for="city" class="block mb-2 text-sm font-medium text-gray-900">Code
                              postal* (4 chars max)</label>
                           <input type="text" name="zip" id="zip" placeholder="4000"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                              required maxlength="4">
                        </div>
                     </div>
                     <div>
                        <label for="country" class="block mb-2 text-sm font-medium text-gray-900">Pays*</label>
                        <input type="text" name="country" id="country"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           placeholder="Belgique" required>
                     </div>
                     <div>

                        <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">Commentaire</label>
                        <textarea id="comment" rows="4"
                           class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ajouter un commentaire"></textarea>
                     </div>
                     <div>
                        <label for="id" class="block mb-2 text-sm font-medium text-gray-900">ID</label>
                        <input type="number" name="id" id="id"
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
</body>