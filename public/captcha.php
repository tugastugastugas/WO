<?php

use Illuminate\Support\Facades\Session;

session_start();

// Menghasilkan nilai CAPTCHA
$captchaValue = substr(md5(rand()), 0, 6); // Menghasilkan string CAPTCHA 6 karakter
// $_SESSION['captcha'] = $captchaValue; // Simpan CAPTCHA ke dalam session
Session::put('captcha', $captchaValue);
// Menggambar CAPTCHA ke dalam gambar
header('Content-type: image/png');
$im = imagecreatetruecolor(70, 30);
$bg = imagecolorallocate($im, 255, 255, 255);
$fg = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 70, 30, $bg);
imagestring($im, 5, 5, 5, $captchaValue, $fg);
imagepng($im);
imagedestroy($im);
