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

  if($_POST){
    $message = $user->diaryValidate($_POST);
    if(empty($message['title']) && empty($message['body'])){
      $_SESSION['diary'] = array();
      $_SESSION['diary'] = $_POST;
      $_POST = array();
      header('Location: /SmileLife/php/diary_confirm.php');
    }
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
<link rel="stylesheet" type="text/css" href="../css/diary.css">
<link rel="stylesheet" type="text/css" href="../css/base.css">
<link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
<link href="https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script>

$(function(){
  backmove();
});

function backmove() {
  $("#main").animate({backgroundSize:'110%'},2800);
  $("#main").animate({backgroundSize:'100%'},2800);
  setTimeout(function(){
    backmove();
  },2800);
};

</script>
</head>
<body>
  <?php
  require('header.php');
  ?>
  <div id="main">
  <h2>今日の日記</h2>
  <?php if(isset($message['title'])) echo "<p class='error'>".$message['title']."</p>"?>
  <?php if(isset($message['body'])) echo "<p class='error'>".$message['body']."</p>"?>
  <form action="" method="post" id="form">
  <input type=hidden name="user_id" value="<?= h($_SESSION['User']['id'])?>">
  <div id="body">
    <label>タイトル<input type="text" name="title" id="title" placeholder=" タイトルを入力してね！" value="<?php if(isset($_SESSION['diary']['title'])) echo h($_SESSION['diary']['title'])?>"></label>
    <div id="text">
    <p>本文</p>
    <textarea name="body" wrap="hard" cols="95" rows="15" id="textareabox"><?php if(isset($_SESSION['diary']['body'])) echo h($_SESSION['diary']['body'])?></textarea>
    </div>
    <input type="submit" id="ms_btn" value="提出する">
  </div>
  </form>
  <div id="btn">
    <p><a href="top.php">トップページにもどる</a></p>
  </div>
</div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
