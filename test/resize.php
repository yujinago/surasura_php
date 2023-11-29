<?php
$new_width = 200;

list($width, $height) = getimagesize($_FILES['file']['tmp_name']);

$rate = $new_width / $width;
$new_height = $rate * $height;

$canvas = imagecreatetruecolor($new_width, $new_height);

switch(exif_imagetype($_FILES['file']['tmp_name'])) {
  // JPEG
  case IMAGETYPE_JPEG:
    $image = imagecreatefromjpeg($_FILES['file']['tmp_name']);
    imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    imagejpeg($canvas, 'images/new_image.jpg');
    break;

  // GIF
  case IMAGETYPE_GIF:
    $image = imagecreatefromgif($_FILES['file']['tmp_name']);
    imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    imagegif($canvas, 'images/new_image.gif');
    break;

  // PNG
  case IMAGETYPE_PNG:
    $image = imagecreatefrompng($_FILES['file']['tmp_name']);
    imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    imagepng($canvas, 'images/new_image.png');
    break;

  // 画像以外のファイルの時
  default:
    exit();
}
imagedestroy($image);
imagedestroy($canvas);
?>