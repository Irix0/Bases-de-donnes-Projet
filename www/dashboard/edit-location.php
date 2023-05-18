<?php session_start();
$title = 'Tableau de bord : lieux';
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
   $id = $_GET['id'];
   $req = $bdd->query('SELECT * FROM location WHERE ID = ' . $id);
   $row = $req->fetch();
   if (empty($row)) {
      echo "
         <div class='2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
            <p class='font-bold'>Erreur</p>
            <p>Le lieu n'a pas été trouvé. (ID :" . $id . ")</p>
         </div>";
   } else {
      if ($_POST['action'] == 'edit') {
         $sql = "UPDATE location SET ID= :new_id, STREET = :street, CITY = :city, POSTAL_CODE = :postal_code, COUNTRY = :country WHERE ID = :id";
         $sth = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
         $res = $sth->execute(array(
            ':new_id' => $_POST['id'],
            ':street' => $_POST['street'],
            ':city' => $_POST['city'],
            ':postal_code' => $_POST['zip'],
            ':country' => $_POST['country'],
            ':id' => $id
         ));
         // Check if id has changed : if so change $id and the url
         if ($_POST['id'] != $id && $res) {
            $id = $_POST['id'];
            echo "<script type='text/javascript'>document.location.replace('/dashboard/edit-location.php?id=" . $id . "');</script>";
         }

         if ($res) {
            echo "
               <div class='2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 bg-green-100 border-l-4 border-green-500 text-green-700 p-4' role='alert'>
                  <p class='font-bold'>Succès</p>
                  <p>Le lieu a été modifié.</p>
               </div>";
            $req = $bdd->query('SELECT * FROM location WHERE ID = ' . $id);
            $row = $req->fetch();
         } else {
            echo "
               <div class='2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                  <p class='font-bold'>Erreur</p>
                  <p>Le lieu n'a pas pu être modifié.</p>
                  <p>Ce message peut vous aider à résoudre votre erreur : [code " . $sth->errorInfo()[0] . "] `" . $sth->errorInfo()[2] . "´.</p>
               </div>";
         }
      }
   ?>
   <div class="2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 mt-2 px-6 py-6 lg:px-8">
      <div class="flex content-center items-center">
         <div class="basis-1/12">
            <button onclick="document.location.replace('/dashboard/locations.php')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm px-3 py-5 inline-flex items-center">
               <i class="fa-solid fa-angle-left fa-2xl"></i>
               <span class="sr-only">Retour</span>
            </button>
         </div>
         <div class="basis-11/12 ml-2">
            <h3 class="text-xl font-medium text-gray-900">Editer un lieu</h3>
         </div>
      </div>
      <form id="form" method="post" class="mt-3 space-y-6" action="#">
         <div>
            <label for="street" class="block mb-2 text-sm font-medium text-gray-900">Rue*</label>
            <input type="text" name="street" id="street" value="<?php echo $row['STREET']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
         </div>
         <div class="flex space-x-8">
            <div class="basis-1/2">
               <label for="city" class="block mb-2 text-sm font-medium text-gray-900">Ville*</label>
               <input type="text" name="city" id="city" value="<?php echo $row['CITY']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            </div>
            <div class="basis-1/2">
               <label for="zip" class="block mb-2 text-sm font-medium text-gray-900">Code
                  postal*</label>
               <input type="text" name="zip" id="zip" value="<?php echo $row['POSTAL_CODE']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required maxlength="8">
            </div>
         </div>
         <div>
            <label for="country" class="block mb-2 text-sm font-medium text-gray-900">Pays*</label>
            <input type="text" name="country" id="country" value="<?php echo $row['COUNTRY']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
         </div>
         <div>
            <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">Commentaire</label>
            <textarea id="comment" rows="4" name="comment" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Ajouter un commentaire"><?php echo $row['COMMENT']; ?></textarea>
         </div>
         <div>
            <label for="id" class="block mb-2 text-sm font-medium text-gray-900">ID</label>
            <input type="number" name="id" id="id" value="<?php echo $row['ID']; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
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