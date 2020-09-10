<div id="add_form" class="modal">
  <form action="index.php?cat=<?=$currCat?>&pageNum=<?=$currPage?>" method="post" >
    <div class="modal-content">
        <h5 class="card-panel teal center white-text">New Bookmark</h5><br>
        <div class="input-field form">  
            <label class="active">Category</label>
            <select class="browser-default" name="category">
                    <option value="" disabled selected>Choose a category</option>
            <?php foreach($_SESSION["cats"]  as $ctg) : 
                if ($ctg != "All"):?>
                    <option value="<?=$ctg?>"><?=$ctg?></option>
                <?php endif ?>
            <?php endforeach ?>
            </select>
        </div>
        <div class="input-field">
          <input id="title" type="text" name="title">
          <label for="title">Title</label>
        </div>
        <div class="input-field">
            <input id="url" type="text" name="url">
            <label for="url">URL</label>
        </div>
        <div class="input-field">
          <textarea id="note" class="materialize-textarea" name="note"></textarea>
          <label for="note">Notes</label>
        </div>
      </div>
      <div class="modal-footer">
        <button  class="btn waves-effect waves-light" type="submit" name="insert">Add
         <i class="material-icons right">send</i>
      </button>
    </div>
  </form>
</div>