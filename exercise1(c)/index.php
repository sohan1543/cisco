<?php

$values = array( 
    250,113,
    150,113,
    100,200,
    150,287,
    250,287,
    300,200
); 

$image = imagecreatetruecolor(400, 400);
$background_color = imagecolorallocate($image, 0, 0, 0); 
imagefill($image, 0, 0, $background_color);
$white = imagecolorallocate($image, 255, 255, 255);
imagepolygon($image, $values, 6, $white);

imagearc($image, 200, 200, 150, 150,  0, 360, $white);

$values = array( 
    200,150,
    150,200,
    200,250,
    250,200
);
imagepolygon($image, $values, 4, $white);
header('Content-type: image/png'); 

imagepng($image);
?>