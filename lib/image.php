<?php 
function resizeImage($file, $width, $height){
    $pathinfo = pathinfo(trim($file, '/'));
    $output = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '_' . $width . 'X' . $height . '.' . $pathinfo['extension'];

    $info = getimagesize($file);
    list($width_old, $height_old) = $info;

    switch ($info[2]) {
        case IMAGETYPE_GIF: $image = imagecreatefromgif($file); break;
        case IMAGETYPE_PNG: $image = imagecreatefrompng($file); break;
        case IMAGETYPE_JPEG: $image = imagecreatefromjpeg($file); break;
        default: return false;

    }
}









 ?>