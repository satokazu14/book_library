<?php
require_once './func.php';
require_once './config.php';

//リダイレクト
if($_POST['action'] !== 'delete_edit'){
  header('location: index.php');
}

//書籍を削除する処理
//DB接続
$cn = new mysqli(HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}
$cn->set_charset("utf-8");

$query = "UPDATE book SET del_flg = 1 WHERE id = ?";
$stmt = $cn->prepare($query);
$stmt->bind_param("i", $_POST['id']);
$stmt->execute();
$cn->close();