<?php session_start();
$title = 'Tableau de bord : Événements';
$currentPage = 'dashboard'; 
define('__ROOT__', dirname(dirname(__FILE__)));
date_default_timezone_set('Europe/Brussels');
require_once(__ROOT__.'/head.php');
$resultsPerPage = 4;
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

<?php
    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = $_GET['page'];  
    }  

    $today = date("Y-m-d");

    $pageFirstResult = ($page-1) * $resultsPerPage;

    $rows_nb = $bdd->query('SELECT COUNT(*) FROM event WHERE DATE > "' . $today . '"')->fetchColumn();

    $page_nb = ceil($rows_nb / $resultsPerPage); 

    $req = $bdd->query('SELECT ID, NAME, DATE from event WHERE DATE > "' . $today . '" ORDER BY DATE DESC, NAME ASC LIMIT ' . $pageFirstResult . ',' . $resultsPerPage);

?>
<div class="ml-80 mr-80 mt-2 px-6 py-6 lg:px-8">
      <!-- title -->
      <h2 class="text-xl font-medium text-gray-900">Liste des événements à venir</h2>
      <h3 class="text-s font-medium text-gray-500 mb-4">Détails et modification des événements à venir</h3>

   <div class="relative overflow-x-auto sm:rounded-lg mt-10 ml-80 mr-80">
      <h2 class="text-xl font-medium text-gray-900">Modifier un événement</h2>
      <h3 class="text-md font-medium text-gray-500 mb-4">Appuyer un événement pour le modifier</h3>

   <?php
        while ($row = $req->fetch()) {
    ?>
        <div class="flex flex-col items-center justify-center p-6 mb-4 bg-white border-2 border-blue-500 rounded-lg shadow-lg cursor-pointer" onclick="location.href='event_editor.php?id=<?php echo $row['ID']; ?>'">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2 text-center"><?php echo htmlspecialchars($row['NAME']); ?></h2>
            <p class="text-gray-500"><?php echo htmlspecialchars(date('l j F Y', strtotime($row['DATE']))); ?></p>
        </div>
    <?php
        }
    ?>

    <div class="mt-6">
    <nav>
        <ul class="list-style-none flex justify-center items-center">
            <?php
            for($i = 1; $i<= $page_nb; $i++) {
                if($i == $page){
                    echo '<li>
                    <a
                    class="relative block rounded bg-blue-100 px-3 py-1.5 text-sm font-medium text-primary-700 transition-all duration-300"
                    href = "update_eventBoard.php?page=' . $i . '"> ' . $i . ' <span
                    class="absolute -m-px h-px w-px overflow-hidden whitespace-nowrap border-0 p-0 [clip:rect(0,0,0,0)]"
                    >(current)</span></a>
                    </li>';
                } else {
                echo '<li>
                    <a class="relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100"
                        href = "update_eventBoard.php?page=' . $i . '">' . $i . ' </a>
                </li>';
                }
            }
            ?>
        </ul>
        </nav>
    </div>

</div>

</body>