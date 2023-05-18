<?php session_start();
$title = 'Tableau de bord : cd';
$currentPage = 'dashboard';
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__ . '/head.php');
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
   $trackNumber = $_GET['track_number'];
   $cdNumber = $_GET['cd_number'];
   $req = $bdd->query('SELECT * FROM song WHERE TRACK_NUMBER = ' . $trackNumber . ' AND CD_NUMBER = ' . $cdNumber);
   $row = $req->fetch();
   if (empty($row)) {
      echo "<div class='ml-80 mr-80 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
      <p class='font-bold'>Erreur</p>
      <p>La chanson n'a pas été trouvée. (TRACK_NUMBER :" . $trackNumber . ")</p>
    </div>";
   } else {
      if ($_POST['action'] == 'edit') {
         $sql = "UPDATE song SET TRACK_NUMBER = :new_track_number, TITLE = :title, ARTIST = :artist, DURATION = :duration, GENRE = :genre WHERE TRACK_NUMBER = :track_number AND CD_NUMBER = :cd_number";
         $sth = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
         $res = $sth->execute(array(
            ':new_track_number' => $_POST['track_number'],
            ':title' => $_POST['title'],
            ':artist' => $_POST['artist'],
            ':duration' => $_POST['duration'],
            ':genre' => $_POST['genre'],
            ':track_number' => $trackNumber,
            ':cd_number' => $cdNumber
         ));
         // Check if id has changed : if so change $id and the url
         if ($_POST['track_number'] != $trackNumber && $res) {
            $trackNumber = $_POST['track_number'];
            echo "<script type='text/javascript'>document.location.replace('/dashboard/edit-song.php?track_number=" . $trackNumber . "');</script>";
         }

         if ($res) {
            echo "<div class='ml-80 mr-80 bg-green-100 border-l-4 border-green-500 text-green-700 p-4' role='alert'>
            <p class='font-bold'>Succès</p>
            <p>La chanson a été modifiée.</p>
            </div>";
            $req = $bdd->query('SELECT * FROM song WHERE TRACK_NUMBER = ' . $trackNumber . ' AND CD_NUMBER = ' . $cdNumber);
            $row = $req->fetch();
         } else {
            echo "<div class='ml-80 mr-80 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
            <p class='font-bold'>Erreur</p>
            <p>La chanson n'a pas pu être modifiée.</p>
            <p>Ce message peut vous aider à résoudre votre erreur : [code " . $sth->errorInfo()[0] . "] `" . $sth->errorInfo()[2] . "´.</p>
            </div>";
         }
      }
   ?>
      <div class="ml-80 mr-80 mt-2 px-6 py-6 lg:px-8">
         <div class="flex content-center items-center">
            <div class="basis-1/12">
               <button onclick="document.location.replace('/dashboard/edit-cd.php?cd_number=<?php echo $cdNumber; ?>')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm px-3 py-5 inline-flex items-center">
                  <i class="fa-solid fa-angle-left fa-2xl"></i>
                  <span class="sr-only">Retour</span>
               </button>
            </div>
            <div class="basis-11/12 ml-2">
               <h3 class="text-xl font-medium text-gray-900">Modifier la Chanson</h3>
            </div>
         </div>
         <form id="form" method="post" class="mt-3 space-y-6" action="#">
            <div>
               <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Titre*</label>
               <input type="text" name="title" id="title" value="<?php echo $row['TITLE']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>
            <div class="flex space-x-8">
               <div class="basis-1/2">
                  <label for="artist" class="block mb-2 text-sm font-medium text-gray-900">Artist*</label>
                  <input type="text" name="artist" id="artist" value="<?php echo $row['ARTIST']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
               </div>
               <div class="basis-1/2">
                  <label for="duration" class="block mb-2 text-sm font-medium text-gray-900">Duration*</label>
                  <input type="text" name="duration" id="duration" value="<?php echo $row['DURATION']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required maxlength="8">
               </div>
            </div>
            <div>
               <label for="GENRE" class="block mb-2 text-sm font-medium text-gray-900">Genre*</label>
               <input type="text" name="genre" id="genre" value="<?php echo $row['GENRE']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>
            <div>
               <label for="TRACK_NUMBER" class="block mb-2 text-sm font-medium text-gray-900">Numéro de piste*</label>
               <input type="text" name="track_number" id="track_number" value="<?php echo $row['TRACK_NUMBER']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>
            <div>
               <input type="hidden" name="action" value="edit">
               <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Editer</button>
            </div>
         </form>
      </div>

   <?php
   }
   ?>
   <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>

</html>