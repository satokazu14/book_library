<?php
require_once './func.php';
require_once './config.php';

$title = '';
$asc = '';
$desc = '';
$sqlParams = array();
$sqlParams[0] = '';

//一覧取得
//基本SQL
$query = "SELECT * FROM book WHERE del_flg = 0";

//tag_1による絞り込み
if (!empty($_GET['tag_1'])) {
  $query .= " AND tag_1 = ?";
  $sqlParams[0] .= 's';
  $sqlParams[] = $_GET['tag_1'];
}
//tag_2による絞り込み
if (!empty($_GET['tag_2'])) {
  $query .= " AND tag_2 = ?";
  $sqlParams[0] .= 's';
  $sqlParams[] = $_GET['tag_2'];
}
//タイトルによる絞り込み
if (!empty($_GET['title'])) {
  $query .= " AND title LIKE ?";
  $sqlParams[0] .= 's';
  $sqlParams[] = "%".$_GET['title']."%";
  $title = $_GET['title'];
}
//昇順降順
if (!isset($_GET['asc']) || empty($_GET['asc'])) {
  $query .= " ORDER BY id asc";
} elseif ($_GET['asc'] === 'asc') {
  $query .= " ORDER BY title ASC";
  $asc = 'selected';
} else {
  $query .= " ORDER BY title DESC";
  $desc = 'selected';
}


$params = array();
foreach ($sqlParams as $key => $value) {
  $params[$key] = &$sqlParams[$key];
}

//DB接続
$cn = new mysqli(HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}
$cn->set_charset("utf8");

$stmt = $cn->prepare($query);

if ($params[0] !== '') {
  call_user_func_array(array($stmt, 'bind_param'), $params);
}

$stmt->execute();
$row = fetch_all($stmt);
$cn->close();
//一覧取得ここまで

//tag_1の重複なし全件取得
//DB接続
$cn = new mysqli(HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}
$cn->set_charset("utf8");

$query = "SELECT DISTINCT tag_1 FROM book WHERE del_flg = 0";
$stmt = $cn->prepare($query);
$stmt->execute();
$tag_1_array = fetch_all($stmt);
$cn->close();
//tag_1の重複なし全件取得ここまで

//tag_2の重複なし全件取得
//DB接続
$cn = new mysqli(HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}
$cn->set_charset("utf8");

$query = "SELECT DISTINCT tag_2 FROM book WHERE del_flg = 0";
$stmt = $cn->prepare($query);
$stmt->execute();
$tag_2_array = fetch_all($stmt);
$cn->close();
//tag_2の重複なし全件取得ここまで

//selectタグのselected付与
//tag_1
foreach ($tag_1_array as $key => $value) {
  if (empty($_GET['tag_1']) || $value['tag_1'] != $_GET['tag_1']) {
    $tag_1_array[$key]['selected'] = '';
  } else {
    $tag_1_array[$key]['selected'] = 'selected';
  }
}

//tag_2
foreach ($tag_2_array as $key => $value) {
  if (empty($_GET['tag_2']) || $value['tag_2'] != $_GET['tag_2']) {
    $tag_2_array[$key]['selected'] = '';
  } else {
    $tag_2_array[$key]['selected'] = 'selected';
  }
}
//selectタグのselected付与ここまで

require './tpl/index.php';
