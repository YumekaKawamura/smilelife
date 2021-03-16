<?php
session_start();
require_once("User.php");

function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

//ログアウト処理
if(isset($_GET['logout'])){
  $_SESSION = array();
  session_destroy();
}
//ログイン情報なければ自動でログアウト
if(!isset($_SESSION['User'])) {
  header('Location: /SmileLife/php/login.php');
  exit;
}
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
<link rel="stylesheet" type="text/css" href="../css/teacher.css">
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
  <h2>お知らせ編集画面</h2>
  <form action="" method="post" id="form">
  <div class="body">
    <p>今日の宿題</p>
    <textarea name="hw" wrap="hard" cols="80" rows="4" class="textareabox"></textarea>
  </div>
  <div class="body">
    <p>先生からのお知らせ</p>
    <textarea name="announce" wrap="hard" cols="80" rows="4" class="textareabox"></textarea>
  </div>
  <input type="submit" id="ms_btn" value="更新する">
  </form>
  <div id="btn">
    <p><a href="class.php?id=<?= $num["class_id"]?>">クラスページにもどる</a></p>
  </div>
</div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
