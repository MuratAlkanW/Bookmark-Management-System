<?php
   require "db.php";

    $currPage = $_GET['pageNum'] ?? "1";
    $_SESSION["currentPage"] = $currPage;
    $currCat = $_GET["cat"] ?? "All";
    $_SESSION["currentCategory"] = $currCat;
    $sort = $_GET["sort"] ?? "created" ;

    ///////////////////////////////////////////////INSERT//////////////////////////////////////////////////////////////
    if( isset($_POST['insert'])) {
        extract($_POST) ;
      if( isset($category)) {
        $sql = "insert into bookmark (title, url, note, owner, category) values (?,?,?,?,?)" ;
        try{
            
          $title = filter_var($title, FILTER_SANITIZE_STRING);
          $url = filter_var($url, FILTER_SANITIZE_URL);
          $note = filter_var($note, FILTER_SANITIZE_STRING);
          
          $stmt = $db->prepare($sql) ;
          $stmt->execute([$title, $url, $note, $_SESSION["user"]["id"], $category ?? ""]) ;
          addMessage("Bookmark is inserted");
          array_push ($_SESSION["cats"], $category);
        }catch(PDOException $ex) {
           addMessage("Insertion is failed!");
        }
       }
       else{
           addMessage("Choose a category, try again!");
       }
    }
    ///////////////////////////////////////////////INSERT//////////////////////////////////////////////////////////////
    
  ///////////////////////////////////////////////EDIT//////////////////////////////////////////////////////////////
     if( isset($_POST['edit'])) {
         extract($_POST);
     try {
          $title = filter_var($title, FILTER_SANITIZE_STRING);
          $url = filter_var($url, FILTER_SANITIZE_URL);
          $note = filter_var($note, FILTER_SANITIZE_STRING);
         
          $sql = "update bookmark set title=?, url=?, note=?, category=?, shareStatus=? where id = ?" ;
          $stmt = $db->prepare($sql) ;
          $stmt->execute([$title, $url, $note, $category, 0, $id]) ;
          addMessage("Updated!") ;
     } catch(PDOException $ex) {
         addMessage("Error!") ;
     }
  } 
  ///////////////////////////////////////////////EDIT//////////////////////////////////////////////////////////////
  
  ///////////////////////////////////////////////MANAGE CATEGORY//////////////////////////////////////////////////////////////
  
   if(isset($_SESSION["cats"])) {
           if( isset($_POST['add'])) {
            extract($_POST);
            $cat = filter_var($cat, FILTER_SANITIZE_STRING);
            if($cat !="" && $cat !="All" && $cat != "all") {
                array_push ($_SESSION["cats"], $cat);
                addMessage("Category is added") ;
            }
            else{
                addMessage("Category is invalid!") ;
            }
           }
           
           if(isset($_GET['del'])) {
                if($currCat != "All"){
                    $deletedCat = $_GET['cat'];
                    $catInd = array_search($deletedCat, $_SESSION['cats']);
                    unset($_SESSION['cats'][$catInd]);
                    addMessage("Category is deleted") ;
                    
                    $currCat = "All"; //after deleting, show All category
                }
                else{
                  addMessage("This Category cannot be deleted!") ;  
                }
           }
     }
  ///////////////////////////////////////////////MANAGE CATEGORY////////////////////////////////////////////////////////////////
  
     
  ///////////////////////////////////////////////DATA FROM DATABASE//////////////////////////////////////////////////////////////
  $users = $db->query("select * from user order by name")->fetchAll(PDO::FETCH_ASSOC) ;
        if($currCat != "All"){
             $queryStr = "AND category = '{$currCat}'";
        }
        else{
            $queryStr = "";
        }
            
        if(isset($_POST["search"])) {
            $searchText =  $_POST["searchText"];
            if($searchText != "")
                $queryStr2  = "AND (title LIKE '%".$searchText."%' OR note LIKE '%".$searchText."%')";
            else 
                $queryStr2 = "";
        }
        else{
            $queryStr2 = "";
        }
        $userID = $_SESSION["user"]["id"];
  $bookmarks = $db->query("select bookmark.id bid, title, note, created, url, category
                        from bookmark
                        where $userID = owner $queryStr $queryStr2
                        order by $sort asc")->fetchAll(PDO::FETCH_ASSOC);

///////////////////////////////////////////////DATA FROM DATABASE//////////////////////////////////////////////////////////////
  
     ///////////////////////////////////////////////SHARE//////////////////////////////////////////////////////////////
    if( isset($_POST['share'])) {
            
        if(isset($_POST["IDs"])) { 
            extract($_POST);
            $otherUsers = $_POST["IDs"];
            
        $sql = "insert into bookmark (title, url, note, owner, category) values (?,?,?,?,?)" ;
        try{
          $stmt = $db->prepare($sql) ;
          for ($i = 0; $i< count($otherUsers); $i++) {
            $stmt->execute([$title, $url, $note, $otherUsers[$i], "Shared" ?? ""]) ; //"Shared Bookmark" will be belong to "Shared" category -> User can change category of shared bookmark by editing the bookmark on dropdown menu
          }
          addMessage("Bookmark is shared with other users") ;
        }catch(PDOException $ex) {
           addMessage("Sharing is failed!") ;
           $error = true ;
        } 
            
     } 
     else{
        addMessage("Select at least one user to share!") ;
     }
         
  } 
  ///////////////////////////////////////////////SHARE//////////////////////////////////////////////////////////////

  ///////////////////////////////////////////////CATEGORY//////////////////////////////////////////////////////////////
     if( !isset($_SESSION["cats"])) {
          $categories=[];
          for ($i = 0; $i< count($bookmarks); $i++) {
              if($bookmarks[$i]["category"] != "Shared"){ //user can add "Shared" category manually to delete, view. But Shared Bookmark is already shown up on notification part (dropdown menu) to be edited and to be added to another category.
                  $categories[$i+1]=$bookmarks[$i]["category"];
              }
          }
          $_SESSION["cats"] = $categories;
     }
    
     natcasesort ($_SESSION["cats"]); //sort while ignoring case 
     array_unshift($_SESSION["cats"],"All");
     $_SESSION["cats"] = array_unique($_SESSION["cats"]);
///////////////////////////////////////////////CATEGORY//////////////////////////////////////////////////////////////
         
?>

   <div id="allAreas">
     <div id="leftArea"> 
       <table class="responsive-table" >
        <tbody>
       
 <?php  
      foreach($_SESSION["cats"] as $ctg)  : 
       if($currCat == $ctg)  : ?>
        <tr> <td id='catSelected' > <a href='?cat=<?=urlencode($ctg)?>'> <?=$ctg?> </td> </tr> 
         <?php endif ?>
       <?php if($currCat != $ctg)  : ?>
        <tr> <td> <a href='?cat=<?=urlencode($ctg)?>&pageNum=<?=$currPage?>'> <?=$ctg?> 
       <?php endif ?>
 <?php endforeach ?>

         <?php  if( isset($_GET['add'])): ?>
             <tr>
                 <td > 
                 <form action="index.php?cat=<?=$currCat?>&pageNum=<?=$currPage?>" method="post">
                    <div class="input-field col s12 l6" style="width: 80%;">
                        <input  id="cat" type="text" name="cat" placeholder="Type new Category"> 
                         <button style="" class="material-icons prefix" type="submit" name="add">add_circle
                    </div>
                  </form>
                 </td> 
             </tr> 
         
          <?php endif ?>   
                 <tr>
                 <td>
                     <i class="material-icons" style="color:#4db6ac; font-size: 40px;"> <a href='?cat=<?=$currCat?>&pageNum=<?=$currPage?>&add'> add_circle</i> 
                     <i class="material-icons" style="color:#4db6ac; font-size: 40px;"> <a href='?cat=<?=$currCat?>&pageNum=<?=$currPage?>&del'> remove_circle</i> 
                 </td>
             </tr>
        </tbody>
      </table>
          
    </div>
        
       <div id = "middleArea"> </div>
    
 <div id="rightArea">  
    
  <div class="row" id="searchBox">
    <form action="" method="post">
        <div class="input-field col  offset-s4 s4">
          <input placeholder="Search..." type="text" name='searchText' id="searchText" class="validate" value ="<?= $searchText ?? "" //remember?>">
          <button class="material-icons prefix"type="submit" name="search">search</button>
        </div>
    </form>
  </div>
     
<div>
    <table class="striped"  style="table-layout:fixed; width:100%; margin: 10px auto">
     <tr style="" class="grey lighten-5">
         <th class="title" >
             <a href="?cat=<?=$currCat?>&pageNum=<?= $currPage?>&sort=title">Title 
             <?= $sort == "title" ? "<i class='material-icons'>arrow_drop_down</i>": "" ?>
             </a>
        </th>
         <th class="note" >
             <a href="?cat=<?=$currCat?>&pageNum=<?= $currPage?>&sort=note">Note 
             <?= $sort == "note" ? "<i class='material-icons'>arrow_drop_down</i>": "" ?>
             </a>
        </th>

         <th class="action" >Actions</th>
     </tr>
     
      <?php
     $totalPage = ceil(sizeof($bookmarks)/10);
 
        if($currPage>$totalPage) $currPage=$totalPage;
        else if ($currPage<1) $currPage=1;
        
        $i=($currPage-1)*10;
      ?> 
     
    <?php foreach($bookmarks as $bm)  : ?>
        
        <?php 
            if($currPage == $totalPage) $total = sizeof($bookmarks); 
            else $total = $currPage*10; 
        ?>

     <?php if($i < $total)  : ?>
       <tr id="row<?= $bm["bid"] ?>">
           <td><span class="truncate"><a href="<?= $bookmarks[$i]['url'] ?>" target="_blank"><?= $bookmarks[$i]['title'] ?></a></span></td>
           <td><span class="truncate"><?= $bookmarks[$i]['note'] ?></span></td>
   
            <td class="action" >
               <a class="btn-small modal-trigger" href="#bmEdit<?= $bookmarks[$i]['bid'] ?>"><i class="material-icons">edit</i></a>
               <a class="btn-small modal-trigger" href="#bmView<?= $bookmarks[$i]['bid'] ?>"><i class="material-icons">visibility</i></a>
               <a class="btn-small modal-trigger" href="#bmShare<?= $bookmarks[$i]['bid'] ?>"><i class="material-icons">share</i></a>
               <a href="src/delete.php?cat=<?= $currCat?>&pageNum=<?= $currPage?>&id=<?= $bookmarks[$i]["bid"] ?>" class="btn-small"><i class="material-icons">delete</i></a>
            </td>
       </tr>
         <?php  $i = $i+1;  ?>  
       <?php endif ?>
     <?php endforeach ?>
       
    </table>
</div>

 <?php
 
 //////////////////////////////////////////////////////////////////////PAGINATION//////////////////////////////////////////////////////////////////////////////////
     echo "<ul class='pagination'>";
     
        if($currPage>=1){
            if($currPage == 1)
                echo "<li class='disabled'><a href='?cat={$currCat}&pageNum=1'><i class='material-icons'>chevron_left</i></a></li>";
            else
                echo "<li class='waves-effect'><a href='?cat={$currCat}&pageNum=",$currPage-1,"'><i class='material-icons'>chevron_left</i></a></li>";
        }
    
          for( $i=1; $i<=$totalPage; $i++){
              if($currPage == $i)
                 echo "<li class='active'><a href='?cat={$currCat}&pageNum={$i}'>{$i}</a></li>";
              else
                 echo "<li class='waves-effect'><a href='?cat={$currCat}&pageNum={$i}'>{$i}</a></li>";  
          }
      
        if($currPage<=$totalPage){
            if($currPage == $totalPage)
                  echo "<li class='disabled'><a href='?cat={$currCat}&pageNum=",$totalPage,"'><i class='material-icons'>chevron_right</i></a></li>";
            else
                  echo "<li class='waves-effect'><a href='?cat={$currCat}&pageNum=",$currPage+1,"'><i class='material-icons'>chevron_right</i></a></li>";
        }
       
     echo "</ul>";
 ?>
</div>

</div>
    
<div class="fixed-action-btn">
  <a class="btn-floating btn-large red modal-trigger z-depth-2" href="#add_form">
    <i class="large material-icons">add</i>
  </a>
</div>

<?php include "view.php"; //view ?>
<?php include "insert.php"; //insert?>
<?php include "share.php"; //share?>
<?php include "edit.php"; //edit?>
<?php include "notifications.php"; ?>

<script>
    var instances ;

    document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.modal');
    instances = M.Modal.init(elems);

    elems = document.querySelectorAll('select');
    instances = M.FormSelect.init(elems);
    
     var options = {
            alignment: 'right',
            constrainWidth: false
        };
    elems = document.querySelectorAll('.dropdown-trigger');
    instances = M.Dropdown.init(elems,options);
   });
</script>