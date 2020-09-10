<?php
  $register_link = ["home", "loginForm"] ;
  $login_link = ["home", "registerForm"] ;
  $main_link = ["main"] ;
  $main_link2 = ["main", "editUser"] ;
  
  if(isset($_COOKIE["status"])) {
    setcookie("status", "", 1, "/") ;
  }
?>

<nav class="indigo darken-4">
    <div class="nav-wrapper">
      <a href="index.php" class="brand-logo"><i class="material-icons left hide-on-med-and-down">home</i>BMS</a>
      
      <?php
      $menu_items = [ "desktop" => '<ul id="nav-mobile" class="right hide-on-med-and-down">',];
      ?>

      <?php foreach($menu_items as $type => $menu)  : ?>
          <?= $menu ?>
          <?php if ( in_array($page, $register_link)) : ?>
            <li>
                <a href="?page=registerForm"><i class="material-icons left">person_add</i>Register</a>
            </li>
          <?php endif ?>

          <?php if ( in_array($page, $login_link)) : ?>
            <li>
                  <a href="?page=loginForm"><i class="material-icons left">keyboard_tab</i>Sign in</a>
            </li>
          <?php endif ?>

          <?php if ( in_array($page, $main_link2)) : ?>
            <?php if (in_array($page, $main_link)) : ?>
            <li>
                <a href = "#!" id="notification-icon" onclick="seenNotification()" class='dropdown-trigger' data-target='dropdown'><i class="material-icons">notifications</i></a>
            </li>
            <li>
                <span style="position:relative; top:20px; right:20px; background-color:red;" id="notification-count"></span>
            </li>
            <?php endif ?>
            <li>
                <a href="?page=editUser"><img style="width: 40px; height: 40px; margin-right: 10px; margin-top: 10px;" class="circle left" src="img/upload/<?= $_SESSION["user"]["profile"] ?>"><?= $_SESSION["user"]["name"] ?></a>
            </li>
            <li>
                <a href="?page=logout"><i class="material-icons left">exit_to_app</i>Logout</a>
            </li>
          <?php endif ?>
      </ul>
      <?php endforeach ?>
    </div>
  </nav>