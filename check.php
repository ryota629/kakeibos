<?php
/* 会員登録の確認画面 */

session_start();
require('dbconnect.php');

// 会員登録で入力した情報が入っているかチェック
if(!isset($_SESSION['session'])){
  header('Location:toppage.php');
  exit();
}

//会員登録で入力した情報をデータベースに登録
if(!empty($_POST)){
  $statement = $db->prepare('INSERT INTO users SET username=?,email=?,password=?,created_at=NOW()');
  echo $statement->execute(array(
    $_SESSION['session']['username'],
    $_SESSION['session']['email'],
    sha1($_SESSION['session']['password'])
  ));
  // データベース登録完了後、会員登録完了画面へ
  unset($_SESSION['session']);
  header('Location:kanryo.php');
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
    <title>確認画面</title>
</head>
<body>
  <h1 class="header-title">会員登録画面</h1>
  <div class="content">
  <p>記入した内容を確認して、登録するボタンを押してください</p>
  <form action="" method="post" >
    <input type="hidden" name="action" value="submit">
    <dl>
      <dt>ユーザ名</dt>
      <dd>
        <?php print(htmlspecialchars($_SESSION['session']['username'],ENT_QUOTES)); ?>
      </dd>
      <dt>メールアドレス</dt>
      <dd>
      <?php print(htmlspecialchars($_SESSION['session']['email'],ENT_QUOTES)); ?>
      </dd>
      <dt>パスワード</dt>
      <dd>
      *********
      </dd>
    </dl>
  
</div>
<div class="butoon1">
<input type="button" value="内容を修正する" onclick="location.href='toppage.php?action=rewrite';">
<button type="submit" name="submit" id="register">登録する</button>
<script>
	var btn = document.getElementById('register');
	btn.addEventListener('click',function(){
		alert('登録してよろしいでしょうか?');
	});
	</script>
</div>
</form>
</body>
</html>