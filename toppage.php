<?php
/* トップ画面(会員登録) */

session_start();
require('dbconnect.php');

// ユーザ名、メールアドレス、パスワードの入力チェック
if(!empty($_POST)){
	if($_POST['username'] === ''){
		$error['username'] = 'blank';
	}
	if($_POST['email'] === ''){
		$error['email'] = 'blank';
	}
	if(strlen($_POST['password']) < 4){
		$error['password'] = 'length';
	}
	if($_POST['password'] === ''){
		$error['password'] = 'blank';
	}

// アカウントの重複チェック
	if(empty($error)){
		$users = $db->prepare('SELECT COUNT(*) AS cnt FROM users WHERE email=?');
		$users->execute(array($_POST['email']));
		$record = $users->fetch();
		if($record['cnt'] > 0){
			$error['email'] = 'duplicate';
		}
	}

	// 入力エラーがなければ会員登録チェック画面へ遷移
	if(empty($error)){
	$_SESSION['session'] = $_POST;
	header('Location: check.php');
	exit();
	}
}

// 会員登録チェック画面で修正する際に一度入力した情報を残す
if($_REQUEST['action'] === 'rewrite'){
	$_POST = $_SESSION['session'];
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
    <title>かんたん家計簿</title>
</head>
<body>
<section class="toppage">
<div class="header_container">
    <h1 class="header-title">かんたん家計簿</h1>
		<button type="button" class="btn btn-primary" style="margin:10px" onclick="location.href='login.php';">ログイン</button>
</div>		
</section>
<section class="register">
<form class="m-5" method="post" action="">
	<h1 class="form-title">会員登録フォーム</h1>
	<div class="form-group">
		<input type="text" id="usercheck" class="form-control" name="username" placeholder="ユーザー名" value="<?php print(htmlspecialchars($_POST['username'],ENT_QUOTES)); ?>"/>
		<?php if($error['username'] === 'blank') :?>
		<script>
		document.getElementById("usercheck").classList.add("is-invalid");
		</script>
		<p class='error invalid-feedback'>ユーザ名を入力してください</p>
		<?php endif; ?>
	</div>
	<div class="form-group">
		<input type="email" id="emailcheck" class="form-control" name="email" placeholder="メールアドレス" value="<?php print(htmlspecialchars($_POST['email'],ENT_QUOTES)); ?>"/>
		<?php if($error['email'] === 'blank' || $error['email'] === 'duplicate') :?>
			<script>
			document.getElementById("emailcheck").classList.add("is-invalid");
			</script>
			<?php if($error['email'] === 'blank') :?>
			<p class='error invalid-feedback'>メールアドレスを入力してください</p>
			<?php endif; ?>
			<?php if($error['email'] === 'duplicate') :?>
			<p class='error invalid-feedback'>指定したメールアドレスはすでに登録されています</p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<div class="form-group">
		<input type="password" id="pascheck" class="form-control" name="password" placeholder="パスワード"/>
		<?php if($error['password'] === 'length' || $error['password'] === 'blank'): ?>
			<script>
			document.getElementById("pascheck").classList.add("is-invalid");
			</script>
			<?php if($error['password'] === 'length') :?>
			<p class='error invalid-feedback'>４文字以上のパスワードを入力してください</p>
			<?php endif; ?>
			<?php if($error['password'] === 'blank') :?>
			<p class='error invalid-feedback'>パスワードを入力してください</p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<button type="submit" class="btn btn-primary" id="text" name="signup">会員登録する</button>
	<a href="login.php"><span class="href-txt">ログインはこちら</span></a>
</form>
</section>
</body>
</html>