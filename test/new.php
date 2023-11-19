<?php
$blog = mktime(15, 30, 0, 11, 18, 2023);
if ($blog >= time() - 86400) {
  echo "NEW";
}
?>