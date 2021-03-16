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
  if($_POST) {
    $class = $_POST['class'];
    $id = $_POST['id'];
    $num = $_POST['num'];
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    $cid = $_SESSION['Id'];
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
<link rel="stylesheet" type="text/css" href="../css/update_confirm.css">
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
  <div id='insert'>
    <h2>クラス修正確認</h2>
    <p>下記内容で修正します。よろしいですか？</p>
  </div>
  <div id="data">
    <p id="new_class"><?php echo h($class);?></p>
    <table>
    <?php $cou = count($name);?>
    <?php for($i=0; $i<$cou; $i++):?>
      <tr>
        <td><?= h($num[$i]).'番'.'　'?></td>
        <td><?= h($name[$i]).'　'?></td>
        <td><?= h($pass[$i])?></td>
      </tr>
    <?php endfor;?>
    </table>
  </div>
<form action="update_complete.php" class="new_class" method="post">
  <input type="hidden" name="class" value="<?= h($class)?>">
<?php for($k = 0; $k < $cou; $k++):?>
  <input type="hidden" name="id[]" value="<?= h($id[$k])?>">
  <input type="hidden" name="num[]" value="<?= h($num[$k])?>">
  <input type="hidden" name="name[]" value="<?= h($name[$k])?>">
  <input type="hidden" name="pass[]" value="<?= h($pass[$k])?>">
<?php endfor;?>
<input type="submit" id="btn" value="修　正">
</form>
<p id="return"><a href="update.php?id=<?= $cid?>">戻　る</a></p>
</div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
