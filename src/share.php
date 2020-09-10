<?php foreach($bookmarks as $bm) : ?>
<div id="bmShare<?= $bm['bid']?>" class="modal" style="width: 400px; height: 350px;">
  <form action="index.php?cat=<?=$currCat?>&page=<?=$currPage?>" method="post" >
    <div class="modal-content">
        <h5 class="card teal center white-text">Share Bookmark</h5><br> 
          <div class="input-field form">  
             <div class="input-field">
                        <input id="b_title" type="text" name="title" value="<?= $bm['title'] ?>" readonly>
                        <input type="hidden" name="note" value="<?= $bm['note'] ?>" >
                        <input type="hidden" name="url" value="<?= $bm['url'] ?>" >
                        <input type="hidden" name="category" value="<?= $bm['category'] ?>">
                    <label for="b_title">Bookmark Title</label>
              </div>
              <div class="input-field">
            <label class="active">Other Users</label>
            <select name="IDs[]" multiple>
                    <?php foreach( $users as $user ):   
                         if ($user != $_SESSION["user"]) :?>
                        <option value="<?= $user["id"] ?>"><?= $user["name"] ?></option>
                   <?php endif ?>
                <?php endforeach ; ?>
            </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button  class="btn waves-effect waves-light" type="submit" name="share">Share
         <i class="material-icons right">send</i>
       </button>
    </div>
  </form>
</div>
<?php endforeach ?>

