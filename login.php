<?php
/* ログイン画面 */

session_start();
require('dbconnect.php');

// 自動ログインを有効した場合にユーザ名(メールアドレス)を保存
if($_COOKIE['email'] !== ''){
	$emailuser = $_COOKIE['emailuser'];
}

$db = dbConnect();
// ログインが正しく入力されているか確認
if(!empty($_POST)){
	$emailuser = $_POST['emailuser'];
	// ログインチェック
	if($_POST['emailuser'] !== '' && $_POST['password'] !== ''){
		$str = $_POST['emailuser'];
		// メールアドレスとパスワードのチェック
		if(preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $str)){
			$login = $db->prepare('SELECT * FROM users WHERE email=? AND password=?');
			$login->execute(array(
			$_POST['emailuser'],
			sha1($_POST['password'])
			));
		}else{
			// ユーザ名とパスワードのチェック
			$login = $db->prepare('SELECT * FROM users WHERE username=? AND password=?');
			$login->execute(array(
			$_POST['emailuser'],
			sha1($_POST['password'])
			));
		}
		$users = $login->fetch();

		if($users){
			$_SESSION['id'] = $users['id'];
			$_SESSION['time'] = time();
			// 自動ログインが有効のみの場合
			if($_POST['save'] === 'on'){
				setcookie('emailuser',$_POST['emailuser'],time()+60+60+24*14);
			}
			header('Location:index.php');
			exit();
		}else{
			// ログインエラー
			$error['login'] = 'failed';
		}	
	}else{
		// ユーザ名、メールアドレス、パスワードが空の場合はエラーにする
		if($_POST['emailuser'] === '' && $_POST['password'] === '' ){
		$error['login'] = 'Allblank';
		}else{
			if($_POST['password'] === ''){
				$error['login'] = 'psblank';
			}else{
				$error['login'] = 'userblank';
			}
		}
	}
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
    <title>ログイン</title>
</head>
<body>
<section class="login">
<div class="header_container">
    <h1 class="header-title">かんたん家計簿</h1>
		<button type="button" class="btn btn-primary" style="margin:10px" onclick="location.href='toppage.php';" >会員登録</button>
</div>		
<form class="m-5"method="post">
	<h1 class="form-title">ログイン</h1>
	<div class="form-group">
		<input type="text"  id ="usermail" class="form-control" name="emailuser" placeholder="ユーザー名もしくはメールアドレス" value="<?php print(htmlspecialchars($emailuser,ENT_QUOTES));?>"/>
		<?php if($error['login'] === 'userblank' || $error['login'] === 'Allblank') :?>
			<script>
			document.getElementById("usermail").classList.add("is-invalid");
			</script>
			<p class="error invalid-feedback">メールアドレスもしくはユーザ名をご記入ください</p>
		<?php endif; ?>

	</div>
	<div class="form-group">
		<input type="password" id ="psword" class="form-control" name="password" placeholder="パスワード" value="<?php print(htmlspecialchars($_POST['password'],ENT_QUOTES));?>"/>
		<?php if($error['login'] === 'psblank' || $error['login'] === 'Allblank') :?>
			<script>
			document.getElementById("psword").classList.add("is-invalid");
			</script>
			<p class="error invalid-feedback">パスワードをご記入ください</p>
		<?php endif; ?>
		<?php if($error['login'] === 'failed') :?>
			<script>
			document.getElementById("psword").classList.add("is-invalid");
			document.getElementById("usermail").classList.add("is-invalid");
			</script>
			<p class="error invalid-feedback">ログインに失敗しました。正しくご記入ください。</p>
		<?php endif; ?>
	</div>

	<button type="submit" class="btn btn-primary" name="login">ログイン</button>
	<a class="login_txt" href="toppage.php">会員登録はこちら</a>
	<input id="save" type="checkbox" name="save" value="on">次回以降は自動的にログインする
	<label for="save"></label>
</form>
</section>
</body>
</html>