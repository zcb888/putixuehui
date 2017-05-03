﻿<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
+--------------------------------------------------------------------------
| 生成加水印的图片类 (支持水印为图片或者文字)
| ============================
| by JackMing （感谢Dash和其他不知道姓名的朋友支持，本类在这些朋友作品的基础上创建)
+--------------------------------------------------------------------------

$img = new Gimage ();
$img->src_image_name = "./1.gif";
$img->save_image_file = './2.gif';
$img->wm_image_name = "./3.gif";
$img->thumb();//压缩
$img->create ();//加水印
*/

class gimageherple {
	var $src_image_name = ""; //输入图片的文件名(必须包含路径名)
	var $jpeg_quality = 100; //jpeg图片质量
	var $save_image_file = ''; //输出文件名
	var $wm_image_name = ""; //水印图片的文件名(必须包含路径名)
	var $wm_image_pos = 0; //水印图片放置的位置
	// 0 = middle
	// 1 = top left
	// 2 = top right
	// 3 = bottom right
	// 4 = bottom left
	// 5 = top middle
	// 6 = middle right
	// 7 = bottom middle
	// 8 = middle left
	//other = 3
	var $wm_image_transition = 100; //水印图片与原图片的融合度 (1=100)
	

	var $wm_text = ""; //水印文字(支持中英文以及带有\r\n的跨行文字)
	var $wm_text_size = 20; //水印文字大小
	var $wm_text_angle = 4; //水印文字角度,这个值尽量不要更改
	var $wm_text_pos = 0; //水印文字放置位置
	var $wm_text_font = ""; //水印文字的字体
	var $wm_text_color = "#cccccc"; //水印字体的颜色值
	

	function create($filename = "") {
		if ($filename)
			$this->src_image_name = strtolower ( trim ( $filename ) );
		
		$src_image_type = $this->get_type ( $this->src_image_name );
		$src_image = $this->createImage ( $src_image_type, $this->src_image_name );
		if (! $src_image)
			return;
		$src_image_w = ImageSX ( $src_image );
		$src_image_h = ImageSY ( $src_image );
		
		if ($this->wm_image_name) {
			$this->wm_image_name = strtolower ( trim ( $this->wm_image_name ) );
			$wm_image_type = $this->get_type ( $this->wm_image_name );
			$wm_image = $this->createImage ( $wm_image_type, $this->wm_image_name );
			$wm_image_w = ImageSX ( $wm_image );
			$wm_image_h = ImageSY ( $wm_image );
			$temp_wm_image = $this->getPos ( $src_image_w, $src_image_h, $this->wm_image_pos, $wm_image );
			$wm_image_x = $temp_wm_image ["dest_x"];
			$wm_image_y = $temp_wm_image ["dest_y"];
			imagecopy ( $src_image, $wm_image, $wm_image_x, $wm_image_y, 0, 0, $wm_image_w, $wm_image_h );
		}
		
		if ($this->wm_text) {
			$this->wm_text = $this->gb2utf8 ( $this->wm_text );
			$temp_wm_text = $this->getPos ( $src_image_w, $src_image_h, $this->wm_text_pos );
			$wm_text_x = $temp_wm_text ["dest_x"];
			$wm_text_y = $temp_wm_text ["dest_y"];
			if (preg_match ( "/([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])/i", $this->wm_text_color, $color )) {
				$red = hexdec ( $color [1] );
				$green = hexdec ( $color [2] );
				$blue = hexdec ( $color [3] );
				$wm_text_color = imagecolorallocate ( $src_image, $red, $green, $blue );
			} else {
				$wm_text_color = imagecolorallocate ( $src_image, 255, 255, 255 );
			}
			
			imagettftext ( $src_image, $this->wm_text_size, $this->wm_text_angle, $wm_text_x, $wm_text_y, $wm_text_color, $this->wm_text_font, $this->wm_text );
		}
		
		if ($this->save_image_file) {
			switch ($src_image_type) {
				case 'gif' :
					$src_img = ImagePNG ( $src_image, $this->save_image_file );
					break;
				case 'jpeg' :
					$src_img = ImageJPEG ( $src_image, $this->save_image_file, $this->jpeg_quality );
					break;
				case 'png' :
					$src_img = ImagePNG ( $src_image, $this->save_image_file );
					break;
				default :
					$src_img = ImageJPEG ( $src_image, $this->save_image_file, $this->jpeg_quality );
					break;
			}
		} else {
			if ($src_image_type = "jpg")
				$src_image_type = "jpeg";
			header ( "Content-type: image/{$src_image_type}" );
			switch ($src_image_type) {
				case 'gif' :
					$src_img = ImagePNG ( $src_image );
					break;
				case 'jpg' :
					$src_img = ImageJPEG ( $src_image, "", $this->jpeg_quality );
					break;
				case 'png' :
					$src_img = ImagePNG ( $src_image );
					break;
				default :
					$src_img = ImageJPEG ( $src_image, "", $this->jpeg_quality );
					break;
			}
		}
		imagedestroy ( $src_image );
	}
	
	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
/*
createImage     根据文件名和类型创建图片
内部函数

$type:                图片的类型，包括gif,jpg,png
$img_name:  图片文件名，包括路径名，例如 " ./mouse.jpg"
*/
	function createImage($type, $img_name) {
		if (! $type) {
			$type = $this->get_type ( $img_name );
		}
		
		switch ($type) {
			case 'gif' :
				if (function_exists ( 'imagecreatefromgif' ))
					$tmp_img = @ImageCreateFromGIF ( $img_name );
				break;
			case 'jpg' :
				$tmp_img = ImageCreateFromJPEG ( $img_name );
				break;
			case 'png' :
				$tmp_img = ImageCreateFromPNG ( $img_name );
				break;
			default :
				
				$tmp_img = ImageCreateFromString ( $img_name );
				break;
		}
		return $tmp_img;
	}
	
	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
getPos               根据源图像的长、宽，位置代码，水印图片id来生成把水印放置到源图像中的位置
内部函数

$sourcefile_width:        源图像的宽
$sourcefile_height: 原图像的高
$pos:               位置代码
// 0 = middle
// 1 = top left
// 2 = top right
// 3 = bottom right
// 4 = bottom left
// 5 = top middle
// 6 = middle right
// 7 = bottom middle
// 8 = middle left
$wm_image:           水印图片ID
*/
	function getPos($sourcefile_width, $sourcefile_height, $pos, $wm_image = "") {
		if ($wm_image) {
			$insertfile_width = ImageSx ( $wm_image );
			$insertfile_height = ImageSy ( $wm_image );
		} else {
			$lineCount = explode ( "\r\n", $this->wm_text );
			$fontSize = imagettfbbox ( $this->wm_text_size, $this->wm_text_angle, $this->wm_text_font, $this->wm_text );
			$insertfile_width = $fontSize [2] - $fontSize [0];
			$insertfile_height = count ( $lineCount ) * ($fontSize [1] - $fontSize [3]);
		}
		
		switch ($pos) {
			case 0 :
				$dest_x = ($sourcefile_width / 2) - ($insertfile_width / 2);
				$dest_y = ($sourcefile_height / 2) - ($insertfile_height / 2);
				break;
			
			case 1 :
				$dest_x = 0;
				if ($this->wm_text) {
					$dest_y = $insertfile_height;
				} else {
					$dest_y = 0;
				}
				break;
			
			case 2 :
				$dest_x = $sourcefile_width - $insertfile_width;
				if ($this->wm_text) {
					$dest_y = $insertfile_height;
				} else {
					$dest_y = 0;
				}
				break;
			
			case 3 :
				$dest_x = $sourcefile_width - $insertfile_width;
				$dest_y = $sourcefile_height - $insertfile_height;
				break;
			
			case 4 :
				$dest_x = 0;
				$dest_y = $sourcefile_height - $insertfile_height;
				break;
			
			case 5 :
				$dest_x = (($sourcefile_width - $insertfile_width) / 2);
				if ($this->wm_text) {
					$dest_y = $insertfile_height;
				} else {
					$dest_y = 0;
				}
				break;
			
			case 6 :
				$dest_x = $sourcefile_width - $insertfile_width;
				$dest_y = ($sourcefile_height / 2) - ($insertfile_height / 2);
				break;
			
			case 7 :
				$dest_x = (($sourcefile_width - $insertfile_width) / 2);
				$dest_y = $sourcefile_height - $insertfile_height;
				break;
			
			case 8 :
				$dest_x = 0;
				$dest_y = ($sourcefile_height / 2) - ($insertfile_height / 2);
				break;
			
			default :
				$dest_x = $sourcefile_width - $insertfile_width;
				$dest_y = $sourcefile_height - $insertfile_height;
				break;
		}
		return array ("dest_x" => $dest_x, "dest_y" => $dest_y );
	}
	
	/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
gb2utf8                指定的文字转换为UTF-8格式，包括中英文混合
内部函数
*/
	function gb2utf8($str) {
		//iconv('GB2312','UTF-8','中文水印');
		$in_charset = "GB2312";
		$out_charset = "UTF-8";
		if ($in_charset != $out_charset) {
			if (function_exists ( 'iconv' ) && (@$outstr = iconv ( "$in_charset//IGNORE", "$out_charset//IGNORE", $str ))) {
				return $outstr;
			} elseif (function_exists ( 'mb_convert_encoding' ) && (@$outstr = mb_convert_encoding ( $str, $out_charset, $in_charset ))) {
				return $outstr;
			}
		}
		return $str; //转换失败
	}
	
	function u2utf8($c) {
		$str = "";
		if ($c < 0x80) {
			$str .= $c;
		} else if ($c < 0x800) {
			$str .= chr ( 0xC0 | $c >> 6 );
			$str .= chr ( 0x80 | $c & 0x3F );
		} else if ($c < 0x10000) {
			$str .= chr ( 0xE0 | $c >> 12 );
			$str .= chr ( 0x80 | $c >> 6 & 0x3F );
			$str .= chr ( 0x80 | $c & 0x3F );
		} else if ($c < 0x200000) {
			$str .= chr ( 0xF0 | $c >> 18 );
			$str .= chr ( 0x80 | $c >> 12 & 0x3F );
			$str .= chr ( 0x80 | $c >> 6 & 0x3F );
			$str .= chr ( 0x80 | $c & 0x3F );
		}
		return $str;
	}
	
	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
get_type                获得图片的格式，包括jpg,png,gif
内部函数

$img_name：        图片文件名，可以包括路径名
*/
	function get_type($img_name) {
		$name_array = explode ( ".", $img_name );
		if (preg_match ( "/\.(jpg|jpeg|gif|png)$/", $img_name, $matches )) {
			$type = strtolower ( $matches [1] );
		} else {
			$type = "string";
		}
		return $type;
	}
	
	function thumb() {
		$percent = 0.5;
		// Content type
		//header ( 'Content-type: image/jpeg' );
		// Get new dimensions
		list ( $width, $height ) = getimagesize ( $this->src_image_name );
		$new_width = $width * $percent;
		$new_height = $height * $percent;
		//以原图片的长宽的0.5为新的长宽来创建新的图片此图片的标志为$image_p
		$image_p = imagecreatetruecolor ( $new_width, $new_height );
		$src_image_type = $this->get_type($this->src_image_name);
		$src_image = $this->createImage ( $src_image_type, $this->src_image_name );
		
		//将原始图片从坐标(100,100)开始分割,分割的长度(400),高度为(300)原图片的一半,将分割好的图片放在从坐标(0,0)开始的已建好的区域里
		imagecopyresampled ( $image_p, $src_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		switch ($src_image_type) {
			case 'gif' :
				$src_img = ImagePNG ( $image_p, $this->save_image_file );
				break;
			case 'jpeg' :
				$src_img = ImageJPEG ( $image_p, $this->save_image_file, $this->jpeg_quality );
				break;
			case 'png' :
				$src_img = ImagePNG ( $image_p, $this->save_image_file );
				break;
			default :
				$src_img = ImageJPEG ( $image_p, $this->save_image_file, $this->jpeg_quality );
				break;
		}
		imagedestroy ( $image_p );
		imagedestroy ( $src_image );
	}

}

?>