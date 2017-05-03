<?php
class tool extends CI_Model {

    function __construct(){
        parent::__construct();
    }
    //根据包id获取包功能列表
	function getFunctionListByPackageId($package_id){
		$sql='SELECT function_key,function_name,function_values FROM yueui_package_function WHERE build_package_id='.$package_id;
		$query=$this->db->query($sql);
		$result = $this->$query->result_array();
		return $result;
	}
	
	/* 
	* 功能：循环检测并创建文件夹 
	* 参数：$path 文件夹路径 
	* 返回： 
	*/ 
	function createDir($path){
		if (!file_exists($path)){ 
			$this->createDir(dirname($path)); 
			mkdir($path, 0777);
		}
	}
	
	//存储文件
	function saveFileByNameAndPath($name,$path){
		$fileType = $this->getFileType($_FILES[$name]['name']);
		$dir =  $path.date('Ym');
		$fileName = date('YmdHis').'.'.$fileType;
		$saveDir = $dir.'/'.$fileName;
		$this->createDir($dir);
		$dirName = $dir.'/'.$fileName;
		if(is_uploaded_file($_FILES[$name]['tmp_name'])){  
			if(move_uploaded_file($_FILES[$name]['tmp_name'],$saveDir)){
			  //成功流程
			} else {
			  //报错流程
				echo 'save error';
				exit;
			}
		}
		return $dirName;
	}
	
	//获得图片的格式，包括jpg,png,gif
	function getFileType($name)//获取图像文件类型
	{
		if (preg_match("/.(jpg|jpeg|gif|png|bmp|xls|csv|txt|apk|xlsx|mp4|mp3)$/i", $name, $matches)){
			$type = strtolower($matches[1]);
		}else{
			$type = "png";
		}
		return $type;
	}
    
	//读取excel
	function getArrayByExcel($file){
		$dirName = $this->saveFileByNameAndPath($file,'upload/employee/excel/');
		$this->load->library('iofactory');
		$excel = $this->iofactory->load($dirName); // 文件名称
		$sheet = $excel->getSheet(0); // 读取第一个工作表从0读起
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		$highestColumn = $sheet->getHighestColumn(); // 取得总列数
		/** 循环读取每个单元格的数据 */
		for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
			$list[$row-2]= array();
			for ($column = 'A'; $column <= $highestColumn; $column++) {//列数是以A列开始
				$list[$row-2][0] = $sheet->getCell('A'.$row)->getValue();
				$list[$row-2][1] = $sheet->getCell('B'.$row)->getValue();
				$list[$row-2][2] = $sheet->getCell('C'.$row)->getValue();
				$list[$row-2][3] = $sheet->getCell('D'.$row)->getValue();
				$list[$row-2][4] = $sheet->getCell('E'.$row)->getValue();
				$list[$row-2][5] = $sheet->getCell('F'.$row)->getValue();
				$list[$row-2][6] = $sheet->getCell('G'.$row)->getValue();
			}
		}
		return $list;
	}
	
	//读取excel
	function getUserListByExcel($file){
		$dirName = $this->saveFileByNameAndPath($file,'upload/media/');
		$this->load->library('iofactory');
		$excel = $this->iofactory->load($dirName); // 文件名称
		$sheet = $excel->getSheet(0); // 读取第一个工作表从0读起
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		$highestColumn = $sheet->getHighestColumn(); // 取得总列数
		/** 循环读取每个单元格的数据 */
		for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
			$list[$row-2]= array();
			for ($column = 'A'; $column <= $highestColumn; $column++) {//列数是以A列开始
				$list[$row-2][0] = $sheet->getCell('A'.$row)->getValue();
				$list[$row-2][1] = $sheet->getCell('B'.$row)->getValue();
				$list[$row-2][2] = $sheet->getCell('C'.$row)->getValue();
			}
		}
		return $list;
	}
	
	function getMenuData(){
		$this->load->model('table/nyPermissionGroup');
		return $this->nyPermissionGroup->menuData();
	}
}