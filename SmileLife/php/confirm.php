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
//insert.phpから遷移されてなければ自動でログアウト
$referer = $_SERVER['HTTP_REFERER'];
if($referer !== 'http://localhost:8888/SmileLife/php/insert.php') {
  header('location: login.php');
  exit();
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
<link rel="stylesheet" type="text/css" href="../css/confirm.css">
<link rel="stylesheet" type="text/css" href="../css/base.css">
<link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
<link href="https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery.js"></script>
</head>
<body>
  <?php
  if($_POST){
      $class = $_POST['class'];
      $num = $_POST['num'];
      $name = $_POST['name'];
      $pass = $_POST['pass'];

  }
  ?>
  <?php
  require('header.php');
  ?>
  <div id="main">
  <div id='insert'>
    <h2>クラス登録確認</h2>
    <p>下記内容で登録します。よろしいですか？</p>
  </div>
  <div id="data">
    <p id="new_class"><?php echo h($_POST['class']);?></p>
      <?php
      $memcount = 1;
        for($i=0; $i<$memcount; $i++){
          if(empty($name[$i])) {
            $memcount--;
            break;
        }else{
          echo h($num[$i]).'番   ';
          echo h($name[$i]).'  ';
          echo h($pass[$i]).'</br>';
          $memcount++;
        }
      }
      ?>
  </div>

<form action="complete.php" id="new_class" method="post">
  <input type="hidden" name="class" value="<?= h($class)?>">
  <?php for($cou = 0; $cou < $memcount; $cou++):?>
  <input type="hidden" name="num[]" value="<?= h($num[$cou])?>">
  <input type="hidden" name="name[]" value="<?= h($name[$cou])?>">
  <input type="hidden" name="pass[]" value="<?= h($pass[$cou])?>">
<?php endfor;?>
<input type="submit" id="btn" value="登　録">
</form>
<p id="return"><a href="insert.php">戻　る</a></p>
</div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
