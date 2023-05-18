<?php session_start();
$title = 'Tableau de bord : tabcd';
$currentPage = 'dashboard';
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/head.php');
$resultsPerPage = 10;
?>

<body>
   <?php
   if (!isset($_SESSION['login'])) {
      echo "<script type='text/javascript'>document.location.replace('/login.php');</script>";
   } else {
      require_once(__ROOT__ . '/navbar.php');
   }

   $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
   ?>


   <div class="ml-80 mr-80 mt-2 px-6 py-6 lg:px-8">
      <!-- title -->
      <h2 class="text-xl font-medium text-gray-900">Table d'informations sur le contenu des CD</h2>
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
         <table class="table-fixed w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
               <tr>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Numéro de CD
                  </th>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Titre de CD
                  </th>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Durée totale
                  </th>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Durée minimale
                  </th>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Durée maximale
                  </th>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Durée moyenne
                  </th>
                  <th scope="col" class="w-1/12 px-6 py-3">
                     Nombre d'apparition de chansons du CD
                  </th>
                  <th scope="col" class="w-2/12 px-6 py-3">
                     Tous les genres liés au CD
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
               //$rows_nb = $bdd->query('SELECT COUNT(*) FROM song WHERE CD_NUMBER =' . $cdNumber)->fetchColumn();
               $rows_nb = $bdd->query('SELECT COUNT(*) FROM cd')->fetchColumn();

               $page_nb = ceil($rows_nb / $resultsPerPage);

               //!!!! faire des transacttions quand on fait des SELECT différents

               $sql1 = "SELECT * FROM (SELECT CD_NUMBER, COUNT(CD_NUMBER) as NB_CONTAINS FROM contains GROUP BY CD_NUMBER) t1 JOIN (SELECT song.CD_NUMBER, TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(DURATION))), '%H:%i:%s') as tot, MIN(DURATION) as min, MAX(DURATION) as max, TIME_FORMAT(SEC_TO_TIME(AVG(TIME_TO_SEC(DURATION))), '%H:%i:%s') as avg, cd.title FROM `song`, `cd` WHERE song.cd_number = cd.cd_number GROUP BY cd.cd_number) t2 ON t2.CD_NUMBER = t1.CD_NUMBER JOIN (SELECT CD_NUMBER, GROUP_CONCAT(DISTINCT song.GENRE, IFNULL(CONCAT(', ', t2.subgenres_concat), '') SEPARATOR ', ') AS GENRES FROM song LEFT JOIN (SELECT specializes.SUBGENRE, GROUP_CONCAT(DISTINCT specializes.GENRE SEPARATOR ', ') AS subgenres_concat FROM specializes GROUP BY specializes.SUBGENRE) t2 ON song.GENRE = t2.SUBGENRE GROUP BY CD_NUMBER) t3 ON t3.CD_NUMBER = t1.CD_NUMBER; ";

               $req = $bdd->prepare($sql1);
               $req->execute();
               while ($row = $req->fetch()) {
                  echo "
                     <tr class='bg-white border-b hover:bg-gray-50'>
                        <td scope='row' class='px-6 py-4 font-medium text-gray-900'>
                           " . $row['CD_NUMBER'] . "
                        </td>
                        <th class='px-6 py-4'>
                           " . $row['title'] . "
                        </th>
                        <td class='px-6 py-4'>
                           " . $row['tot'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $row['min'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $row['max'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $row['avg'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $row['NB_CONTAINS'] . "
                        </td>
                        <td class='px-6 py-4'>
                           " . $row['GENRES'] . "
                        </td>
                     </tr>
                     ";
               }

               ?>
            </tbody>

            </tbody>
      </div>
      </table>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
      <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>

</html>