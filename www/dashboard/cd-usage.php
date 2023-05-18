<?php session_start();
$title = 'Tableau de bord : utilisation des CD';
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

   if (isset($_POST['attr'])) {
      $attr = $_POST['attr'];
      $dir = $_POST['dir'];
   } else if (isset($_GET['attr']) && isset($_GET['dir'])) {
      $attr = $_GET['attr'];
      $dir = $_GET['dir'];
   } else {
      $attr = 'DATE';
      $dir = 'DESC';
   }

   $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
   ?>
   <div class="ml-80 mr-80 mt-2 px-6 py-6 lg:px-8">
      <!-- title -->
      <h2 class="text-xl font-medium text-gray-900">Utilisation des CD</h2>
      <h3 class="text-s font-medium text-gray-500 mb-4">Sélectionnez un attribut et un sens de tri pour trier les résultats</h3>
      <form method="post" action="#">
         <div class="flex items-center space-x-2 h-10 mt-5">
            <div class="basis-1/12">
               <label for="attr" class="block mb-2 text-sm font-medium text-gray-900">Attribut</label>
               <select id="attr" name="attr" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                  <option value="DATE" selected>Date</option>
                  <option value="NB_USED">CD utilisé(s)</option>
                  <option value="COPIES">CD possédé(s)</option>
                  <option value="CD_NUMBER">CD(id)</option>
                  <option value="TITLE">CD(title)</option>
               </select>
            </div>
            <div class="basis-2/12">
               <label for="dir" class="block mb-2 text-sm font-medium text-gray-900">Sens de tri</label>
               <select id="dir" name="dir" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                  <option value="DESC" selected>Décroissant</option>
                  <option value="ASC">Croissant</option>
               </select>
            </div>
            <div>
               <input type="hidden" name="filterPost" value="true">
               <button type="submit" name"submit" class="block mt-7 text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center">Trier</button>
            </div>
         </div>
      </form>
      <!-- Main table -->
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8">
         <table class="table-fixed w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
               <tr>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Date
                  </th>
                  <th scope="col" class="w-2/12 px-6 py-3">
                     CD
                  </th>
                  <th scope="col" class="w-3/12 px-6 py-3">
                     utilisé(s)/possédé(s)*
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
               // Check $attr and $dir inputs
               $attr_values = array('DATE', 'NB_USED', 'COPIES', 'CD_NUMBER', 'TITLE');
               $dir_values = array('ASC', 'DESC');
               if (!in_array($attr, $attr_values) || !in_array($dir, $dir_values)) {
                  echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                     <i class='fa-solid fa-circle-exclamation fa-shake'></i>
                     <p class='font-bold'>Erreur</p>
                     <p>Une erreur est survenue. Veuillez vérifier votre entrée.</p>
                     </div>";
                  die();
               }

               $pageFirstResult = ($page - 1) * $resultsPerPage;
               $sql = "SELECT DISTINCT TITLE, DATE, COPIES , CD_NUMBER, COUNT(DISTINCT event.ID) as NB_USED
               FROM contains
               NATURAL JOIN cd NATURAL JOIN event
               GROUP BY DATE, TITLE, CD_NUMBER";

               $req = $bdd->query($sql);
               $rows_nb = $req->rowCount();
               $page_nb = ceil($rows_nb / $resultsPerPage);


               $sql .= " ORDER BY $attr $dir LIMIT $pageFirstResult, $resultsPerPage";
               $req = $bdd->prepare($sql);


               if (!$req->execute()) {
                  echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                     <p class='font-bold'>Erreur</p>
                     <p>Une erreur est survenue. Veuillez vérifier votre entrée.</p>
                     <p>Ce message peut vous aider à résoudre votre erreur : [code " . $req->errorInfo()[0] . "] `" . $req->errorInfo()[2] . "´.</p>
                     </div>";
                  die();
               } else {
                  while ($row = $req->fetch()) {
                     echo "
                     <tr class='bg-white border-b hover:bg-gray-50'>
                        <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                           " . $row['DATE'] . "
                        </th>
                        <td class='px-6 py-4'>
                           " . $row['CD_NUMBER'] . " - " . $row['TITLE'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $row['NB_USED'] . " / " . $row['COPIES'] . "
                        </td>
                     </tr>
                     ";
                  }
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
            <div>
               <nav class="mt-1 mb-2">
                  <ul class="list-style-none flex">
                     <?php
                     for ($i = 1; $i <= $page_nb; $i++) {
                        if ($i == $page) {
                           echo '<li>
                     <a
                        class="relative block rounded bg-blue-100 px-3 py-1.5 text-sm font-medium text-primary-700 transition-all duration-300"
                        href = "cd-usage.php?page=' . $i . '&attr=' . $attr . '&dir=' . $dir . '"> ' . $i . ' <span
          class="absolute -m-px h-px w-px overflow-hidden border-0 p-0 [clip:rect(0,0,0,0)]"
          >(current)</span></a>
          </li>';
                        } else {
                           echo '<li>
                  <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100"
                     href = "cd-usage.php?page=' . $i . '&attr=' . $attr . '&dir=' . $dir . '">' . $i . ' </a>
               </li>';
                        }
                     }
                     ?>
                  </ul>
               </nav>
            </div>
         </div>

         <div>
            <p class="text-left text-xs">* Le nombre de CD utilisé est le nombre de CD utilisé sur la journée pour tous les
               événements.</p>
         </div>
      </div>
   </div>





   <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
   <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>

</html>