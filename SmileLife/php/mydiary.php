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

  if(!empty($_GET['diary_id'])){
    $result = $user->findBody($_GET['diary_id']);
    $date = $result['created_at'];
    $id = $result['id'];

    $comment = $user->findComment($_GET['diary_id']);
    $count = $user->checkCount($_GET['diary_id']);
    $_GET['diary_id'] = array();
  }
  elseif($_GET){
    $result = $user->findBody($_GET['id']);
    $date = $result['created_at'];
    $id = $result['id'];

    $comment = $user->findComment($_GET['id']);
    $count = $user->checkCount($_GET['id']);
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
<link rel="stylesheet" type="text/css" href="../css/mydiary.css">
<link rel="stylesheet" type="text/css" href="../css/base.css">
<link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
<link href="https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery.js"></script>

<script>

$(function(){
  $("#ms_btn").on('click',function(){
    let diary_id = $("#diary_id").val();
    let body = $("#textareabox").val();
    $.ajax({
          type: 'POST', // HTTPリクエストメソッドの指定
          url: "ajax.php", // 送信先URLの指定
          async: true, // 非同期通信フラグの指定
          dataType: 'json', // 受信するデータタイプの指定
          data: {
            "diary_id": diary_id,"body": body // クエリパラメータの指定。サーバーに送信したいデータを指定
          }
      })
      .done(function(data) {
        // 通信が成功したときの処理
        $("#message").append('<p>'+data.body+'</p>');
      })
      .fail(function() {
        // 通信が失敗したときの処理
        alert('コメントできませんでした');
      });

  });

  $("#saw").on('click',function(){
    let diary_id = $("#diary_id").val();
    let user_id = $("#user_id").val();
    $.ajax({
          type: 'POST', // HTTPリクエストメソッドの指定
          url: "check.php", // 送信先URLの指定
          async: true, // 非同期通信フラグの指定
          dataType: 'json', // 受信するデータタイプの指定
          data: {
            "user_id": user_id,"diary_id": diary_id// クエリパラメータの指定。サーバーに送信したいデータを指定
          }
      })
      .done(function(data) {
        // 通信が成功したときの処理
        $("#saw").css("background-color","pink");
      })
      .fail(function() {
        // 通信が失敗したときの処理
        alert('閲覧済みにできませんでした');
      });

  });

});


</script>



</head>
<body>
  <?php
  require('header.php');
  ?>
  <div id="main">
  <h2><?php echo $date.'の日記';?></h2>
  <div id="back">
  <div id="title">
    <p><?= h($result['title'])?></p>
  </div>
  <div class="diary">
    <p><?= $result['body']?></p>
  </div>
 </div>
 <div class="diary">
   <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['User']['id']?>">
  <button id="<?php if($count['count']==0) echo 'saw';?>" class="<?php if($count['count']!==0) echo 'zumi';?>">見ました！</button>
</div>
  <div id="comment">
    <?php foreach ($comment as $key):?>
    <p><?= h($key['body'])?></p>
    <?php endforeach;?>
  </div>
  <div id="message"></div>
  <?php if($_SESSION['User']['role'] == "1"):?>
    <form id="form">
    <input type="hidden" name="diary_id" id="diary_id" value="<?= $id?>">
    <textarea name="body" wrap="hard" cols="90" rows="3" id="textareabox"></textarea>
  <button id="ms_btn">コメント</button>
</form>
  <?php endif;?>
  <div id="btn">
    <p><a href="mypage.php?id=<?= $result["user_id"]?>">マイページにもどる</a></p>
  </div>
</div>
  <?php
  require('footer.php');
  ?>
</body>
</html>
