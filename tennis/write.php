<?php
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

?>