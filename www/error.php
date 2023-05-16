<?php
$status = $_SERVER['REDIRECT_STATUS'];
$codes = array(
       400 => array('400 - Bad Request', 'The request cannot be fulfilled due to bad syntax.'),
       401 => array('401 - Unauthorized', 'The requested page requires higher privileges.'),
       402 => array('402 - Unprocessable Entity', 'The request was well-formed but was unable to be followed due to semantic errors.'),
       403 => array('403 - Forbidden', 'The server has refused to fulfill your request.'),
       404 => array('404 - Not Found', 'The document/file requested was not found on this server.'),
       405 => array('405 - Method Not Allowed', 'The method specified in the Request-Line is not allowed for the specified resource.'),
       408 => array('408 - Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
       500 => array('500 - Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
       502 => array('502 - Bad Gateway', 'The server received an invalid response from the upstream server while trying to fulfill the request.'),
       503 => array('503 - Service Unavailable', 'The server is temporarily unable to service your request due to maintenance downtime or capacity problems. Please try again later.'),
       504 => array('504 - Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
);
$currentPage = 'index';
$title = $codes[$status][0];
$message = $codes[$status][1];
if ($title == false || strlen($status) != 3) {
       $message = 'Please supply a valid status code.';
}

require_once('head.php');
?>

<div class="flex min-h-screen bg-black">
   <div class="flex flex-col justify-center flex-1 px-8 py-8 md:px-12 lg:flex-none lg:px-24">
      <div class="w-full mx-auto lg:max-w-6xl">
         <div class="max-w-xl lg:p-10">
            <div>

               <p class="text-4xl text-white ">
                  Error <?php echo($title); ?>
               </p>
               <p class="max-w-xl mt-4 text-lg tracking-tight text-gray-400">
                  <?php echo($message); ?>
               </p>
            </div>
            <div class="flex gap-3 mt-10"><a href="/index.php"><button class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
  <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
      Take me back
  </span>
</button></a>
            </div>
         </div>
      </div>
   </div>
   <div class="relative flex-1 hidden w-0 lg:block">
      <video autoplay="" class="absolute z-10 w-auto min-w-full min-h-full bg-white max-w-none" loop="" muted="">
         <source src="https://buio.lexingtonthemes.com/images/placeholders/gradient.mp4" type="video/mp4">
         Your browser does not support the video tag.
      </video>
   </div>
</div>