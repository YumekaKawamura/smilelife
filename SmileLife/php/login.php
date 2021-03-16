<?php

require_once("User.php");

function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

try{
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();
  $result = $user->findClass();

  if($_POST){
    $message = $user->validate($_POST);
      $result = $user->login($_POST);
      if(!empty($result)) {
        session_start();
        $_SESSION['User'] = $result;
        header('location: top.php');
        exit;
      }else{
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
<link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
<link href="https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="../css/login.css">
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
    <p id="catch">Smile   Life</p>
    <?php if(isset($message['name'])) echo "<p class='error'>".$message['name']."</p>"?>
    <?php if(isset($message['pass'])) echo "<p class='error'>".$message['pass']."</p>"?>
    <img id="pen" class="pic" src="../img/pencil.png" alt="鉛筆">
    <img id="school" class="pic" src="../img/school2.png" alt="学校">
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
        <th>なまえ</th>
        <td>
          <input type="text" name="name" placeholder="なまえ" class="square" size="20">
        </td>
      </tr>
      <tr>
        <th>出席番号</th>
        <td>
          <select name="num" class="square">
            <?php for($num = 0; $num < 45; $num++){
              echo '<option value="',$num,'">', $num,'</option>';
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <th>パスワード</th>
        <td>
          <input type="password" name="pass" placeholder="パスワード"　class="square" size="20">
        </td>
      </tr>
    </table>
    <input type="submit" id="btn" value="ロ グ イ ン">
    </form>
    <p id="go_signup"><a href="signup.php">パスワードをかえる</a></p>
  </div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
