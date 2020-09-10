<?php

if ( !isset($_FILES["profile"]) || $_FILES["profile"]["error"] != 0) {
   $invalid = "No File" ;
} else {

    $filename = $_FILES["profile"]["name"] ;
    $bytes = $_FILES["profile"]["size"] ;
    $tmp_file = $_FILES["profile"]["tmp_name"] ;

    $extension = strtolower( pathinfo($filename, PATHINFO_EXTENSION) ) ;
    $whitelist = ["gif", "jpg", "png", "jpeg", "bmp"] ;
    if ( !in_array($extension, $whitelist)){
        $invalid = "extension error" ;
    }

    if ( !preg_match("/^[\w.]+$/u", $filename)) {
        $invalid = "filename invalid" ; 
    } 

    if ( $bytes > 1024 * 1024) {
        $invalid = "size error" ;
    }

    $profile = sha1("bms" . uniqid()) . "_" . $filename ;

    if ( !isset($invalid) && move_uploaded_file($tmp_file , "img/upload/$profile")) {
        $success = true ; 
    }

}