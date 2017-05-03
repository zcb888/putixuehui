<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class CI_Uploadfile {
	
	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	// 存储文件
	function SaveFile($fileControlName, $dir, $fileTypeArray = null, $isroot = 0) {
		$save_path = '';
		if (isset($_FILES [$fileControlName]['name'] )&&$_FILES [$fileControlName]['name']!='') {
			$file_path = $_FILES [$fileControlName] ['name'];
			$path_array = explode ( '.', $file_path );
			$fileType = count ( $path_array ) > 1 ? $path_array [count ( $path_array ) - 1] : '';
			if ($fileTypeArray) {
				$is_validate = false;
				foreach ( $fileTypeArray as $item ) {
					if (strtolower ( $fileType ) == $item) {
						$is_validate = true;
						break;
					}
				}
				if (! $is_validate)
					return null;
			}
			$fileName = date ( 'YmdHis' ) . rand ( 1000, 9999 ) . '.' . $fileType;
			$saveDir = $dir . '/' . $fileName;
			$this->createDir ( $dir );
			if (is_uploaded_file ( $_FILES [$fileControlName] ['tmp_name'] )) {
				if (move_uploaded_file ( $_FILES [$fileControlName] ['tmp_name'], $saveDir )) {
					// 成功流程
				} else {
					// 报错流程
					echo 'save error';
					exit ();
				}
			}
			$isroottxt = '/';
			if ($isroot != 0) {
				$isroottxt = '';
			}
			$save_path = $isroottxt . $saveDir;
		}
		return $save_path;
	}
	
	//生成缩略图
	function create_thumb_img($source_image,$width,$height){
		$document_root =  $_SERVER ['DOCUMENT_ROOT'];
		$source_image = $document_root. $source_image;
		$config['image_library'] = 'gd2';
		$config['source_image'] = $source_image;
		//$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;
		$new_image = str_replace('.', '_'.$width.'_'.$height.'.', $source_image);
		$config['new_image'] = $new_image ;
		$this->CI->load->library('image_lib', $config);
		if ( ! $this->CI->image_lib->resize())
		{
			echo $this->CI->image_lib->display_errors();
		}
	}
	
	// 存储文件
	function saveFileByNameAndPath($name, $path) {
		$fileType = $this->getFileType ( $_FILES [$name] ['name'] );
		$dir = $path . date ( 'Ym' );
		$fileName = date ( 'YmdHis' ) . '.' . $fileType;
		$saveDir = $dir . '/' . $fileName;
		$this->createDir ( $dir );
		$dirName = $dir . '/' . $fileName;
		if (is_uploaded_file ( $_FILES [$name] ['tmp_name'] )) {
			if (move_uploaded_file ( $_FILES [$name] ['tmp_name'], $saveDir )) {
				// 成功流程
			} else {
				// 报错流程
				echo 'save error';
				exit ();
			}
		}
		return $dirName;
	}
	
	// 获得图片的格式，包括jpg,png,gif
	function getFileType($name) 	// 获取图像文件类型
	{
		if (preg_match ( "/.(jpg|jpeg|gif|png|bmp|xls|csv|txt|apk|xlsx|mp4|mp3)$/i", $name, $matches )) {
			$type = strtolower ( $matches [1] );
		} else {
			$type = "string";
		}
		return $type;
	}
	
	/*
	 * 功能：循环检测并创建文件夹 参数：$path 文件夹路径 返回：
	 */
	function createDir($path) {
		if (! file_exists ( $path )) {
			$this->createDir ( dirname ( $path ) );
			mkdir ( $path, 0777 );
		}
	}
}
?>