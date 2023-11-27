<?php
session_start();

if (isset($_SESSION['id'])) {
  header('Location: index.php');
} else if (isset($_POST['name']) && isset($_POST['password'])) {
  try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $db->prepare("SELECT * FROM users WHERE name = :name AND password = :pass");
    $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
    $stmt->bindParam(':pass', hash("sha256", $_POST['password']), PDO::PARAM_STR);
    $stmt->execute();

    if ($row = $stmt->fetch()) {
      $_SESSION['id'] = $row['id'];
      header('Location: index.php');
      exit();
    } else {
      header('Location: login.php');
      exit();
    }
  } catch (PDOException $e) {
    exit('エラー：' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '<br>');
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>サークルサイト</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style type="text/css">
      form {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
        text-align: center;
      }
      #name {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
      }
      #password {
        margin-bottom: 10px;
        border-top-right-radius: 0;
        border-top-left-radius: 0;
      }
    </style>
  </head>
  <body>
    <?php include('navbar.php'); ?>
    <main role="main" class="container" style="padding:60px 15px 0;">
      <div>
        <h1>お知らせ</h1>
        <?php
        if ($fp) {
          $title = fgets($fp);
          if ($title) {
            echo '<p><a href="info.php">' . $title . '</a></p>';
          } else {
            echo '<p>お知らせはありません。</p>';
          }
          fclose($fp);
        } else {
          echo '<p>お知らせはありません。</p>';
        }
        ?>
      </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
  </body>
</html>