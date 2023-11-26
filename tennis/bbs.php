<?php
require_once __DIR__ . '/../../../tennis_config.php';
$num = 10;

$page = 1;
if (isset($_GET['page']) && $_GET['page'] > 1) {
  $page = intaval($_GET['page']);
}

try {
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $stmt = $db->prepare("SELECT * FROM bbs ORDER BY date DESC LIMIT :page, :num");
  $page = ($page-1) * $num;
  $stmt->bindParam(':page', $page, PDO::PARAM_INT);
  $stmt->bindParam(':num', $num, PDO::PARAM_INT);
  $stmt->execute();
} catch (PDOException $e) {
  exit('エラー：' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '<br>');
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>サークルサイト</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  </head>
  <body>
    <?php include('navbar.php'); ?>
    <main role="main" class="container" style="padding:60px 15px 0;">
      <div>
        <h1>掲示板</h1>
        <form action="write.php" method="post">
          <div class="form-group">
            <label>タイトル</label>
            <input type="text" name="title" class="form-control">
          </div>
          <div class="form-group">
            <label>名前</label>
            <input type="text" name="name" class="form-control">
          </div>
          <div class="form-group">
            <textarea name="body" class="form-control" rows="5"></textarea>
          </div>
          <div class="form-group">
            <label>削除パスワード(数字4桁)</label>
            <input type="text" name="pass" class="form-control">
          </div>
          <input type="submit" class="btn btn-primary" value="書き込む">
        </form>
        <hr>
        <?php while ($row = $stmt->fetch()): ?>
          <div class="card">
            <div class="card-header">
              <?php echo $row['title']? $row['title']: '（無題）' ?>
            </div>
            <div class="card-body">
              <p class="card-text">
                <?php echo nl2br($row['body']) ?>
              </p>
            </div>
            <div class="card-footer">
              <?php echo $row['name'] ?>
              (<?php echo $row['date'] ?>)
            </div>
          </div>
          </hr>
        <?php endwhile; ?>

        <?php
        try {
          $stmt = $db->prepare("SELECT COUNT(*) FROM bbs");
          $stmt->execute();
        } catch (PDOException $e) {
          exit('エラー：' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '<br>');
        }

        $comments = $stmt->fetchColumn();
        $max_page = ceil($comments / $num);
        if ($max_page >= 1) {
          echo '<nav><ul class="pagination">';
          for ($i = 1; $i <= $max_page; $i++) {
            echo '<li class="page-item"><a href="bbs.php?page=' . $i . '">' . $i . '</a></li>';
          }
          echo '</ul></nav>';
        }
        ?>
      </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
  </body>
</html>