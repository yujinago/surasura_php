<?php
include 'vendor.php';

echo vending_machine(120, "オレンジジュース");

$price = 90;
$juice_name = "アップルジュース";
echo vending_machine($price, $juice_name);
?>