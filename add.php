<?php
require_once './func.php';
require_once './config.php';

$text = '';
$result = '';
$title = '';
$display = array();

//DBに書籍を追加
//追加ボタンを押したとき
if (isset($_POST['add'])) {
  //DB接続
  $cn = new mysqli(HOST, DB_USER, DB_PASS, DB_NAME);
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  $cn->set_charset("utf8");

  //既に登録しているか確認
  $query = "SELECT id,title,del_flg FROM book WHERE isbn LIKE ?";
  $stmt = $cn->prepare($query);
  $stmt->bind_param("s", $_POST['add']);
  $stmt->execute();
  $row = fetch_all($stmt);
  $cn->close();
  if (empty($row)) {
    //登録されていなかった場合
    //DB接続
    $cn = new mysqli(HOST, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    $cn->set_charset("utf8");

    //データの登録
    $query = "INSERT INTO book(title,max_number,isbn,del_flg) VALUES(?,1,?,0)";
    $stmt = $cn->prepare($query);
    $stmt->bind_param("ss", $_POST['title'], $_POST['add']);
    $stmt->execute();
    $cn->close();
  } elseif ($row[0]['del_flg'] === 1) {
    //既に登録されていたが削除されていた場合
    //DB接続
    $cn = new mysqli(HOST, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    $cn->set_charset("utf8");

    //削除フラグを0にする
    $query = "UPDATE book SET del_flg = 0 WHERE id = ?";
    $stmt = $cn->prepare($query);
    $stmt->bind_param("i", $row[0]['id']);
    $stmt->execute();
    $cn->close();
  }
}
//DBに書籍を追加ここまで

//検索時
if (!empty($_GET['val'])) {
  $title = $_GET['val'];
  //APIでデータを取得
  $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $_GET['val'] . '+intitle:1';

  $curl = curl_init();

  $option = [
    CURLOPT_URL => $url,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
  ];

  curl_setopt_array($curl, $option);
  $response = curl_exec($curl);
  $result = json_decode($response, true);

  curl_close($curl);

  //取得したデータの整頓
  foreach ($result['items'] as $val) {
    //取得したタイトルに検索した値が含まれているか
    if (strpos($val['volumeInfo']['title'], $_GET['val']) !== false) {
      //日本語の書籍かどうか
      if ($val['volumeInfo']['allowAnonLogging'] && $val['volumeInfo']['language'] == 'ja') {
        $val['volumeInfo']['title'] = str_replace(' ', '', $val['volumeInfo']['title']);
        $val['volumeInfo']['title'] = str_replace('　', '', $val['volumeInfo']['title']);
        //タイトルの最後の'1'を削除
        if (mb_substr($val['volumeInfo']['title'], -1) == '1' || mb_substr($val['volumeInfo']['title'], -1) == '１') {
          $val['volumeInfo']['title'] = mb_substr($val['volumeInfo']['title'], 0, -1);
        }
        //書籍にisbnが登録されていない場合代わりにタイトルを登録
        if (!isset($val['volumeInfo']['industryIdentifiers'][0]['identifier'])) {
          $val['volumeInfo']['industryIdentifiers'][0]['identifier'] = $val['volumeInfo']['title'];
        }
        $cn = new mysqli(HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno()) {
          printf("Connect failed: %s\n", mysqli_connect_error());
          exit();
        }
        $cn->set_charset("utf8");

        //既に登録されているか確認
        $query = "SELECT id,title,del_flg FROM book WHERE isbn LIKE ? AND del_flg = 0";
        $stmt = $cn->prepare($query);
        $stmt->bind_param("s", $val['volumeInfo']['industryIdentifiers'][0]['identifier']);
        $stmt->execute();
        $row = fetch_all($stmt);
        $cn->close();

        $val['already'] = '';
        if(!empty($row)){
          //既に登録されていた場合追加ボタンの代わりに表示
          $val['already'] = '登録済みです';
        }

        $display[] = $val;
      }
    }
  }
  if (empty($display)) {
    //検索結果が存在しなかった場合
    $text = '検索結果は存在しませんでした';
  } else {
    $text = '検索結果';
  }
}
//検索時ここまで

require './tpl/add.php';
