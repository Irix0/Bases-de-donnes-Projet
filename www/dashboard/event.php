<?php session_start();
$title = 'Tableau de bord : Événements';
$currentPage = 'dashboard';
define('__ROOT__', dirname(dirname(__FILE__)));
date_default_timezone_set('Europe/Brussels');
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
      <h2 class="text-xl font-medium text-gray-900">Liste des événements</h2>
      <h3 class="text-s font-medium text-gray-500 mb-4">Détails des événements</h3>
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6">
         <table class="table-fixed w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
               <tr>
                  <th scope="col" class="w-4/12 px-6 py-3">
                     Nom de l'événement
                  </th>
                  <th scope="col" class="w-2/12 px-6 py-3">
                     Date
                  <th scope="col" class="w-2/12 px-6 py-3">
                     Statut
                  </th>
                  <th scope="col" class="w-2/12 px-6 py-3">
                     Coût*
                  </th>
                  <th scope="col" class="w-2/12">
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

               $rows_nb = $bdd->query('SELECT COUNT(*) FROM event')->fetchColumn();

               $page_nb = ceil($rows_nb / $resultsPerPage);

               $req = $bdd->query('SELECT ID, NAME, RENTAL_FEE, DATE from event ORDER BY DATE DESC, NAME ASC LIMIT ' . $pageFirstResult . ',' . $resultsPerPage);

               $today = date("Y-m-d");

               while ($row = $req->fetch()) {
                  echo "
                    <tr class='bg-white border-b hover:bg-gray-50'>
                        <th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap'>
                            " . $row['NAME'] . "
                        </th>
                        <td class='px-6 py-4'>
                            " . date("d-m-Y", strtotime($row['DATE'])) . "
                        </td>
                        <td class='px-6 py-4'>
                            ";
                  if ($row['DATE'] == $today) {
                     echo "AUJOURD'HUI";
                  } elseif ($row['DATE'] < $today) {
                     echo "PASSÉ";
                  } else {
                     echo "FUTUR";
                  }
                  echo "
                        </td>
                        <td class='px-6 py-4'>
                            " . ($row['RENTAL_FEE'] + 1500) . " €
                        </td>
                        ";
                  echo "
                        <td class='px-6 py-2'>
                        <a href='details.php?id=" . $row['ID'] . "'>
                        <button 
                           class='faa-parent animated-hover text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-3 py-2 text-center mt-2 mr-2 mb-2'
                           type='button'>
                           <i class='fa-solid fa-eye fa-lg faa-wrench'></i>
                        </button>
                     </a>
                        </td>";
                  echo "</tr>";
               }
               ?>
            </tbody>
         </table>

         <div class="flex flex-col items-center">
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
            <nav>
               <ul class="list-style-none flex">
                  <?php
                  for ($i = 1; $i <= $page_nb; $i++) {
                     if ($i == $page) {
                        echo '<li>
                           <a
                              class="relative block rounded bg-blue-100 px-3 py-1.5 text-sm font-medium text-primary-700 transition-all duration-300"
                              href = "event.php?page=' . $i . '"> ' . $i . ' <span
                              class="absolute -m-px h-px w-px overflow-hidden whitespace-nowrap border-0 p-0 [clip:rect(0,0,0,0)]"
                              >(current)</span></a>
                        </li>';
                     } else {
                        echo '<li>
                           <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100"
                              href = "event.php?page=' . $i . '">' . $i . ' </a>
                        </li>';
                     }
                  }
                  ?>
               </ul>
            </nav>
         </div>
         <div>
            <p class="text-left text-xs">* Les coûts comprennent un forfait de 1500 EUR pour l'organisation de l'événement.</p>
         </div>
      </div>
   </div>
   <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>