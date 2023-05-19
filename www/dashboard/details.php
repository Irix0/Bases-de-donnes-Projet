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
    $query = 'SELECT event.name AS event_name, event.date AS DATE, event.description AS DESCRIPTION, event.rental_fee AS RENTAL_FEE, event.type AS TYPE,
                client.first_name AS client_firstname, client.last_name AS client_lastname, 
                manager.firstname AS manager_firstname, manager.lastname AS manager_lastname, 
                event_planner.firstname AS planner_firstname, event_planner.lastname AS planner_lastname, 
                dj.firstname AS dj_firstname, dj.lastname AS dj_lastname, 
                theme.name AS theme_name, playlist.name AS playlist_name,
                location.street as STREET, location.city as CITY, location.postal_code as POSTAL_CODE, location.COUNTRY as COUNTRY
                FROM event
                INNER JOIN client ON event.CLIENT = client.CLIENT_NUMBER
                INNER JOIN employee AS manager ON event.MANAGER = manager.ID
                INNER JOIN employee AS event_planner ON event.EVENT_PLANNER = event_planner.ID
                INNER JOIN employee AS dj ON event.DJ = dj.ID
                INNER JOIN theme ON event.THEME = theme.NAME
                INNER JOIN location ON event.LOCATION = location.ID
                INNER JOIN playlist ON event.PLAYLIST = playlist.NAME
                WHERE event.ID = :id';
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);


    if (empty($row)) {
        echo "<div class='2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
      <p class='font-bold'>Erreur</p>
      <p>L'événement n'a pas été trouvé. (ID :" . $id . ")</p>
    </div>";
    }
    ?>
    <div class="2xl:mx-80 xl:mx-60 lg:mx-20 md:mx-10 mt-2 px-6 py-6 lg:px-8">
        <div class="flex content-center items-center">
            <div class="basis-1/12">
                <button onclick="document.location.replace('/dashboard/event.php')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm px-3 py-5 inline-flex items-center">
                    <i class="fa-solid fa-angle-left fa-2xl"></i>
                    <span class="sr-only">Retour</span>
                </button>
            </div>
            <div class="basis-11/12 ml-2">
                <h3 class="text-xl font-medium text-gray-900">Détails de l'événement</h3>
            </div>
        </div>
        <div class="mt-3 space-y-6">
            <!-- Name -->
            <div>
                <h4 class="block mb-2 text-sm font-medium text-gray-900">Nom de l'événement:</h4>
                <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"><?php echo $row['event_name']; ?></p>
            </div>
            <!-- Date -->
            <div>
                <h4 class="block mb-2 text-sm font-medium text-gray-900">Date de l'événement:</h4>
                <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"><?php echo date('l j F Y', strtotime($row['DATE'])); ?></p>
            </div>
            <!-- Client -->
            <div>
                <h4 class="block mb-2 text-sm font-medium text-gray-900">Client:</h4>
                <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    <?php echo $row['client_firstname'] . " " . $row['client_lastname']; ?>
            </div>
            <!-- Manager, Event planner, DJ -->
            <div class="flex space-x-4">
                <!-- Manager -->
                <div class="w-1/3">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Manager:</label>
                    <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                        <?php echo $row['manager_firstname'] . " " . $row['manager_lastname']; ?>
                    </p>
                </div>
                <!-- Event planner -->
                <div class="w-1/3">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Planificateur d'événement:</label>
                    <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                        <?php echo $row['planner_firstname'] . " " . $row['planner_lastname']; ?>
                    </p>
                </div>
                <!-- DJ -->
                <div class="w-1/3">
                    <label class="block mb-2 text-sm font-medium text-gray-900">DJ:</label>
                    <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                        <?php echo $row['dj_firstname'] . " " . $row['dj_lastname']; ?>
                    </p>
                </div>
            </div>
            <!-- Theme, Playlist -->
            <div class="flex space-x-4">
                <!-- Theme -->
                <div class="w-1/2">
                    <h4 class="block mb-2 text-sm font-medium text-gray-900">Thème:</h4>
                    <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        <?php echo $row['theme_name']; ?>
                    </p>
                </div>
                <!-- Playlist -->
                <div class="w-1/2">
                    <h4 class="block mb-2 text-sm font-medium text-gray-900">Playlist:</h4>
                    <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        <?php echo $row['playlist_name']; ?>
                    </p>
                </div>
            </div>
            <!-- Location -->
            <div>
                <h4 class="block mb-2 text-sm font-medium text-gray-900">Lieu:</h4>
                <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    <?php echo $row['STREET'] . ", " . $row['POSTAL_CODE'] . " " . $row['CITY'] . ", " . $row['COUNTRY']; ?>
                </p>
            </div>
            <!-- Type and Rental fee-->
            <div class="flex space-x-4">
                <!-- Type -->
                <div class="w-1/2">
                    <h4 class="block mb-2 text-sm font-medium text-gray-900">Type:</h4>
                    <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        <?php
                        echo $row['TYPE'];
                        ?>
                    </p>
                </div>
                <!-- Rental fee -->
                <div class="w-1/2">
                    <h4 class="block mb-2 text-sm font-medium text-gray-900">Coût:</h4>
                    <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        <?php
                        echo $row['RENTAL_FEE'] . " €";
                        ?>
                    </p>
                </div>
            </div>
            <!-- Description -->
            <div>
                <h4 class="block mb-2 text-sm font-medium text-gray-900">Description de l'événement:</h4>
                <p class="cursor-not-allowed block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"><?php echo $row['DESCRIPTION']; ?></p>
            </div>
            <!-- ID -->
            <div>
                <h4 class="block mb-2 text-sm font-medium text-gray-900">ID:</h4>
                <p class="cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"><?php echo $id ?></p>
            </div>
        </div>
    </div>


    <script src="https://kit.fontawesome.com/526a298db9.js" crossorigin="anonymous"></script>
</body>

</html>