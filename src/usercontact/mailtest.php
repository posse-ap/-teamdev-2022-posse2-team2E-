<?php
// session_start();
require('../db_connect.php');

// //ログインされていない場合は強制的にログインページにリダイレクト
// if (!isset($_SESSION["login"])) {
//     header("Location: ../login/login.php");
//     exit();
// }


// if (isset($_SESSION['form']) && isset($_SESSION['form']['student_contacts'])) {
//   $form = $_SESSION['form'];
//   // var_dump($form);
// } else {
//   // var_dump($_SESSION['form']);//rewriteのときcontactNULL
//   // header('location: index.php');
//   // exit();
// }

$form = array(
  'name' => '渡邊美由貴',
  'collage' => '慶應大学',
  'department' => '経済学部',
  'class_of' => '24',
  'email' => 'miyuki@gmail.com',
  'tel' => '08099993333',
  'address' => '墨田区アパート3-3-3',
  'memo' => '',
  'acceptance' => '',
  'student_contacts' => array(
    0 => 3,
    1 => 5,
  ),
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // $stmt = $db->prepare('insert into students (name, collage, department, class_of, email, tel, address, memo) VALUES (:name, :collage, :department, :class_of, :email, :tel, :address, :memo)');
  // $stmt->bindValue('name', $form['name'], PDO::PARAM_STR);
  // $stmt->bindValue('collage', $form['collage'], PDO::PARAM_STR);
  // $stmt->bindValue('department', $form['department'], PDO::PARAM_STR);
  // $stmt->bindValue('class_of', $form['class_of'], PDO::PARAM_INT);
  // $stmt->bindValue('email', $form['email'], PDO::PARAM_STR);
  // $stmt->bindValue('tel', $form['tel'], PDO::PARAM_STR);
  // $stmt->bindValue('address', $form['address'], PDO::PARAM_STR);
  // $stmt->bindValue('memo', $form['memo'], PDO::PARAM_STR);
  // if (!$stmt) {
  //   die($db->error);
  // }
  // $success = $stmt->execute();
  // if (!$success) {
  //   die($db->error);
  // }

  // // students_contactsへ一斉送信
  // $stmt = $db->query('select id from students where id = LAST_INSERT_ID()');
  // $student_id = $stmt->fetch(PDO::FETCH_ASSOC);
  // $stmt = $db->prepare('insert into students_contacts (student_id, agent_id) VALUES (:student_id, :agent_id)');
  // foreach ($form['student_contacts'] as $student_contact) :
  //   $stmt->bindValue('student_id', $student_id['id'], PDO::PARAM_INT);
  //   $stmt->bindValue('agent_id', $student_contact, PDO::PARAM_INT);
  //   if (!$stmt) {
  //     die($db->error);
  //   }
  //   $success = $stmt->execute();
  //   if (!$success) {
  //     die($db->error);
  //   }
  // endforeach;

  // agentへ一斉送信
  // agent email
  $stmt = $db->prepare('select * from agents where id = :id');
  // var_dump($form['student_contacts']);
  foreach ($form['student_contacts'] as $student_contact) :
    $stmt->bindValue('id', (int)$student_contact, PDO::PARAM_INT);
    $stmt->execute();
    $agent = $stmt->fetch(PDO::FETCH_ASSOC);  

    // var_dump($agents_email);
  mb_language("Japanese");
	mb_internal_encoding("UTF-8");
 
	$to = $agent['to_send_email'];
	$subject = '【boozer株式会社】学生お問い合わせのお知らせ';
  $message = "※このメールはシステムからの自動返信です
  
  ".$agent['client_name']."様
  
  お世話になっております。
  Boozer株式会社でございます。
  
  以下の内容で弊社サイトからお問い合わせがありました。
  いたずらメールとご判断されましたら、お手数ですが管理サイトから通報をお願いします。確認次第、請求対象からお外しします。

  また、なにかありましたら、craft@boozer.comにお問い合わせください。なお、営業時間は平日9時〜18時となっております。
  時間外のお問い合わせは翌営業日にご連絡差し上げます。
  
  ご理解・ご了承の程よろしくお願い致します。
  
  ━━━━━━□■□　お問い合わせ内容　□■□━━━━━━
  氏名：".h($form["name"])."
  電話番号：".h($form["tel"])."
  Email：".h($form["email"])."
  学校名(大学/大学院/専門学校/短大/高校等)：".h($form["collage"])."
  学部/学科：".h($form["department"])."
  卒業年度：".h($form["class_of"])."年卒
  住所：".h($form["address"])."
  備考欄：".h($form["memo"])."
  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  
  ———————————————————————
  craft運営 boozer株式会社事務局
  担当：山田　太郎
  TEL:080-3434-2435
  Email:craft@boozer.com
  
  【会社情報】
  住所：〒111-1111　東京都港区●●5-6-7-8
  電話番号：090-1000-2000
  営業時間：平日 9時～18時
  ———————————————————————";
  $header = ['From'=>'craft@boozer.com', 'Content-Type'=>'text/plain; charset=UTF-8', 'Content-Transfer-Encoding'=>'8bit'];
  $result = mb_send_mail($to,$subject,$message,$header);
  if(!$result){
    echo 'メールの送信に失敗しました';
  }
endforeach;
  // agentへ一斉送信ここまで

  //学生問い合わせ確認メール
  mb_language("Japanese");
	mb_internal_encoding("UTF-8");
  $to = $form['email'];
	$subject = '問い合わせ確認メール';
  $message = 'エージェント企業への問い合わせを送信しました。
  改行は反映される？';
  $header = ['From'=>'craft@boozer.com', 'Content-Type'=>'text/plain; charset=UTF-8', 'Content-Transfer-Encoding'=>'8bit'];
  $result = mb_send_mail($to,$subject,$message,$header);
  if(!$result){
    echo 'メールの送信に失敗しました';
  }







  // unset($_SESSION['form']);
  header('location: mailtest.php');
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
          <tr>
            <th>氏名<span>必須</span></th>
            <td><?php echo h($form["name"]); ?>
            </td>
          </tr>
          <tr>
            <th>電話番号（半角）<span>必須</span></th>
            <td><?php echo h($form["tel"]); ?>
            </td>
          </tr>
          <tr>
            <th>Email（半角）<span>必須</span></th>
            <td><?php echo h($form["email"]); ?>
            </td>
          </tr>
          <th>学校名(大学/大学院/専門学校/短大/高校等) <span>必須</span></th>
          <td><?php echo h($form["collage"]); ?>
          </td>
          </tr>
          <tr>
            <th>学部/学科 <span>必須</span></th>
            <td><?php echo h($form["department"]); ?>
            </td>
          </tr>
          <tr>
            <th>卒業年度 <span>必須</span></th>
            <td><?php echo h($form["class_of"]); ?>年度卒
            </td>
          <tr>
            <th>住所 <span>必須</span></th>
            <td><?php echo h($form["address"]); ?>
            </td>
          </tr>
          </tr>
          <tr>
            <th>備考欄</th>
            <td><?php echo h($form["memo"]); ?>
          </tr>
          <tr>
            <th>問い合わせるエージェント企業の確認(実際はカードを表示)</th>
            <td>
              <?php foreach ($form['student_contacts'] as $student_contact) : ?>
                <input type="checkbox" checked disabled name="student_contacts[]" value=""><?= $student_contact ?>
              <?php endforeach; ?>
          </tr>
        </table>
        <p class="btn">
          <a href="entry.php?action=rewrite">&laquo;&nbsp;入力画面へ戻る</a> | <span><input type="submit" value="　 送信 　" /></span>
        </p>
      </form>
    </div>
  </main>
</body>

</html>