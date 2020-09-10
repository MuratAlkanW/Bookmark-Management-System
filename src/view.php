<?php  foreach($bookmarks as $bm) : ?>
    <div id="bmView<?= $bm['bid']?>" class="modal">
    <div class="modal-content">
        <h5 class="card teal center white-text">View Bookmark</h5><br>
      <table>
          <tr>
              <td>ID:</td>
              <td><?= $bm['bid'] ?></td>
          </tr>
          <tr>
              <td>Owner:</td>
              <td><?= $_SESSION["user"]["name"] ?></td>
          </tr>
          <tr>
              <td>Category:</td>
              <td><?= $bm['category'] ?></td>
          </tr>
          <tr>
              <td>Title:</td>
              <td><?= $bm['title'] ?></td>
          </tr>
          <tr>
              <td>Notes:</td>
              <td><?= $bm['note'] ?></td>
          </tr>
          <tr>
              <td>URL:</td>
              <td><?= $bm['url'] ?></td>
          </tr>
          <tr>
              <td>Date:</td>
              <td><?= $bm['created'] ?></td>
          </tr>
      </table>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>
<?php endforeach ?>