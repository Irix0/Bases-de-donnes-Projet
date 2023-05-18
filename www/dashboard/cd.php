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
      echo "<script type='text/javascript'>document.location.replace('/login.php');</script>";
      die("Please login first. If you see this the JavaScript script didn't redirect you properly. Try to enable JavaScript in your browser.");
   } else {
      require_once(__ROOT__ . '/navbar.php');
   }

   $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
   ?>
   <div class="2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 mt-2 px-6 py-6 lg:px-8">
      <!-- title -->
      <h2 class="text-xl font-medium text-gray-900">Liste des CD</h2>
      <h3 class="text-s font-medium text-gray-500 mb-4">Sélectionnez un CD pour le modifier</h3>

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
         <table class="table-fixed w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
               <tr>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Numéro du CD
                  </th>
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
                     " . $row['CD_NUMBER'] . "
                  </th>
                  <th class='px-6 py-4'>
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
                           class='faa-parent animated-hover text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-3 py-2 text-center mt-2 mr-2 mb-2'
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
   </div>


   <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
   <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>

</html>