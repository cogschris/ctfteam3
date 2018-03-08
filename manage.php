<?php
require 'config.php';

if(!isset($_COOKIE["username"]) || !isset($_COOKIE["hash"]) || !isset($_GET['action']) || empty($_GET['action'])) :
    echo "make sure to log in and designate an action!!";

else :




  $check = "SELECT hash FROM " . TB_NAME . " WHERE username = '" . $_COOKIE["username"] . "';";
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);








    if ($mysqli->connect_errno ) :
              echo "Connection Error: ";
              echo $mysqli->connect_error;
    else :


  $results = $mysqli->query($check);
  // TODO: Check for SQL Error.
  if ($results->num_rows > 0) :
    // Found email or username in the DB.
    $row = $results->fetch_assoc();
    if ($row['hash'] == $_COOKIE["hash"]) {


      $user = $_COOKIE["username"];
      $hashes = $_COOKIE["hash"];
      setcookie("username", $user, time() + (300), "/");
      setcookie("hash", $hashes, time() + (300), "/");

      $command = strtolower($_GET['action']);
      if ($command == "deposit") {
        deposit();
      } elseif ($command == "withdraw") {
        withdraw();
      } elseif ($command == "balance") {
        balance();
      } elseif ($command == "close") {
        close();
      }

    }
    else {
      badlogin();

    }

else:

  badcookie();


 ?>




<?php
endif;
endif;
endif;

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


      function deposit() {
        if (amount()) {

          if (is_numeric($_GET['amount'])) {

          if ($_GET['amount'] > 0) {
            $sqls = "Update ". TB_NAME . " SET balance = balance + " . $_GET['amount'] . "
            WHERE username = '" . $_COOKIE["username"] . "';";

             update($sqls);
          //   ]

          }
        }
        }

      }

      function withdraw() {

      }

      function balance() {

      }

      function close() {

      }
      
      function goodlogin() {
        echo "Login Successful";
      }

      function badlogin() {
        echo "Login Unsuccessful";
      }

      function badcookie() {
        echo "Cookie went stale, login again to get a new one.";
      }

      function amount() {
        if (!isset($_GET['amount']) || empty($_GET['amount'])) {
          echo "Make sure to specify an amount!";
          return false;
        }
        return true;
      }

      function update($sql_statment) {

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno ) :
                  echo "Connection Error: ";
                  echo $mysqli->connect_error;
        else :

          $results = $mysqli->query($sql_statment);
          if (!$results) :
              			echo $mysqli->error;

          else :


            ?>
              <h3>Action successfully made!</h3>
            <?php
          endif;
        endif;
      }







    ?>


 </body>

 </html>
