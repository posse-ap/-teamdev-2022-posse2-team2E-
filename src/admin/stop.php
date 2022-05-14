<?php 
require('../db_connect.php');
$id = $_GET['id'];
if(!$id){
  echo 'メモが正しく指定されていません';
  exit();
}
$stmt = $db->prepare('update agents set list_status=2 where id = :id');
$stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
$stmt->execute();
header('location: agentList.php');
?>