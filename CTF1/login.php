<?php
require 'config.php';

if (!isset($_GET['user']) || empty($_GET['user']) || !isset($_GET['pass']) || empty($_GET['pass'])) :
  echo "Make sure all relevant fields are filled";

else :


if(isset($_COOKIE["username"]) || isset($_COOKIE["hash"])) {
    setcookie("username", "", time() - 3600);
    setcookie("hash", "", time() - 3600);
}



$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);








  if ($mysqli->connect_errno ) :
            echo "Connection Error ";
            //echo $mysqli->connect_error;
  else :
    $username = mysqli_real_escape_string($mysqli, $_GET['user']);
    $password = mysqli_real_escape_string($mysqli, $_GET['pass']);
    $hash = hash('sha256', $password);


    if ((strpos($_GET['user'], "+")) || strpos($_GET['user'], "%20")) :
      echo "Make sure your username does not have any spaces in it!";


    else :
      $sql = "SELECT username, password, hash FROM  ". TB_NAME ."
              WHERE username = '" . $username ."';";

      $results = $mysqli->query($sql);
  		if (!$results) :
        //echo $sql;
        //echo "<br>";
  			echo "error";
  		else :
        $row = $results->fetch_assoc();
?>
        <html>

        <head>
          <meta charset="utf-8">
          <title>Login</title>
          <meta name="author" content="">
          <meta name="description" content="">
          <meta name="viewport" content="width=device-width, initial-scale=1">


        </head>

        <body>
          <?php
          if ($row['password'] != $password || $row['hash'] != $hash ||  hash('sha256', $row['password']) != $row['hash']) :

           ?>

          <h3>Login failed! Try again</h3>
     <?php    else:


         setcookie("username", $username, time() + (300), "/");
         setcookie("hash", $hash, time() + (300), "/");?>
       <h3>Login successful!</h3>


     </body>

     </html>

<?php


      endif;
      endif;
    endif;
  endif;


   ?>

   <?php endif; ?>
