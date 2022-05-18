<?php
session_start();
require('../../db_connect.php');
if (isset($_SESSION['form'])) {
  $form = $_SESSION['form'];
  // var_dump($form);
} else {
  header('location: entry.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $db->prepare('insert into students (name, collage, department, class_of, email, tel, address, memo) VALUES (:name, :collage, :department, :class_of, :email, :tel, :address, :memo)');
  $stmt->bindValue('name', $form['name'], PDO::PARAM_STR);
  $stmt->bindValue('collage', $form['collage'], PDO::PARAM_STR);
  $stmt->bindValue('department', $form['department'], PDO::PARAM_STR);
  $stmt->bindValue('class_of', $form['class_of'], PDO::PARAM_INT);
  $stmt->bindValue('email', $form['email'], PDO::PARAM_STR);
  $stmt->bindValue('tel', $form['tel'], PDO::PARAM_STR);
  $stmt->bindValue('address', $form['address'], PDO::PARAM_STR);
  $stmt->bindValue('memo', $form['memo'], PDO::PARAM_STR);
  if (!$stmt) {
    die($db->error);
  }
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }

  // students_contactsへ一斉送信
  $stmt = $db->query('select id from students where id = LAST_INSERT_ID()');
  $student_id = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt = $db->prepare('insert into students_contacts (student_id, agent_id) VALUES (:student_id, :agent_id)');
  foreach ($form['student_contacts'] as $student_contact) :
    $stmt->bindValue('student_id', $student_id['id'], PDO::PARAM_INT);
    $stmt->bindValue('agent_id', $student_contact, PDO::PARAM_INT);
    if (!$stmt) {
      die($db->error);
    }
    $success = $stmt->execute();
    if (!$success) {
      die($db->error);
    }
  endforeach;

  unset($_SESSION['form']);
  header('location: thanks.html');
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>userEntry</title>
  <link rel="stylesheet" href="./style.css" />
  <!-- <script src="./js/jquery-3.6.0.min.js"></script>
  <script src="./js/script.js" defer></script> -->
</head>

<body>
  <main>
    <div class="box_con">
      <form method="post" action="">
        <table class="formTable">
          <!-- <tr>
          <th>問い合わせるエージェント　※問い合わせないエージェントはチェックボックスを外してください</th>
          <td>
            <div class="box_br">
              <label>
                <input name="contact_type" type="radio" value="1" class="radio02-input in_top" id="radio02-01">
                <label for="radio02-01">テキスト1</label>
              </label>
            </div>
            <div class="box_br">
              <label>
                <input name="contact_type" type="radio" value="1" class="radio02-input in_top" id="radio02-02">
                <label for="radio02-02">テキスト2</label>
              </label>
            </div>
          </td>
        </tr> -->
          <!-- <tr>
          <th>ご用件</th>
          <td><select name="ご用件">
              <option value="">選択してください</option>
              <option value="ご質問・お問い合わせ">ご質問・お問い合わせ</option>
              <option value="リンクについて">リンクについて</option>
            </select></td>
        </tr> -->
          <tr>
            <th>お名前<span>必須</span></th>
            <td><?php echo h($form["name"]); ?>
            </td>
          </tr>
          <tr>
            <th>電話番号（半角）<span>必須</span></th>
            <td><?php echo h($form["tel"]); ?>
            </td>
          </tr>
          <tr>
            <th>Mail（半角）<span>必須</span></th>
            <td><?php echo h($form["email"]); ?>
            </td>
          </tr>
          <th>学校名 <span>必須</span></th>
          <td><?php echo h($form["collage"]); ?>
          </td>
          </tr>
          <tr>
            <th>学部/学科 <span>必須</span></th>
            <td><?php echo h($form["class_of"]); ?>
            </td>
          </tr>
          <tr>
            <th>住所 <span>必須</span></th>
            <td><?php echo h($form["address"]); ?>
            </td>
          </tr>
          <tr>
            <th>自由記入欄<br /></th>
            <td><?php echo h($form["memo"]); ?>
          </tr>
        </table>
        <p class="btn">
          <a href="entry.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <span><input type="submit" value="　 送信 　" /></span>
        </p>
      </form>
    </div>
  </main>
</body>

</html>