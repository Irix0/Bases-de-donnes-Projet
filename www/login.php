<?php session_start(); ?>
<?php $title = 'Page de connexion'; ?>
<?php $currentPage = 'login'; ?>
<?php require_once('head.php'); ?>

<body>
   <?php
        require_once('navbar.php');
        //Retirer les variables de session si on s'est déconnecté
        if (isset($_POST['disconnect'])) {
            session_unset();
            // Redirect to home page
            echo "<script> window.location.replace('index.php'); </script>";
        }
        $bdd = new PDO('mysql:host=ms8db;dbname=groupXX', 'groupXX', 'secret');
        if ($bdd == NULL)
        echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
        <p class='font-bold'>Erreur fatale</p>
        <p>Une erreur s'est produite lors de la connexion à la base de données.</p>
        <p>Veuillez contacter l'administrateur.</p>
      </div>";
        if (isset($_POST["login"])) {
            $sql = 'SELECT * FROM users WHERE Login = :login AND Pass = :pass';
            $sth = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

            $sth->execute(array('login' => $_POST["login"], 'pass' => $_POST["pass"]));
            $tuple = $sth->fetchAll();
            $tuple = $tuple[0];

            if ($tuple) {
                $_SESSION['login'] = $tuple["Login"];
            } else
                echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4' role='alert'>
                <p class='font-bold'>Erreur</p>
                <p>Mauvaise combinaison utilisateur/mot de passe.</p>
              </div>";
        }
        if (isset($_SESSION['login'])) {
            echo "<script type='text/javascript'>document.location.replace('dashboard.php');</script>";
        } else {
        ?>

   <section>
      <div class="relative items-center w-full px-5 py-12 mx-auto md:px-12 lg:px-20 max-w-7xl">
         <div class="w-full max-w-md mx-auto md:max-w-sm md:px-0 md:w-96 sm:px-4">
            <div class="flex flex-col">
               <div>
                  <h2 class="text-4xl text-black">Connexion</h2>
               </div>
            </div>
            <form method="post" action="login.php">
               <div class="mt-4 space-y-6">
                  <div class="col-span-full">
                     <label class="block mb-3 text-sm font-medium text-gray-600" name="utilisateur">
                        Utilisateur
                     </label>
                     <input
                        class="block w-full px-6 py-3 text-black bg-white border border-gray-200 rounded-full appearance-none placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                        placeholder="Jean" type="text" name="login">
                  </div>
                  <div class="col-span-full">
                     <label class="block mb-3 text-sm font-medium text-gray-600" name="password">
                        Mot de passe
                     </label>
                     <input
                        class="block w-full px-6 py-3 text-black bg-white border border-gray-200 rounded-full appearance-none placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm"
                        placeholder="******" type="password" name="pass">
                  </div>

                  <div class="col-span-full">
                     <button
                        class="items-center justify-center w-full px-6 py-2.5 text-center text-white duration-200 bg-black border-2 border-black rounded-full nline-flex hover:bg-transparent hover:border-black hover:text-black focus:outline-none focus-visible:outline-black text-sm focus-visible:ring-black"
                        type="submit">
                        Se connecter
                     </button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </section>

   <?php
        }
        ?>
</body>

</html>