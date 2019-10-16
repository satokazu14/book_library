<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css?<?php echo filemtime('css/style.css'); ?>">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <title>Document</title>
</head>

<body>
  <div class="container mt-2 mb-2">
    <form method="get" action="">
      <div class="row">
        <div class="form-group col-lg-3 mt-2">
          <label>タイトル:</label>
          <select name="asc" class="form-control">
            <option value="">-----</option>
            <option value="asc" <?php echo $asc ?>>昇順</option>
            <option value="desc" <?php echo $desc ?>>降順</option>
          </select>
        </div>
        <div class="form-group col-lg-3 mt-2">
          <label>タグ①:</label>
          <select name="tag_1" class="form-control">
            <option value="">-----</option>
            <?php foreach ($tag_1_array as $tag_1) : ?>
              <option value="<?php echo $tag_1['tag_1'] ?>" <?php echo $tag_1['selected'] ?>><?php echo $tag_1['tag_1'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group col-lg-3 mt-2">
          <label>タグ②:</label>
          <select name="tag_2" class="form-control">
            <option value="">-----</option>
            <?php foreach ($tag_2_array as $tag_2) : ?>
              <option value="<?php echo $tag_2['tag_2'] ?>" <?php echo $tag_2['selected'] ?>><?php echo $tag_2['tag_2'] ?></option>
            <?php endforeach ?>
          </select>
        </div>


        <div class="form-group col-lg-3 mt-2">
          <label>タイトル検索</label>
          <input class="form-control" type="text" name="title" value="<?php echo $title ?>">
          <button class="btn btn-default border mt-2 mb-2 float-right" type="submit">絞り込み</button>
        </div>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-bordered text-nowrap mt-2">
        <thead class="thead-light">
          <tr>
            <th>タイトル</th>
            <th>所持している巻数</th>
            <th>タグ①</th>
            <th>タグ②</th>
            <th style="width:5%">編集</th>
            <th style="width:5%">削除</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($row)) : ?>
            <tr>
              <td colspan="6" class="center">登録されているデータがありません</td>
            </tr>
          <?php else : ?>
            <?php foreach ($row as $val) : ?>
              <tr>
                <td><span><?php echo $val['title'] ?></span><input type="text" value="<?php echo $val['title'] ?>" class="edit title"></td>
                <td><span><?php echo $val['max_number'] ?></span><input type="number" value="<?php echo $val['max_number'] ?>" class="edit number">巻　<span><i class="far fa-minus-square minus" itemno="<?php echo $val['id'] ?>"></i></span> <span><i class="far fa-plus-square plus" itemno="<?php echo $val['id'] ?>"></i></span></td>
                <td><span><?php echo $val['tag_1'] ?></span><input type="text" value="<?php echo $val['tag_1'] ?>" class="edit tag_1"></td>
                <td><span><?php echo $val['tag_2'] ?></span><input type="text" value="<?php echo $val['tag_2'] ?>" class="edit tag_2"></td>
                <td class="center"><i class="fas fa-edit editItem" itemno="<?php echo $val['id'] ?>"></i><i class="fas fa-check text-success saveItem" itemno="<?php echo $val['id'] ?>"></i></td>
                <td class="center"><i class="fas fa-trash-alt text-danger deleteItem" itemno="<?php echo $val['id'] ?>"></i></td>
              </tr>
            <?php endforeach ?>
          <?php endif ?>
        </tbody>
      </table>
    </div>
    <a href="add.php">追加</a>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/script.js?<?php echo filemtime('js/script.js'); ?>"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>