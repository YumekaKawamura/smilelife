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

  $result = $user->findClass();
  $_SESSION['Id'] = array();
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
<link rel="stylesheet" type="text/css" href="../css/insert.css">
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
  <div id='update'>
    <h2>クラス修正</h2>
    <p>※修正したいクラスを選択してください。</p>
  </div>
  <ul id="update_class">
    <?php foreach ($result as $row):?>
    <li><a href="update.php?id=<?= $row['id']?>"><?= h($row['name'])?></a></li>
    <?php endforeach; ?>
  </ul>
  <div id="insert">
    <h2>クラス新規登録フォーム</h2>
    <?php if(isset($message['class'])) echo "<p class='error'>".$message['class']."</p>"?>
    <form action="confirm.php" id="new_class" method="post">
      <table>
      <tr id="insert_class">
        <th>新規登録クラス</th>
        <td>
          <input type="text" name="class" class="square" size="10">
        </td>
      </tr>
      <?php for($member = 1; $member < 41; $member++):?>
      <tr>
        <th>出席番号</th>
        <td>
          <input type="text" name="num[]" size="2">
        </td>
      </tr>
      <tr>
        <th>名前</th>
        <td>
          <input type="text" name="name[]" placeholder="なまえ" class="square" size="20">
        </td>
      </tr>
      <tr>
        <th>パスワード</th>
        <td>
          <input type="password" name="pass[]" placeholder="パスワード"　class="square" value="pass0000">
        </td>
      </tr>
    <?php endfor;?>
    </table>
    <input type="submit" id="btn" value="登　録">
    </form>
</div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
