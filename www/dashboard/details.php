<link rel="stylesheet" href="details.css">

<body>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
  <div class="px-4 py-6 sm:px-0">
    <?php
      $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
      $event_id = $_GET['id'];
      $req = $bdd->prepare('SELECT * FROM event WHERE ID = ?');
      $req->execute([$event_id]);
      $event = $req->fetch();
      if (!$event) {
        echo '<p class="text-red-500">Cet événement n\'existe pas.</p>';
        exit;
      }
    ?>
    <h1 class="text-3xl font-bold"><?php echo $event['NAME']; ?></h1>
    <p class="text-lg"><?php echo $event['DESCRIPTION']; ?></p>
    <ul class="list-disc pl-5 mt-4">
      <li>Date : <?php echo $event['DATE']; ?></li>
      <li>Client ID : <?php echo $event['CLIENT']; ?></li>
      <li>Manager ID : <?php echo $event['MANAGER']; ?></li>
      <li>Event Planner ID : <?php echo $event['EVENT_PLANNER']; ?></li>
      <li>DJ ID : <?php echo $event['DJ']; ?></li>
      <li>Thème : <?php echo $event['THEME']; ?></li>
      <li>Type : <?php echo $event['TYPE']; ?></li>
      <li>Location ID : <?php echo $event['LOCATION']; ?></li>
      <li>Prix de location : <?php echo $event['RENTAL_FEE']; ?> € </li>
      <li>Playlist : <?php echo $event['PLAYLIST']; ?></li>
    </ul>
  </div>
</div>

</body>