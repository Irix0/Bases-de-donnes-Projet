<?php session_start();
$title = 'Tableau de bord : utilisation des CD';
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

   if(isset($_POST['attr'])){
      $attr = $_POST['attr'];
      $dir = $_POST['dir'];
   } else {
      $attr = 'DATE';
      $dir = 'DESC';
   }

   $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
?>
   <form method="post" action="#">
   <div class="flex items-center space-x-2 h-10 ml-80 mr-80 mt-5">
      <div class="basis-1/12">
            <label for="attr" class="block mb-2 text-sm font-medium text-gray-900">Attribut</label>
            <select id="attr" name="attr"
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
               <option value="DATE" selected>Date</option>
               <option value="NAME">Événement</option>
               <option value="CD_NUMBER">CD(id)</option>
               <option value="TITLE">CD(title)</option>
            </select>
      </div>
      <div class="basis-2/12">
         <label for="dir" class="block mb-2 text-sm font-medium text-gray-900">Sens de tri</label>
         <select id="dir" name="dir"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="DESC" selected>Décroissant</option>
            <option value="ASC">Croissant</option>
         </select>
      </div>
      <div>
         <input type="hidden" name="filterPost" value="true">
         <button type="submit" name"submit"
            class="block mt-7 text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center">Trier</button>
      </div>
   </div>
   </form>
   <!-- Main table -->
   <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8 ml-80 mr-80">
      <table class="table-fixed w-full text-sm text-left text-gray-500">
         <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
               <th scope="col" class="w-3/12 px-6 py-3">
                  Événement
               </th>
               <th scope="col" class="w-1/12 px-6 py-3">
                  Date
               </th>
               <th scope="col" class="w-1/12 px-3 py-3">
                  CD utilisé
               </th>
               <th scope="col" class="w-3/12 px-6 py-3">
                  utilisé(s)/disponible(s)*
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
            $rows_nb = $bdd->query('SELECT COUNT(DISTINCT E.NAME, E.DATE, C.CD_NUMBER) FROM event E NATURAL JOIN contains C')->fetchColumn();

            $req = $bdd->query('SELECT DISTINCT E.NAME, E.DATE, CT.CD_NUMBER, cd.COPIES, cd.TITLE FROM event E 
            JOIN contains CT ON E.PLAYLIST = CT.PLAYLIST 
            JOIN cd ON CT.CD_NUMBER = cd.CD_NUMBER
            ORDER BY ' . $attr . ' ' . $dir . '
            LIMIT ' . $pageFirstResult . ',' . $resultsPerPage . ''
            );

            if(!$req){
               echo "<tr class='bg-white border-b hover:bg-gray-50'>
               <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                  Aucun résultat.
               </th>";
            }

            $cd_used_sql = 'SELECT COUNT(DISTINCT E.NAME, E.DATE, C.CD_NUMBER) FROM event E JOIN contains C ON E.PLAYLIST = C.PLAYLIST WHERE E.DATE = :date AND C.CD_NUMBER = :cd_number';
            $cd_used_pdo = $bdd->prepare($cd_used_sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

            $prev = null;

            while($row = $req->fetch()) {
               if($prev != $row['NAME']) {
                  $cd_used_pdo->execute(array(':date' => $row['DATE'], ':cd_number' => $row['CD_NUMBER']));
                  $cd_used = $cd_used_pdo->fetchColumn();
               echo "
               <tr class='bg-white border-b hover:bg-gray-50'>
                  <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                     ".$row['NAME']."
                  </th>
                  <td class='px-6 py-4'>
                     ".$row['DATE']."
                  </td>
                  <td class='px-6 py-4'>
                     ".$row['CD_NUMBER']." - ".$row['TITLE']."
                  </td>
                  <td class='px-6 py-4'>
                     ".$cd_used." / " . $row['COPIES'] . "
                  </td>
               </tr>
               ";
               } else {
                  echo "
                  <tr class='bg-white border-b hover:bg-gray-50'>
                     <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                     </th>
                     <td class='px-6 py-4'>
                     </td>
                     <td class='px-6 py-4'>
                     ".$row['CD_NUMBER']." - ".$row['TITLE']."
                  </td>
                  <td class='px-6 py-4'>
                     ".$cd_used." / " . $row['COPIES'] . "
                     </td>
                  </tr>
                  ";
               }
               $prev = $row['NAME'];
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
                        href = "cd-usage.php?page=' . $i . '"> ' . $i . ' <span
          class="absolute -m-px h-px w-px overflow-hidden border-0 p-0 [clip:rect(0,0,0,0)]"
          >(current)</span></a>
          </li>';
                  } else {
                  echo '<li>
                  <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100"
                     href = "cd-usage.php?page=' . $i . '">' . $i . ' </a>
               </li>';
                  }
               }
               ?>
            </ul>
         </nav>
      </div>

      <div>
         <p class="text-left text-xs">* Le nombre de CD utilisé est le nombre de CD utilisé sur la journée pour tous les
            événements.</p>
      </div>





      <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
      <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>

</html>