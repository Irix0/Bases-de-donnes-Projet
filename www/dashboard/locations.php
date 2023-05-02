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
?>

   <div class="table-auto overflow-x-auto shadow-md sm:rounded-lg mt-10 ml-80 mr-80">
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
                        <button type='button' class='text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800'>Editer</button>
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
               } ?></span> entitées montrées sur <span class="font-semibold text-gray-900"><?php echo "$rows_nb"; ?></span>
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

</body>