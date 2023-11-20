<?php
function vending_machine($price, $juice_name) {
  if ($price >= 120) {
    return $juice_name . "のお買い上げありがとうございます！<br>";
  } else {
    return $juice_name . "の購入金額が不足しています<br>";
  }
}

echo vending_machine(120, "オレンジジュース");

$price = 90;
$juice_name = "アップルジュース";
echo vending_machine($price, $juice_name);
?>