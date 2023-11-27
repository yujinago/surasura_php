<?php
require_once __DIR__ . '/../../../tennis_config.php';

$name = $_POST['name'];
$title = $_POST['title'];
$body = $_POST['body'];
$pass = $_POST['pass'];

if ($name == '' || $body == '') {
  header("Location: bbs.php");
  exit();
}

if (!preg_match("/^[0-9]{4}$/", $pass)) {
  header("Location: bbs.php");
  exit();
}

setcookie('name', $name, time() + 60*60*24*30);

try {
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $stmt = $db->prepare('INSERT INTO bbs (name, title, body, date, pass) VALUES (:name, :title, :body, now(), :pass)');
  $stmt->bindparam(':name', $name, PDO::PARAM_STR);
  $stmt->bindparam(':title', $title, PDO::PARAM_STR);
  $stmt->bindparam(':body', $body, PDO::PARAM_STR);
  $stmt->bindparam(':pass', $pass, PDO::PARAM_STR);
  $stmt->execute();
  $db = null;

  header('Location: bbs.php');
  exit();
} catch (PDOException $e) {
  exit('エラー：' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '<br>');
}
?>