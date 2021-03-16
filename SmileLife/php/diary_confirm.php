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

  if($_SESSION['diary']){
    $diary = $_SESSION['diary'];
  }
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
<link rel="stylesheet" type="text/css" href="../css/diary_confirm.css">
<link rel="stylesheet" type="text/css" href="../css/base.css">
<link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
<link href="https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script>


</script>
</head>
<body>
  <?php
  require('header.php');
  ?>
  <div id="main">
  <div id="announce">
    <h2>今日の日記</h2>
    <p>※内容かくにんしたら提出してね！</p>
  </div>
  <div id="body">
    <p><?= 'タイトル：'.$diary['title']?></p>
    <div id="text">
    <p>本文</p>
    <p id="bun"><?= nl2br(h($diary['body']))?></p>
    </div>
  </div>
  <form action="diary_complete.php" method="post" id="form">
    <input type="hidden" name="user_id" value="<?= h($diary['user_id'])?>">
    <input type="hidden" name="title" value="<?= h($diary['title'])?>">
    <input type="hidden" name="body" value="<?= nl2br(h($diary['body']))?>">
    <input type="submit" id="ms_btn" value="提出する">
  </form>
  <div id="btn">
    <p><a href="diary.php">かき直す</a></p>
  </div>
</div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
