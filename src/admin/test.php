<?php
require('../db_connect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$form['month'] = filter_input(INPUT_POST, 'month', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$stmt = $db->prepare('update agents set list_status=1 where id = :id');
// こんな感じに書いて↑
$stmt->bindValue(':id', $form['month'], PDO::PARAM_INT);//ここに$form['month']いれる
$stmt->execute();

}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="" method="POST">
    <input type="month" name="month" value="<?php echo $form['month']; ?>"/>
    <input type="submit" value="日月を変更" />
  </form>

  <?php var_dump($form['month']) ?>

</body>

</html>