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

try{
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  $result = $user->findClass();
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
<link rel="stylesheet" type="text/css" href="../css/top.css">
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
  <div id='scholl'>
    <h2>Smile Life</h2>
    <p id="sc_name">富士見市立水谷小学校</p>
  </div>
  <div id="class">
    <p id="slogan">咲かせよう、笑顔と思いやりの花</p>
    <p id="setsumei">自分のクラスをクリックしてね！</p>
    <ul>
      <?php foreach ($result as $row):?>
      <li><a href="class.php?id=<?= $row['id']?>"><?= h($row['name'])?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div id="btn">
    <p><a href="diary.php">今日の日記を書く</a></p>
  </div>
</div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
