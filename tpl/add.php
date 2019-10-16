<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <link rel="stylesheet" href="css/style.css?<?php echo filemtime('css/style.css'); ?>">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <title>Document</title>
</head>

<body>
  <div class="container mb-2 mt-2">
    <form method="get" action="">
      <div class="form-group">
        <label>タイトルで検索</label>
        <input class="form-control" type="text" name="val" value="<?php echo $title ?>">
      </div>
      <button class="btn btn-default border mt-2 mb-2 float-right" type="submit">検索</button>
    </form>
    <h2><?php echo $text ?></h2>
    <div class="table-responsive-xl">
      <table class="table table-bordered col-11 mx-auto">
        <tbody>
          <?php foreach ($display as $val) : ?>
            <?php if ($val['volumeInfo']['allowAnonLogging'] && $val['volumeInfo']['language'] == 'ja') : ?>
              <tr>
                <td class="center" style="width:15%">
                  <img src="<?php echo $val['volumeInfo']['imageLinks']['smallThumbnail'] ?>" alt="" class="">
                </td>
                <td class="add">
                  <h4><?php echo $val['volumeInfo']['title'] ?></h4>
                  <?php if (isset($val['volumeInfo']['description'])) : ?>
                    <p><?php echo $val['volumeInfo']['description'] ?></p>
                  <?php endif ?>
                  <?php if (empty($val['already'])) : ?>
                    <form method="post" action="">
                      <input type="hidden" value="<?php echo $val['volumeInfo']['title'] ?>" name="title">
                      <span class="bottom"><button class="btn btn-default border add" value="<?php echo $val['volumeInfo']['industryIdentifiers'][0]['identifier'] ?>" type="submit" name="add">追加</button></span>
                    </form>
                  <?php else : ?>
                    <span class="already"><?php echo $val['already'] ?></span>
                  <?php endif ?>
                </td>
              </tr>
            <?php endif ?>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <a href="index.php">一覧</a>
  </div>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/script.js?<?php echo filemtime('js/script.js'); ?>"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>