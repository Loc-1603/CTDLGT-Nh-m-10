<?php
session_start();

// Tạo chuỗi captcha ngẫu nhiên
$captcha_text = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 5);

// Lưu vào session
$_SESSION['captcha'] = $captcha_text;

// Tạo ảnh nền trắng
$width = 120;
$height = 40;
$image = imagecreatetruecolor($width, $height);

// Màu sắc
$bg_color = imagecolorallocate($image, 255, 255, 255); // trắng
$text_color = imagecolorallocate($image, 0, 0, 0);     // đen
$line_color = imagecolorallocate($image, 64, 64, 64);  // xám

// Đổ nền
imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

// Vẽ vài đường nhiễu
for ($i = 0; $i < 5; $i++) {
    imageline($image, 0, rand()%$height, $width, rand()%$height, $line_color);
}

// Thêm chữ captcha vào ảnh
$font_size = 5; // font mặc định của GD
imagestring($image, $font_size, 30, 10, $captcha_text, $text_color);

// Xuất ảnh ra trình duyệt
header("Content-Type: image/png");
imagepng($image);
imagedestroy($image);
