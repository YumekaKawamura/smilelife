<?php
session_start();
require_once("User.php");
//ログアウト処理
if(isset($_GET['logout'])){
  $_SESSION = array();
  session_destroy();
}
//insert.phpから遷移されてなければ自動でログアウト
// $referer = $_SERVER['HTTP_REFERER'];
// if($referer !== 'http://localhost:8888/SmileLife/php/update.php') {
//   header('location: login.php');
//   exit();
// }
//一般ユーザは開けないページ
if($_SESSION['User']['role'] === '2'){
  header('Location: /SmileLife/php/top.php');
  exit;
}
try{
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();
}
catch (PDOException $e) { // PDOExceptionをキャッチする
    print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>SmileLife</title>
<link rel="stylesheet" type="text/css" href="../css/delete.css">
<link rel="stylesheet" type="text/css" href="../css/base.css">
<link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
<link href="https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery.js"></script>
</head>
<body>
  <?php
  require('header.php');
  ?>
  <div id="main">
    <h2>クラスを削除しました。</h2>
    <p><a href="top.php">トップへ戻る</a></p>
  </div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
