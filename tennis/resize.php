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
}
?>