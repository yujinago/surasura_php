<?php
$new_width = 200;

list($width, $height) = getimagesize($_FILES['file']['tmp_name']);

$rate = $new_width / $width;
$new_height = $rate * $height;

$canvas = imagecreatetruecolor($new_width, $new_height);

switch(exif_imagetype($_FILES['file']['tmp_name'])) {
  
}
?>