<?php
session_start();
require_once("User.php");

function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

try{
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  if($_SESSION['User']){
    $result = $user->findOneClass($_SESSION['User']['class_id']);
    if($_POST){
      $message = $user->validate($_POST);
      if(empty($message['pass'])) {
        $user->passUpdate($_POST);
        echo "<script>alert('パスワードが変わりました！');</script>";
        $_SESSION['User'] = array();
        header('location: login.php');
        exit;
      }

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
<link rel="stylesheet" type="text/css" href="../css/signup.css">
<link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
<link href="https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script>

$(function(){
  fuwafuwa();
});

function fuwafuwa() {
  $(".pic").animate({marginTop:10},1000);
  $(".pic").animate({marginTop:0},1000);
  setTimeout(function(){
    fuwafuwa();
  },2000);
};

</script>

</head>
<body>
  <header>
    <a href="login.php"><img id="logo" src="../img/logo.png" alt="ロゴ"></a>
  </header>
  <div id="main">
    <p id="catch">Smile Life</p>
    <p id="suv">〜パスワード変更フォーム〜</br>
    新しいパスワードを入力してください</p>
    <?php if(isset($message['pass'])) echo "<p class='error'>".$message['pass']."</p>"?>
    <img id="key" class="pic" src="../img/key.png" alt="鍵">
    <img id="treasure" class="pic" src="../img/treasure.png" alt="宝箱">
    <form action="" id="login" method="post">
      <input type="hidden" name="id" value="<?= $_SESSION['User']['id']?>">
      <table>
        <tr>
          <th>クラス</th>
          <td><?= $result['name']?></td>
        </tr>
      <tr>
        <th>出席番号</th>
        <td><?= $_SESSION['User']['num']?></td>
      </tr>
      <tr>
        <th>なまえ</th>
        <td><?= $_SESSION['User']['name']?></td>
      </tr>
      <tr>
        <th>新しいパスワード</th>
        <td>
          <input type="password" name="pass" placeholder="新しいパスワード" class="square" size="20">
        </td>
      </tr>
    </table>
    <input type="submit" id="btn" value="パスワードをかえる">
    </form>
    <p id="go_back"><a href="login.php">もどる</a></p>
  </div>
  <?php
  require('footer.php');
  ?>

</body>
</html>
