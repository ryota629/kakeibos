<?php
session_start();
require('dbconnect.php');
// 選択されたIDを取得
$record_id = $_GET['id'];
$user_id = $_SESSION['id'];
// 1.DB接続
// 2.編集するデータを取得
// 3.取得したデータを表示
$db = dbConnect();
$statement = $db->prepare('SELECT * FROM records WHERE id=? AND user_id=?');
$statement->execute(array(
  $record_id,
  $user_id 
));
$record = $statement->fetch();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>編集</title>
</head>
<body>
<section class="create">
  <div class="header_container">
    <h1 class="header-title">かんたん家計簿</h1>
    <button type="button" class="btn btn-primary" style="margin:10px" onclick="location.href='index.php'">戻る</button>
  </div>
<form class="m-5" method="post" action="update.php">
  <input type="hidden" name="id" value="<?php echo $record_id; ?>">
	<h1 class="form-title">編集フォーム</h1>
	<div class="form-group">
    <label for="date">日付</label>
		<input id="date" type="date" class="form-control" name="date" value="<?php print(htmlspecialchars($record['date'],ENT_QUOTES));?>" >
  </div>
  <div class="form-group">
    <label for="category">カテゴリ(項目)</label>
    <!-- 後でカテゴリをいれる -->
    <select id="category" type="text" class="form-control" name="category" required >
    <option value="1" <?php if($record['category'] == 1){print('selected');}?>>食費</option>
    <option value="2" <?php if($record['category'] == 2){print('selected');}?>>日用品</option>
    <option value="3" <?php if($record['category'] == 3){print('selected');}?>>交通</option>
    <option value="4" <?php if($record['category'] == 4){print('selected');}?>>交際</option>
    <option value="5" <?php if($record['category'] == 5){print('selected');}?>>保険</option>
    <option value="6"<?php if($record['category'] == 6){print('selected');}?>>教養</option>
    <option value="7" <?php if($record['category'] == 7){print('selected');}?>>通信</option>
    <option value="8" <?php if($record['category'] == 8){print('selected');}?>>水道/光熱</option>
    <option value="9" <?php if($record['category'] == 9){print('selected');}?>>娯楽</option>
    <option value="10" <?php if($record['category'] == 10){print('selected');}?>>給料</option>
</select>
	</div>
	<div class="form-group">
    <label for="amount">金額</label>
    <!-- マイナス金額をいれることができるため注意-->
		<input id="amount" type="number" class="form-control" name="amount" value="<?php print(htmlspecialchars($record['amount'],ENT_QUOTES));?>" />
  </div>
  <input type="radio" name="type" value="0" <?php if($record['type'] == 0 ? print('checked'):'');?>>収入
  <input type="radio" name="type" value="1" <?php if($record['type'] == 1 ? print('checked'):'');?>>支出
  <div>
  <button type="submit" class="btn btn-primary" name="login">更新</button>
</div>
	
</form>
</section>
</body>
</html>