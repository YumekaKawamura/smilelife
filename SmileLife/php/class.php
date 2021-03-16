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
  $result = $user->findOneClass($_GET['id']);
  $class = $result['name'];

  $result = $user->getById($_GET['id']);
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
<link rel="stylesheet" type="text/css" href="../css/class.css">
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
  <div id='class'>
    <h2><?= $class?></h2>
    <p id="hw">〜今日の宿題〜</br>
    音読（国語p20）、計算スキル、スマイルライフ</p>
  </div>
  <div id="announce">
    <p>〜先生からのお知らせ〜</br>
      明日は待ちに待った運動会です。練習の成果を発揮できるように優勝目指してがんばりましょう！</p>
  </div>
  <div id="member">
    <table>
      <?php foreach ($result as $key):?>
      <?php if($key['role']=="2"){?>
      <tr>
        <td><?= $key['num'].'番'?></td>
        <td><?= $key['name']?></td>
        <?php if(($_SESSION['User']['role'] == "1") || ($key['id'] == $_SESSION['User']['id'])):?>
        <td><a href="mypage.php?id=<?= $key["id"]?>">日記を見る</a></td>
        <?php endif;?>
      </tr>
    <?php }?>
      <?php endforeach;?>
    </table>
  </div>
  <div id="btn">
    <p><a href="top.php">トップページにもどる</a></p>
    <?php if($_SESSION['User']['role'] == "1"):?>
    <p><a href="teacher.php?id=<?= $_GET['id']?>">編集（先生用）</a></p>
    <?php endif;?>
  </div>
</div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
