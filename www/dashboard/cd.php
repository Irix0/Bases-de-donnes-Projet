<?php session_start();
$title = 'Tableau de bord : cd';
$currentPage = 'dashboard';
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/head.php');
$resultsPerPage = 10;
?>

<body>
   <?php
   if (!isset($_SESSION['login'])) {
      echo "<script type='text/javascript'>document.cd.replace('/login.php');</script>";
   } else {
      require_once(__ROOT__ . '/navbar.php');
   }

   $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
   ?>
   <div class="ml-80 mr-80 mt-2 px-6 py-6 lg:px-8">
      <!-- title -->
      <h2 class="text-xl font-medium text-gray-900">Liste des CD</h2>
      <h3 class="text-s font-medium text-gray-500 mb-4">Sélectionnez un CD pour le modifier</h3>

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
         <table class="table-fixed w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
               <tr>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Titre du CD
                  </th>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Producteur/trice
                  </th>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Année de sortie
                  </th>
                  <th scope="col" class="w-1/12">
                  </th>
               </tr>
            </thead>
            <tbody>
               <?php
               if (!isset($_GET['page'])) {
                  $page = 1;
               } else {
                  $page = $_GET['page'];
               }
               $pageFirstResult = ($page - 1) * $resultsPerPage;
               $rows_nb = $bdd->query('SELECT COUNT(*) FROM cd')->fetchColumn();

               $page_nb = ceil($rows_nb / $resultsPerPage);

               $req = $bdd->query('SELECT * FROM cd LIMIT ' . $pageFirstResult . ',' . $resultsPerPage);

               while ($row = $req->fetch()) {
                  echo "
               <tr class='bg-white border-b hover:bg-gray-50'>
                  <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                     " . $row['TITLE'] . "
                  </th>
                  <td class='px-6 py-4'>
                     " . $row['PRODUCER'] . "
                  </td>
                  <td class='px-6 py-4'>
                     " . $row['YEAR'] . "
                  </td>
						<td class='py-2'>
                     <div class='flex'>
                     <a href='edit-cd.php?cd_number=" . $row['CD_NUMBER'] . "'>
                        <button data-modal-target='add-cd-modal' data-modal-toggle='add-cd-modal'
                           class='faa-parent animated-hover text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-3 py-2 text-center mr-2 mb-2'
                           type='button'>
                           <i class='fa-solid fa-arrow-right faa-bounce'></i>
                        </button>
                       </a>
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
               <span class="font-semibold text-gray-900"><?php echo $pageFirstResult + 1; ?> </span> à <span class="font-semibold text-gray-900">
                  <?php
                  if (($pageFirstResult + $resultsPerPage) > $rows_nb) {
                     echo $rows_nb;
                  } else {
                     echo ($pageFirstResult + $resultsPerPage);
                  } ?></span> résultats montrés sur <span class="font-semibold text-gray-900"><?php echo "$rows_nb"; ?></span>
            </span>
            <!-- Buttons -->

            <nav class="mt-1 mb-2">
               <ul class="list-style-none flex">
                  <?php
                  for ($i = 1; $i <= $page_nb; $i++) {
                     if ($i == $page) {
                        echo '<li>
                     <a
                        class="relative block rounded bg-blue-100 px-3 py-1.5 text-sm font-medium text-primary-700 transition-all duration-300"
                        href = "cd.php?page=' . $i . '"> ' . $i . ' <span
          class="absolute -m-px h-px w-px overflow-hidden border-0 p-0 [clip:rect(0,0,0,0)]"
          >(current)</span></a>
          </li>';
                     } else {
                        echo '<li>
                  <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100"
                     href = "cd.php?page=' . $i . '">' . $i . ' </a>
               </li>';
                     }
                  }
                  ?>
               </ul>
            </nav>
         </div>
      </div>


      <!-- Add modal -->
      <div id="add-cd-modal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
         <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
               <button
                  class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                  data-modal-hide="add-cd-modal">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                  </svg>
                  <span class="sr-only">Fermer le modal</span>
               </button>
            </div>
         </div>
      </div>



      <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
      <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>

</html>