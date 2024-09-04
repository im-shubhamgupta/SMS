<?php
$x = 480;
$y = 320;
$image=imagecreate($x,$y);
$white=imagecolorallocate($image,255,255,255);

imagejpeg($image);
header('Content-Type:image/jpeg');
?>

