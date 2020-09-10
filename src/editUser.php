<?php
   require "db.php" ;
   
   $currPage =  $_SESSION["currentPage"];
   $currCat = $_SESSION["currentCategory"];
   
    if( isset($_POST['editUser'])) {
     require "uploadFile.php" ; 
     
            if (!isset($success)) 
                $profile = $_SESSION["user"]["profile"];
            if(isset($_POST["password"]) && $_POST["password"] != "") 
                $password = password_hash($_POST["password"], PASSWORD_DEFAULT) ;
            else 
                $password = $_SESSION["user"]["password"];
            
     try {
          $id = $_POST["id"] ;
          $name = $_POST["name"] ;
          $email = $_POST["email"] ;
          $bday = $_POST["bday"] ?? $_SESSION["user"]["bday"];
          
          $name = filter_var($name, FILTER_SANITIZE_STRING);
          $email = filter_var($email, FILTER_SANITIZE_EMAIL);
          $bday = filter_var($bday, FILTER_SANITIZE_STRING);
          
          $sql = "update user set name=?, email=?, password=?, bday=?, profile=? where id = ?" ;
          $stmt = $db->prepare($sql) ;
          $stmt->execute([$name, $email, $password, $bday, $profile, $id]);
        
          $user = [  "id" => $id, "name" => $name, "email" => $email, "password" => $password, "bday" => $bday,  "profile" => $profile];
      
        $_SESSION["user"] = $user ; //update session information for User
        addMessage("User information is updated!") ;
        header("Location: index.php?cat=$currCat&pageNum=$currPage");
        exit ;
     
     } catch(PDOException $ex) {
        addMessage("Error!") ;
     }

  } 
  
?>
<head>

  <style>
    h1.card-panel { margin-bottom: 1em ; }
    #toast-container {
      top: auto !important ;
      bottom: 10% !important ;
      left: 40% !important ;
      right: auto !important ;
    }

    .mt-4 {margin-top: 4em ;}
    .circle { width: 100px; height: 100px;}
    .container{ width: 40%;  height: 40%; }
 
  </style>
</head>
<body>
  <div class="container" style="margin-top:2em;">
    <div class="center">
       <img src="img/upload/<?= $_SESSION["user"]["profile"] ?>" class="circle">
    </div>
    <form method="post" enctype="multipart/form-data">

     <input type="hidden" name="profile" value="<?= $_SESSION["user"]["profile"] ?>" >
    
     <div class="input-field">
        <input id="user_id" type="text" name="id" value="<?= $_SESSION["user"]["id"] ?>" readonly>
        <label for="user_id">ID</label>
      </div>
     
      <div class="input-field">
        <input id="user_name" type="text" name="name" value="<?= $_SESSION["user"]["name"] ?>">
        <label for="user_name">Full Name</label>
      </div>

      <div class="input-field">
        <input id="user_email" type="text" name="email" value="<?= $_SESSION["user"]["email"] ?>">
        <label for="user_email">Email</label>
      </div>

      <div class="input-field">
        <input placeholder="Enter your Birthday" id="bday" type="text" class="datepicker" name="bday" value="<?= $_SESSION["user"]["bday"]?>">
        <label for="user_bday">Birthday</label>
      </div>
     <div class="input-field">
        <input placeholder="Enter a new password" id="newPassword" type="text" name="password" >
        <label for="newPassword">New Password</label>
      </div>

      <div class="file-field input-field"  style="width: 50%;">
        <div class="btn">
          <span>Upload</span>
          <input type="file" name="profile">
        </div>
        <div class="file-path-wrapper">
          <input placeholder="Upload new profile picture" class="file-path validate" type="text">
        </div>
    </div>

      <div class="input-field">
        <button class="btn waves-effect waves-light right" type="submit" name="editUser">Update
          <i class="material-icons right">send</i>
        </button>
      </div>


    </form>
    <div class="mt-4">
        <a href="index.php?pageNum<?=$currPage?>"><i class="material-icons left">arrow_left</i>Main Page</a>
      </div>

  </div>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
      var options = {
            format: 'yyyy-mm-dd',
            yearRange: 15,
            defaultDate: new Date(2000, 01, 01),
            minDate: new Date(1920, 01, 01),
            maxDate: new Date(2010, 01, 01)
            
        };
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems, options);
  });
</script>
 