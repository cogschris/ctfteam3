<?php
  if(isset($_COOKIE["username"]) || isset($_COOKIE["hash"])) {
      setcookie("username", "", time() - 3600);
      setcookie("hash", "", time() - 3600);
      echo "Logged out!";
  } else {
    echo "Please Log in first to logout!";
 }




?>
