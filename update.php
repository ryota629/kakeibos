<?php
  /* 更新機能 */

  session_start();
  require('dbconnect.php');

  $date = $_POST['date'];
  $user_id=$_SESSION['id'];
  $category = $_POST['category'];
  $amount = $_POST['amount'];
  $type = $_POST['type'];
  $id_post = $_POST['id'];

  $update = $db->prepare('UPDATE records SET date=?,user_id=?,category=?,type=?,amount=?,created_at=NOW(),updated_at=NOW() WHERE id= ?');
  $update->execute(array(
    $date,
    $user_id,
    $category,
    $type,
    $amount,
    $id_post
  ));

  header('Location:index.php');
  exit();
?>