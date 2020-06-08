<?php
/* 家計簿一覧表示 */

session_start();
require('dbconnect.php');

if(!isset($_SESSION['id'])){
   header('Location:login.php');
   exit();
}


$userid = $_SESSION['id'];
// 前月、今月、先月のいずれかの家計簿一覧を表示する
if(isset($_GET["prev"])){
  $ym = ($_GET["prev"] != '')? $_GET["prev"] : date("Ym");
  $dates = date("Ym",strtotime($ym."01"." -1 month "));
  $this_month_days = date("t",strtotime($ym."01"));
  $year = substr($dates,0,4);
  $month = substr($dates,4,5);
  $date = $year.'年'.$month.'月'.'1日'.'〜'.$year.'年'.$month.'月'.$this_month_days.'日';
  $tablename = "家計簿".$month."月";
}else if(isset($_GET["next"])){
  $ym = ($_GET["next"] != '')? $_GET["next"] : date("Ym");
  $dates = date("Ym",strtotime($ym."01"." +1 month "));
  $this_month_days = date("t",strtotime($ym."01"));
  $year = substr($dates,0,4);
  $month = substr($dates,4,5);
  $date = $year.'年'.$month.'月'.'1日'.'〜'.$year.'年'.$month.'月'.$this_month_days.'日';
  $tablename = "家計簿".$month."月";
}else{
  $firstday = date('Y年m月d日',strtotime('first day of this month'));
  $lastday = date('Y年m月d日',strtotime('last day of this month'));
  $date = $firstday.'〜'.$lastday;
  $year = date('Y');
  $month = date('m');
  $tablename = "家計簿".$month."月";
}

$db = dbConnect();
// データベースに登録した前月、今月、先月のいずれかの家計簿一覧を取り出す。
$statement = $db->prepare("SELECT id,date,name,type,amount FROM $tablename WHERE DATE_FORMAT(date,'%Y')=$year AND user_id=? ORDER BY date");
$statement->execute(array(
  $userid
));
$records = $statement->fetchAll();

// データベースに登録した前月、今月、先月のいずれかの収入と支出の合計を取り出す
$sumresult = $db->prepare("SELECT type,SUM(amount) AS sum_num FROM $tablename WHERE  DATE_FORMAT(date,'%Y')=$year AND user_id=? GROUP BY type");
$sumresult->execute(array(
  $userid
));
$rows =$sumresult->fetchAll();

// 支出と収入の合計
foreach($rows as $row){
  if($row['type'] == 0){
    $income = $row['sum_num'];
  }else{
    $spend =  $row['sum_num'];
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
    <title>家計簿一覧</title>
</head>
<body>
  <div class="indexpg">
    <div class="header_container">
      <h1 class="header-title">かんたん家計簿</h1>
      <button type="button" class="btn btn-primary" style="margin:10px" onclick="location.href='logout.php';">ログアウト</button>
    </div>
    <div class="container">
    <table class="table">
    <thead class="thead-light">
      <tr>
        <th scope="col">日付</th>
        <th scope="col">カテゴリ(項目)</th>
        <th scope="col">収入</th>
        <th scope="col">支出</th>
        <th scope="col">編集/削除</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($records as $record):?>
      <tr>
        <th scope="row"><?php print(htmlspecialchars($record['date'],ENT_QUOTES)); ?> </th>
        <th scope="row"><?php print(htmlspecialchars($record['name'],ENT_QUOTES)); ?> </th>
        <th scope="row"><?php if($record['type'] == 0 ? print(htmlspecialchars($record['amount'],ENT_QUOTES)):''); ?></th>
        <th scope="row"><?php if($record['type'] == 1 ? print(htmlspecialchars($record['amount'],ENT_QUOTES)):''); ?></th>
        <th scope="row" style="padding:3px">
        <button type="button" class="btn btn-success" onclick="location.href='editform.php?id=<?php print(htmlspecialchars($record['id'],ENT_QUOTES));?>'">編集</button>
        <button type="button" id="delete" class="btn btn-danger" onclick="location.href='delete.php?id=<?php print(htmlspecialchars($record['id'],ENT_QUOTES)); ?>'">削除</button>
        </th>
      </tr>
      <?php endforeach; ?>
    </tbody>
    </table>
    <button type="button" class="btn btn-primary" style="float:right;margin:10px" onclick="location.href='create.php'">追加する</button>
    </div>
  </div>
  <div class="sumresult">
  <div class="container">
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col1">集計</th>
          <th scope="col2" style></th>
        </tr>
      </thead>
      <tbody>
      
        <tr>
          <th scope="row1"><?php print($date); ?></th>
          <th scope="row2"></th>
        </tr>
      <tbody>
        <tr>
          <th scope="row1">収入</th>
          <th scope="row2" class="text-right"><?php print($income); ?></th>
        </tr>
      <tbody>
        <tr>
          <th scope="row1">支出</th>
          <th scope="row2" class="text-right"><?php print($spend); ?></th>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <th scope="row1">収支の総額</th>
          <th scope="row2" class="text-right"><?php print($income-$spend); ?></th>
        </tr>
      </tbody>
    </table>
  </div>
  <ul class="paging">
    <li><a href="index.php?prev=<?php print($dates);?>">前のページへ</a></li>
    <li><a href="index.php?next=<?php print($dates);?>">次のページへ</a></li>
  </ul>
</body>
</html> 
