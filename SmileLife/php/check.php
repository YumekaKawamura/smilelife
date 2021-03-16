<?php
require_once("User.php");

$diary_id = $_POST['diary_id'];
$user_id = $_POST['user_id'];

$list = array("user_id" => $user_id,"diary_id" => $diary_id);
header("Content-type: application/json; charset=UTF-8");
echo json_encode($list);

if($_POST){
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();
  $user->checked($list);
}

exit;

?>
