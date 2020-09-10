  <?php
$currPage =  $_SESSION["currentPage"];
$currCat = $_SESSION["currentCategory"];
?>

<?php foreach($bookmarks as $bm) : ?>
<div id="bmEdit<?= $bm['bid']?>" class="modal">
  <form action="index.php?cat=<?=$currCat?>&pageNum=<?=$currPage?>" method="post" >
    <div class="modal-content">
        <h5 class="card teal center white-text">Edit Bookmark</h5><br>
        
        <div class="input-field">
          <input id="id" type="text" name="id" value="<?= $bm['bid'] ?>" readonly>
          <label for="id">Bookmark ID</label>
        </div>
        <div class="input-field form">  
            <label class="active">Category</label>
            <select class="browser-default" name="category">
                    <option value="<?= $bm['category']?>" ><?= $bm['category']?> (Default)</option>
            <?php foreach($_SESSION["cats"] as $ctg) : 
                if ($ctg != "All" && $ctg != "{$bm['category']}" ) :?>
                    <option value="<?=$ctg?>"><?=$ctg?></option>
                <?php endif ?>
            <?php endforeach ?>
            </select>
        </div>
        <div class="input-field">
          <input id="title" type="text" name="title" value="<?= $bm['title'] ?>">
          <label for="title">Title</label>
        </div>
        <div class="input-field">
            <input id="url" type="text" name="url" value="<?= $bm['url'] ?>">
            <label for="url">URL</label>
        </div>
        <div class="input-field">
          <textarea id="note" class="materialize-textarea" name="note" ><?= $bm['note'] ?></textarea>
          <label for="note">Notes</label>
        </div>
      </div>
      
      <div class="modal-footer">
        <button  class="btn waves-effect waves-light" type="submit" name="edit">Update
         <i class="material-icons right">send</i>
      </button>
    </div>
  </form>
</div>
<?php endforeach ?>

