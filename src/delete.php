<?php
  require "db.php" ;
   
   $currCat = $_GET["cat"] ;
   $currPage = $_GET["pageNum"] ;
   $id = $_GET["id"] ;
   
  try {
      $stmt = $db->prepare("delete from bookmark where id = :id") ;
      $stmt->execute(["id" => $id]) ;
      echo json_encode(["message" => "$id deleted"]) ;
  } catch(PDOException $ex) {
      echo json_encode(["error" => "$id delete failed"]) ;
  }

  header("Location: ../index.php?cat=$currCat&pageNum=$currPage");