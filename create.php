<?php
/* 追加機能 */

session_start();
require('dbconnect.php');

if(!empty($_POST)){
$date = $_POST['date'];
$user_id=$_SESSION['id'];
$category = $_POST['category'];
$amount = $_POST['amount'];
$type = $_POST['type'];

// データベースに家計簿を登録
$creat = $db->prepare('INSERT INTO records SET date=?,user_id=?,category=?,type=?,amount=?,created_at=NOW(),updated_at=NOW()');
echo $creat->execute(array(
 $date,
 $user_id,
 $category,
 $type,
 $amount,
));
header('Location:index.php');
exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>新規追加</title>
</head>
<body>
<section class="create">
  <div class="header_container">
    <h1 class="header-title">家計簿一覧</h1>
    <button type="button" class="btn btn-primary" style="margin:10px" onclick="location.href='index.php'">戻る</button>
  </div>
<form class="m-5" method="post">
	<h1 class="form-title">新規追加フォーム</h1>
	<div class="form-group">
    <label for="date">日付</label>
		<input id="date" type="date" class="form-control" name="date" >
  </div>
  <div class="form-group">
    <label for="category">カテゴリ(項目)</label>
    <select id="category"type="text" class="form-control" name="category">
    <option value="1">食費</option>
    <option value="2">日用品</option>
    <option value="3">交通</option>
    <option value="4">交際</option>
    <option value="5">保険</option>
    <option value="6">教養</option>
    <option value="7">通信</option>
    <option value="8">水道/光熱</option>
    <option value="9">娯楽</option>
    <option value="10">給料</option>
</select>
	</div>
	<div class="form-group">
    <label for="amount">金額</label>
		<input id="amount" type="number" class="form-control" name="amount" />
	</div>
  <input type="radio" name="type" value="0">収入
  <input type="radio" name="type" value="1">支出
  <div>
  <button type="submit" class="btn btn-primary" name="login">追加</button>
  </div>
</form>
</section>
</body>
</html>