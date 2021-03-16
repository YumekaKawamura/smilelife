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
  if($_GET){

  $result = $user->findUser($_GET['id']);
  $name = $result['name'];

  $data = $user->findDiary($_GET['id']);
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
<link rel="stylesheet" type="text/css" href="../css/mypage.css">
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
  <div id='catch'>
    <h2><?= h($name)?>の日記</h2>
    <p id="hw">〜今日の宿題〜</br>
    音読（国語p20）、計算スキル、スマイルライフ</p>
  </div>
  <div id="diary">
    <table>
      <?php foreach ($data as $key):?>
      <tr>
        <td><?= h($key['created_at'])?></td>
        <td id="title"><?= h($key['title'])?></td>
        <td><a href="mydiary.php?id=<?= $key["id"]?>">内容をみる</a></td>
      </tr>
      <?php endforeach;?>
    </table>
  </div>
  <div id="btn">
    <p><a href="class.php?id=<?= $result["class_id"]?>">クラスページにもどる</a></p>
  </div>
</div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
