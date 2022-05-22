<?php

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
  <div>キープされたエージェント○件</div>
  <p>キープされたagentsのidを配列でPOSTする</p>
  <form action="entry.php" method="post">
    <input type=checkbox name=student_contacts[] value="1" checked>かしけんエージェント
    <input type=checkbox name=student_contacts[] value="3" checked>まいのエージェント
    <input type=checkbox name=student_contacts[] value="16" checked>あきらージェント
    <input type="submit" value="問い合わせる">
  </form>
</body>

</html>