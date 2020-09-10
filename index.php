<?php
  session_start() ; 

  require "src/helper.php" ;

  $pageGuest = ["home", "login", "loginForm", "register", "registerForm"] ;
  $pageAuth = [
      "html" => ["main",  "editUser"],
      "webservice" => ["delete", "addBM", "logout", "getBM"]
  ] ;

  $pageAll = array_merge($pageGuest, $pageAuth["html"], $pageAuth["webservice"]) ;
  
  $page = $_GET["page"] ?? "home" ;

  if ( authenticated() && !(in_array($page, $pageAuth["html"]) || in_array($page, $pageAuth["webservice"]))) {
      $page = "main" ;
  }

  if (!authenticated() && !in_array($page, $pageGuest)) {
      $page = "loginForm" ;
  }

  if (in_array($page, $pageAuth["webservice"])) {
      header("Content-Type: application/json") ;
      require "src/$page.php" ; 
      exit ;
  }
  
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Murat Alkan | Project</title>
    <link rel="stylesheet" href="css/bms.css">
    <style>
        #toast-container { top: 80%; right: 45%; }
    </style>
</head>
<body>
    <?php require "src/navbar.php" ; ?>
    <?php
       require "src/$page.php" ; 
       displayMessage() ;
    ?>

</body>
</html>