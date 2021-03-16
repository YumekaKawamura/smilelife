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
//データ取得
  if($_GET){
    $_SESSION['Id'] = array();
    $result = $user->findOneClass($_GET['id']);
    $_SESSION['Id'] = $result['id'];
    $class = $result['name'];
    $id = $result['id'];

    $result = $user->getById($_GET['id']);
  }
  //確認画面から戻ってきた時
   elseif(isset($_GET['return'])){

     $result = $user->getById($_SESSION['Id']);

  }

//クラス全体削除
if(isset($_GET['del'])){
  $user->deleteClass($_GET['del']);
  header('Location: /SmileLife/php/delete.php');
}
//個人削除
if(isset($_GET['delmem'])){
  $user->deleteMem($_GET['delmem']);
  header('Location: /SmileLife/php/delete.php');
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
<link rel="stylesheet" type="text/css" href="../css/update.css">
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
  <div id="update">
    <h2>クラス修正ページ</h2>
    <form action="update_confirm.php" id="new_class" method="post">
      <table>
      <tr id="update_class">
        <th>クラス</th>
        <td>
          <input type="text" name="class" class="square" size="10" value="<?= h($class)?>">
        </td>
      </tr>
      <?php foreach($result as $key):?>
      <input type=hidden name="id[]" value="<?= $key['id']?>">
      <tr>
        <th>出席番号</th>
        <td>
          <input type="text" name="num[]" size="2" value="<?= h($key['num'])?>">
        </td>
      </tr>
      <tr>
        <th>名前</th>
        <td>
          <input type="text" name="name[]" placeholder="なまえ" class="square" size="20" value="<?= h($key['name'])?>">
        </td>
      </tr>
      <tr>
        <th>パスワード</th>
        <td>
          <input type="password" name="pass[]" placeholder="パスワード"　class="square" value="<?= h($key['pass'])?>">
        </td>
      </tr>
      <td>
      <a href="?delmem=<?= $key['id']?>" onClick="if(!confirm('<?= $key['name']?>を削除しますがよろしいですか？')) return false;" id="delmem">削除</a>
    </td>
    <?php endforeach;?>
    </table>
    <input type="submit" class="btn" value="修　正">
    <a href="?del=<?= $id?>" onClick="if(!confirm('<?= $name?>を削除しますがよろしいですか？')) return false;" class="btn">削　除</a>
    <p id="btn"><a href="insert.php">戻　る</a></p>
    </form>
</div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
