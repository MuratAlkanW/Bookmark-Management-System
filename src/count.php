<?php

require 'db.php';
$userID = $_GET["user_id"];
$bookmarks = $db->query("select bookmark.id bid, title, note, created, url, category
                        from bookmark
                        where $userID = owner AND category = 'Shared' AND shareStatus='0'
                        ")->fetchAll(PDO::FETCH_ASSOC);

$count=count($bookmarks);
echo "$count";
?>