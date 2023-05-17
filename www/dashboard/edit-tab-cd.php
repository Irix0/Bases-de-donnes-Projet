<?php session_start();
$title = 'Tableau de bord : tabcd';
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
				Table d'informations sur les durées des chansons sur ce CD
			</th>
		</tr>
	</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-6 ml-80 mr-80">
   <table class="table-fixed w-full text-sm text-left text-gray-500">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50">
         <tr>
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

         //vaut mieux éviter le GET (sinon il faut faire un prepare absolument)
         $req = $bdd->query('SELECT DISTINCT * FROM cd INNER JOIN song ON cd.CD_NUMBER = song.CD_NUMBER WHERE cd.CD_NUMBER = ' . $_GET['cd_number'] . ' LIMIT ' . $pageFirstResult . ',' . $resultsPerPage);

        //!!!! faire des transacttions quand on fait des SELECT différents

        $prout = 'SELECT DISTINCT MIN(duration) FROM song WHERE CD_NUMBER = ' . $_GET['CD_NUMBER'];
        $prouti = array_sum($prout[i]);
        $prouta = min($prout);
        $prouton = max($prout);

        echo $prouti;
        echo $prouta;
        echo $prouton;

         while($row = $req->fetch()) {
            echo "
            <tr class='bg-white border-b hover:bg-gray-50'>
               <th scope='row' class='px-6 py-4 font-medium text-gray-900'>
                  ".$row['']."
               </th>
               <td class='px-6 py-4'>
                  ".$row['']."
               </td>
               <td class='px-6 py-4'>
                  ".$row['']."
               </td>
               <td class='px-6 py-4'>
                  ".$row['GENRE']."
               </td>
            </tr>
            ";
         }
    ?>
    </tbody>
    </div>
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