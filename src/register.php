<?php

if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    require "db.php" ;
    
    extract($_POST) ;
    try {
        
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        $sql = "insert into user ( name, email, password, bday, profile) values (?,?,?,?,?)" ;
        $stmt = $db->prepare($sql);
        $hash_password = password_hash($password, PASSWORD_DEFAULT) ;
        $stmt->execute([$name, $email, $hash_password, NULL, "default.jpg"]);

        addMessage("Registered successfuly");
        header("Location: ?page=loginForm") ;
        exit ;

    } catch(PDOException $ex) {
       addMessage("Try Again!") ;
       header("Location: ?page=registerForm");
       exit;
    }
}
