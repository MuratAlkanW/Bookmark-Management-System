<?php

  unset($_SESSION["user"]);
  $_SESSION = [] ;

  session_destroy(); 
  setcookie("PHPSESSID", "", 1, "/") ;
  setcookie("status", "", 1, "/") ;
  
  header("Location: index.php") ;
  
  ?>
 