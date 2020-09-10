<?php
require 'db.php';
$userID = $_SESSION["user"]["id"];

if(isset($_COOKIE["status"])) {
    $sql="UPDATE bookmark SET shareStatus=1 WHERE $userID = owner AND category ='Shared' AND shareStatus=0";
    $stmt = $db->prepare($sql) ;
    $stmt->execute();
    setcookie("status", "", 1, "/") ;
}
        
$bookmarks = $db->query("select bookmark.id bid, title, note, created, url, category
                        from bookmark
                        where $userID = owner AND category = 'Shared'
                        order by bid desc")->fetchAll(PDO::FETCH_ASSOC);  

$sharedCounter= count($bookmarks);


// If user clicks on notification icon, new badge icon will be deleted since all shared bookmarks are seen by the user.
// However, user can see the notification icon if there is a shared bookmark(seen or unseen). If there is no shared bookmark, the notification icon will be deleted.
// To edit a shared bookmark on notification dropdown menu-> User should click on "All" category then should click on the shared bookmark, which is desired to be edited or to be added to another category.
// Shared bookmarks can also be edited on All category (on the table). Or can add a 'Shared' category to see all shared bookmarks easily on the table.
?>

 <ul id='dropdown' class='dropdown-content'>
     <li style="text-align: center;">Shared Bookmarks <br>(Click on any shared bookmark to edit/add to category)</li>
    <li class="divider" ></li>
    <?php foreach($bookmarks as $bm)  : ?>
       <li><a class="modal-trigger" href="#bmEdit<?= $bm['bid'] ?>">(<?= $bm['bid'] ,") - ", mb_strimwidth($bm['title'], 0, 15, "...") ," | ", mb_strimwidth($bm['url'], 0, 20, "...") ," | ",  mb_strimwidth($bm['note'], 0, 25, "...") ?></a></li>
     <?php endforeach ?>
  </ul>

<script type="text/javascript">
    
         function notification() {
		$.ajax({
			url: "src/count.php?user_id=<?= $userID?>",
			type: "POST",
			success: function(data){
                            if(data > 0){
                                $("#notification-icon").show();
                                $("#notification-count").html(data);
                                $("#notification-count").addClass("new badge");
                            }
			},
		});
        }
        
        var totalShared = '<?php echo $sharedCounter; ?>';
        if(totalShared ==0){
            $("#notification-icon").hide();
        }
        
        function seenNotification() {
            $("#notification-count").remove();
            var now = new Date();
            now.setTime(now.getTime() +(1*86400));
            document.cookie = "status=updated; expires=" + now.toUTCString() + "; path=/";
	}

        $( document ).ready(function() {
            notification();
         });
         
         setInterval(function(){
            notification();
        }, 5000);
        
</script>