<?php
require_once("User.php");

$diary_id = $_POST['diary_id'];
$body = $_POST['body'];
$list = array("diary_id" => $diary_id, "body" => $body);
header("Content-type: application/json; charset=UTF-8");
echo json_encode($list);

if($_POST){
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();
  $user->comment($list);
  $_POST = array();
}

exit;

?>
