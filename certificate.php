<?php
//  working code //
header('content-type:image/jpeg');
$font="c:/windows/fonts/ARIAL.ttf";
$img = imagecreatefromjpeg("Certificate1.jpg");
$color=imagecolorallocate($img,255,255,255);
$name="Vishal Gupta lksfjlkj efhkhsdkf ksdjfkldsjfkjkds";
imagettftext($img,40,0,100,100,$color,$font,$name);
imagejpeg($img,"pic/new4.jpg");
imagedestroy($img);
?>
