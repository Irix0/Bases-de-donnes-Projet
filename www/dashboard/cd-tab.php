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

   $cdNumber = $_GET['cd_number'];
   /*if(isset($_GET['cd_number']))
      $cdNumber = $_GET['cd_number'];
   else {
      echo "<div class='ml-80 mr-80 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
      <p class='font-bold'>Mauvais accès</p>
      <p>Les accès directs à cette page sont interdits.</p>
      </div>";
      die();
   }*/
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
               Numéro de CD
            </th>
            <th scope="col" class="w-1/12 px-6 py-3">
               Titre
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
         //$rows_nb = $bdd->query('SELECT COUNT(*) FROM song WHERE CD_NUMBER =' . $cdNumber)->fetchColumn();
         $rows_nb = $bdd->query('SELECT COUNT(*) FROM cd')->fetchColumn();

         $page_nb = ceil($rows_nb / $resultsPerPage);

         //vaut mieux éviter le GET (sinon il faut faire un prepare absolument)
         //$req = $bdd->query('SELECT DISTINCT * FROM cd INNER JOIN song ON cd.CD_NUMBER = song.CD_NUMBER WHERE cd.CD_NUMBER = ' . $_GET['cd_number'] . ' LIMIT ' . $pageFirstResult . ',' . $resultsPerPage);

        //!!!! faire des transacttions quand on fait des SELECT différents

        $prout = $bdd->query("SELECT cd_number, TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(DURATION))), '%H:%i:%s') AS tot, MIN(DURATION) as min, MAX(DURATION) as max, TIME_FORMAT(SEC_TO_TIME(AVG(TIME_TO_SEC(DURATION))), '%H:%i:%s') as avg FROM song GROUP BY cd_number");
 
        while($row = $prout->fetch()) {
         echo "
         <tr class='bg-white border-b hover:bg-gray-50'>
            <td scope='row' class='px-6 py-4 font-medium text-gray-900'>
               ".$row['CD_NUMBER']."
            </td>
            <th class='px-6 py-4'>
               ".$row['TITLE']."
            </th>
            <th class='px-6 py-4'>
               ".$row['tot']."
            </th>
            <th class='px-6 py-4'>
               ".$row['min']."
            </th>
            <th class='px-6 py-4'>
               ".$row['max']."
            </th>
            <th class='px-6 py-4'>
               ".$row['avg']."
            </th>
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