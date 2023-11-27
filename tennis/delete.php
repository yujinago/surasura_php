<?php
include 'includes/login.php';
require_once __DIR__ . '/../../../tennis_config.php';

$id = intval($_POST['id']);
$pass = $_POST['pass'];

if ($id == '' || $pass == '') {
  header('Location: bbs.php');
  exit();
}

try {
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $stmt = $db->prepare("DELETE FROM bbs WHERE id = :id AND pass = :pass");
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
  $stmt->execute();
} catch (PDOException $e) {
  exit('エラー：' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '<br>');
}
header('Location: bbs.php');
exit();
?>