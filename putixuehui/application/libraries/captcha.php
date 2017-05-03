<?php
session_start();
class CI_Captcha
{

	var $font = 'style/uwe.ttf';

	function generateCode($characters)
	{
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code = '';
		$i = 0;

		while ($i < $characters)
		{
			$code .= substr($possible, mt_rand(0, strlen($possible) - 1), 1);
			$i ++;
		}
		return $code;
	}

	function CaptchaSecurityImages($width = '120', $height = '40', $characters = '6')
	{
		$code = $this->generateCode($characters);
		/* font size will be 75% of the image height */
		$font_size = $height * 0.6;
		$image = imagecreate($width, $height) or die('Cannot Initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 20, 40, 100);
		$noise_color = imagecolorallocate($image, 100, 120, 180);
		/* generate random dots in background */
		for ($i = 0; $i < ($width * $height) / 3; $i ++)
		{
			imagefilledellipse($image, mt_rand(0, $width), mt_rand(0, $height), 1, 1, $noise_color);
		}
		/* generate random lines in background */
		for ($i = 0; $i < ($width * $height) / 150; $i ++)
		{
			imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $noise_color);
		}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code);
		$x = ($width - $textbox[4]) / 2;
		$y = ($height - $textbox[5]) / 2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font, $code);
		/* output captcha image to browser */
		imagejpeg($image);
		imagedestroy($image);
		$_SESSION['security_code'] = $code;
	}
}
