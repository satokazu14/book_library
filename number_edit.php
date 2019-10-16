<?php
require_once './func.php';
require_once './config.php';

//リダイレクト
if (isset($_POST['action'])) {
  header('location: index.php');
}

//巻数を増減させる処理
if ($_POST['action'] === 'minus_item') {
  //minus
  //DB接続
  $cn = new mysqli(HOST, DB_USER, DB_PASS, DB_NAME);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  $cn->set_charset("utf-8");

  $query = "UPDATE book SET max_number = max_number-1 WHERE id = ?";
  $stmt = $cn->prepare($query);
  $stmt->bind_param("i", $_POST['id']);
  $stmt->execute();
  $cn->close();
} else {
  //plus
  //DB接続
  $cn = new mysqli(HOST, DB_USER, DB_PASS, DB_NAME);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  $cn->set_charset("utf-8");

  $query = "UPDATE book SET max_number = max_number+1 WHERE id = ?";
  $stmt = $cn->prepare($query);
  $stmt->bind_param("i", $_POST['id']);
  $stmt->execute();
  $cn->close();
}
//巻数を増減させる処理ここまで
