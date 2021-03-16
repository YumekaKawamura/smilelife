<?php
session_start();
require_once("User.php");

function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

try{
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();
  $result = $user->findClass();

  if($_POST){
    $result = array();
    $message = $user->validate($_POST);
    if(empty($message['name']) && empty($message['kana'])) {
      $result = $user->login($_POST);
    }
    if(!empty($result)){
      session_start();
      $_SESSION['User'] = $result;
      header('location: password.php');
      exit;
    }
    else{
      $result = $user->findClass();
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
    クラス・出席番号・なまえを入力してください</p>
    <?php if(isset($message['name'])) echo "<p class='error'>".$message['name']."</p>"?>
    <?php if(isset($message['pass'])) echo "<p class='error'>".$message['pass']."</p>"?>
    <img id="key" class="pic" src="../img/key.png" alt="鍵">
    <img id="treasure" class="pic" src="../img/treasure.png" alt="宝箱">
    <form action="" id="login" method="post">
      <table>
        <tr>
          <th>クラス</th>
          <td>
            <select name="class" class="square">
              <?php foreach ($result as $row):?>
              <option><?= $row['name']?></option>
              <?php endforeach; ?>
            </select>
          </td>
        </tr>
      <tr>
        <th>出席番号</th>
        <td>
          <select name="num" class="square">
            <?php if($_POST['num']){
              echo h($_POST['num']);
            }else{
              for($num = 0; $num < 45; $num++){
                echo '<option value="',$num,'">', $num,'</option>';
              }
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <th>なまえ</th>
        <td>
          <input type="text" name="name" placeholder="なまえ" class="square" size="20">
        </td>
      </tr>
      <tr>
        <th>今のパスワード</th>
        <td>
          <input type="password" name="pass" placeholder="今のパスワード" class="square" size="20">
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
