<div class="w-full mx-auto bg-white border-b 2xl:max-w-7xl">
   <div x-data="{ open: false }"
      class="relative flex flex-col w-full p-5 mx-auto bg-white md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
      <div class="flex flex-row items-center justify-between lg:justify-start">
         <a class="text-lg tracking-tight text-black uppercase focus:outline-none focus:ring lg:text-2xl" href="/">
            <span class="lg:text-lg uppecase focus:ring-0">
               WENDY
            </span>
         </a>
         <button @click="open = !open"
            class="inline-flex items-center justify-center p-2 text-gray-400 hover:text-black focus:outline-none focus:text-black md:hidden">
            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
               <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
               <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
         </button>
      </div>
      <nav :class="{'flex': open, 'hidden': !open}"
         class="flex-col items-center flex-grow hidden md:pb-0 md:flex md:justify-end md:flex-row">
         <?php 
         if ($currentPage == 'index') {
            echo "<a class='px-2 py-2 text-sm text-blue-500 lg:px-6 md:px-3 hover:text-gray-500' aria-current='page' href='/index.php'>A propos</a>";
         } else {
            echo "<a class='px-2 py-2 text-sm text-gray-500 lg:px-6 md:px-3 hover:text-blue-600' href='/index.php'>A propos</a>";
         }
         ?>

         <?php 
         if (isset($_SESSION['login']) && $currentPage == 'dashboard') {
            echo "<a class='px-2 py-2 text-sm text-blue-500 lg:px-6 md:px-3 hover:text-gray-500' aria-current='page' href='dashboard/overview.php'>Dashboard</a>";
         } else if (isset($_SESSION['login']) && $currentPage != 'dashboard') {
            echo "<a class='px-2 py-2 text-sm text-gray-500 lg:px-6 md:px-3 hover:text-blue-600' href='dashboard/overview.php'>Dashboard</a>";
         }
         ?>

         <div class="inline-flex items-center gap-2 list-none lg:ml-auto">
            <?php
               // If signed in log out button
               if (isset($_SESSION['login'])) {
                  ?>
            <form method="post" action="login.php">
               <p>
                  <input type="hidden" name="disconnect" value="yes">
                  <input class="bg-blue-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit"
                     value="Se déconnecter">
               </p>
            </form>
            <?php
               } else {
               ?>
            <a class='px-4 py-2 mt-2 text-sm text-gray-500 md:mt-0 hover:text-blue-600 focus:outline-none focus:shadow-outline'
               href='login.php'>Sign in</a>
            <?php
               }
            ?>
         </div>
      </nav>
   </div>
   <?php
      // if on dashboard page show this
      if($currentPage == 'dashboard') {
      ?>
   <div
      class="flex flex-row w-full px-8 overflow-y-auto border-t whitespace-nowrap scroll-hidden md:px-6">
      <a class="py-4 pr-2 text-sm text-gray-500 transition ease-in-out transform border-b-2 border-transparent duration-650 focus:outline-none focus:shadow-none md:my-0 hover:border-blue-500 hover:text-blue-600"
         href="/dashboard/overview.php">
         Aperçu général
      </a>
      <a class="px-2 py-4 text-sm text-gray-500 transition ease-in-out transform border-b-2 border-transparent duration-650 focus:outline-none focus:shadow-none md:my-0 hover:border-blue-500 hover:text-blue-600"
         href="/dashboard/locations.php">
         Lieux
      </a>
      <a class="px-2 py-4 text-sm text-gray-500 transition ease-in-out transform border-b-2 border-transparent duration-650 focus:outline-none focus:shadow-none md:my-0 hover:border-blue-500 hover:text-blue-600"
         href="#">
         CD
      </a>
      <a class="px-2 py-4 text-sm text-gray-500 transition ease-in-out transform border-b-2 border-transparent duration-650 focus:outline-none focus:shadow-none md:my-0 hover:border-blue-500 hover:text-blue-600"
         href="#">
         Evénements
      </a>
   </div>
   <?php
      }
   ?>
</div>