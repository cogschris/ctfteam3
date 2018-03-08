<?php


require 'config.php';



if (!isset($_GET['user']) || empty($_GET['user']) || !isset($_GET['pass']) || empty($_GET['pass'])) :
  echo "Make sure all relevant fields are filled";

else :

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);



 ?>


<html>

<head>
  <meta charset="utf-8">
  <title>Register</title>
  <meta name="author" content="">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">


</head>

<body>
  <?php




  if ($mysqli->connect_errno ) :
            echo "Connection Error: ";
            echo $mysqli->connect_error;
  else :



    $username = mysqli_real_escape_string($mysqli, $_GET['user']);
    $password = mysqli_real_escape_string($mysqli, $_GET['pass']);
    $hash = hash('sha256', $password);


    if ((strpos($_GET['user'], "+")) || strpos($_GET['user'], "%20")) :
      echo "Make sure your username does not have any spaces in it!";


    else :

      $check = "SELECT username FROM " . TB_NAME . " WHERE username = '" . $username . "';";
      

		$results = $mysqli->query($check);
		// TODO: Check for SQL Error.
		if ($results->num_rows > 0) :
			// Found email or username in the DB.
			echo "Username or email already registered.";

    else:
      $sql = "INSERT INTO " . TB_NAME . " (username, password, hash, balance)
              VALUES ( '" . $username  . "' , '". $password . "', '". $hash . "', 0);";

      $results = $mysqli->query($sql);
  		if (!$results) :
  			echo $mysqli->error;

  		else :
        ?>
          <h3>Registration successful!</h3>
        <?php
      endif;
    endif;
  endif;
endif;


   ?>

</body>

</html>

<?php endif; ?>
