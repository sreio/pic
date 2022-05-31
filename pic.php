<?php
$width = $_GET['width'] ?? '';
$height = $_GET['height'] ?? '';
$ext = $_GET['ext'] ?? '';
$level = intval($_GET['level'] ?? '');
if (empty($width) || empty($height) || empty($ext)) return;

// 新建一个真彩色图像
$img = imagecreatetruecolor($width, $height);
// 为一幅图像分配颜色
$text_color = imagecolorallocate($img, 255, 255, 255);
// var_dump($text_color);die;
//水平方向 画一行字符串
imagestring($img, 5, 0, $height / 2,  sprintf('%s*%s by:sreio', $width, $height), $text_color);

ob_start();

switch ($ext){
    case "gif":
        imagegif($img);
        break;
    case "jpeg":
    case "jpg":
        imagejpeg($img, NULL, $level);
        break;
    case "png":
        imagepng($img, NULL, $level);
        break;
}

$final_image = ob_get_contents();

ob_end_clean();
// 释放内存
imagedestroy($img);

$filename = sprintf('%s_%s_%s.%s', $width, $height, time(), $ext);
header('Content-Type: application/octet-stream');
header('Content-Type: image/' . $ext);
header('Content-Disposition: attachment;filename='.$filename);
echo $final_image;exit;