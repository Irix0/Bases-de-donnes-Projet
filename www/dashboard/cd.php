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
   /*
   try{
   }
   catch(Exception $e){
      die('Erreur' : ' .$e->getMessage());
   }*/
?>

	<div class="ml-80 mr-80 mt-10 block bg-blue-50 rounded text-sm font-medium text-blue-500 px-5 py-2.5 text-center">
		<tr> 
			<th scope="col" class="w-1/12 px-6 py-3">
				Sélectionnez un CD
			</th>
		</tr>
	</div>

	<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6 ml-80 mr-80">
      <table class="table-fixed w-full text-sm text-left text-gray-500">
         <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
               <th scope="col" class="w-1/12 px-6 py-3">
                  Titre du CD
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
                if (!isset ($_GET['page']) ) {  
                  $page = 1;  
              } else {  
                  $page = $_GET['page'];  
              }  
            $pageFirstResult = ($page-1) * $resultsPerPage;
            $rows_nb = $bdd->query('SELECT COUNT(*) FROM cd')->fetchColumn();

            $page_nb = ceil($rows_nb / $resultsPerPage);  

            $req = $bdd->query('SELECT * FROM cd LIMIT ' . $pageFirstResult . ',' . $resultsPerPage);

            while($row = $req->fetch()) {
               echo "
               <tr class='bg-white border-b hover:bg-gray-50'>
                  <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                     ".$row['TITLE']."
                  </th>
                  <td class='px-6 py-4'>
                     ".$row['YEAR']."
                  </td>
						<td class='py-2'>
                     <div class='flex'>
                     <a href='edit-cd.php?cd_number=".$row['CD_NUMBER']."'>
                        <button data-modal-target='add-cd-modal' data-modal-toggle='add-cd-modal'
                           class='text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-4 text-center mr-2 mb-2'
                           type='button'>
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