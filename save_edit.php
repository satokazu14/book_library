<?php
require_once './func.php';
require_once './config.php';

//リダイレクト
if ($_POST['action'] !== 'save_edit') {
  header('location: index.php');
}

//情報を編集する処理
//DB接続
$cn = new mysqli(HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}
$cn->set_charset("utf-8");

$query = "UPDATE book SET title = ?,max_number = ?,tag_1 = ?,tag_2 = ? WHERE id = ?";
$stmt = $cn->prepare($query);
$stmt->bind_param("sissi", $_POST['title'], $_POST['number'], $_POST['tag_1'], $_POST['tag_2'], $_POST['id']);
$stmt->execute();
$cn->close();
//情報を編集する処理ここまで