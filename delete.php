<?php
/* 削除機能 */

require('dbconnect.php');

$id = $_GET['id'];
$delete = $db->prepare('DELETE FROM records WHERE id=?');
$delete->execute(array(
  $id
));

header('Location:index.php');
exit();
?>