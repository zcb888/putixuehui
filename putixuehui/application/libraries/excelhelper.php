<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class CI_Excelhelper {
	function __construct() {
		$this->CI = & get_instance ();
	}
	
	
	/* 导出excel函数 */
	public function push($data, $name = 'Excel', $admin = '') {
		error_reporting ( E_ALL );
		
		// 引入PHPExcel相关文件
		require_once "PHPExcel.php";
		require_once 'IOFactory.php';
		require_once 'PHPExcel/Writer/Excel5.php';
		
		// 新建
		$resultPHPExcel = new PHPExcel ();
		/* 以下是一些设置 ，什么作者 标题啊之类的 */
		$resultPHPExcel->getProperties ()->setCreator ( $admin )->setLastModifiedBy ( $admin )->setTitle ( "学员修量统计" )->setSubject ( "学员修量统计" )->setDescription ( "学员修量统计" )->setKeywords ( "excel" )->setCategory ( "result file" );
		
		// 设置参数
		// 设值
		$resultPHPExcel->getActiveSheet ()->setCellValue ( 'A1', '序号' );
		$resultPHPExcel->getActiveSheet ()->setCellValue ( 'B1', '姓名' );
		$resultPHPExcel->getActiveSheet ()->setCellValue ( 'C1', '累计磕头总数' );
		$resultPHPExcel->getActiveSheet ()->setCellValue ( 'D1', '手机号码' );
		$resultPHPExcel->getActiveSheet ()->setCellValue ( 'E1', '邮箱' );
		
		$resultPHPExcel->getActiveSheet ()->getColumnDimension ( 'A' )->setWidth ( 5 );
		$resultPHPExcel->getActiveSheet ()->getColumnDimension ( 'C' )->setWidth ( 12 );
		$resultPHPExcel->getActiveSheet ()->getColumnDimension ( 'D' )->setWidth ( 12 );
		$resultPHPExcel->getActiveSheet ()->getColumnDimension ( 'E' )->setWidth ( 25 );
		
		$i = 2;
		if ($data && count ( $data ) > 0) {
			foreach ( $data as $item ) {
				
				$resultPHPExcel->getActiveSheet ()->setCellValue ( 'A' . $i, $item ['id'] );
				$resultPHPExcel->getActiveSheet ()->setCellValue ( 'B' . $i, $item ['name'] );
				$resultPHPExcel->getActiveSheet ()->setCellValue ( 'C' . $i, $item ['total_head'] );
				$resultPHPExcel->getActiveSheet ()->setCellValue ( 'D' . $i, $item ['phone'] );
				$resultPHPExcel->getActiveSheet ()->setCellValue ( 'E' . $i, $item ['email'] );

				$i ++;
			}
		}
		// 设置导出文件名
		$outputFileName = $name . '.xls';
		$xlsWriter = new PHPExcel_Writer_Excel5 ( $resultPHPExcel );
		// ob_start(); ob_flush();
		header ( "Content-Type: application/force-download" );
		header ( "Content-Type: application/octet-stream" );
		header ( "Content-Type: application/download" );
		header ( 'Content-Disposition:inline;filename="' . $outputFileName . '"' );
		header ( "Content-Transfer-Encoding: binary" );
		header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header ( "Last-Modified: " . gmdate ( "D, d M Y H:i:s" ) . " GMT" );
		header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
		header ( "Pragma: no-cache" );
		$xlsWriter->save ( "php://output" );
		exit ();
	}
	
	
	/* 导出excel函数 */
	public function toppush($data, $name = 'Excel', $admin = '') {
		error_reporting ( E_ALL );
	
		// 引入PHPExcel相关文件
		require_once "PHPExcel.php";
		require_once 'IOFactory.php';
		require_once 'PHPExcel/Writer/Excel5.php';
	
		// 新建
		$resultPHPExcel = new PHPExcel ();
		/* 以下是一些设置 ，什么作者 标题啊之类的 */
		$resultPHPExcel->getProperties ()->setCreator ( $admin )->setLastModifiedBy ( $admin )->setTitle ( "学员修量统计" )->setSubject ( "学员修量统计" )->setDescription ( "学员修量统计" )->setKeywords ( "excel" )->setCategory ( "result file" );
	
		// 设置参数
		// 设值
		$resultPHPExcel->getActiveSheet ()->setCellValue ( 'A1', '名次' );
		$resultPHPExcel->getActiveSheet ()->setCellValue ( 'B1', '姓名' );
		$resultPHPExcel->getActiveSheet ()->setCellValue ( 'C1', '磕头总数' );
		$resultPHPExcel->getActiveSheet ()->setCellValue ( 'D1', '整体进度' );
	
		$resultPHPExcel->getActiveSheet ()->getColumnDimension ( 'A' )->setWidth ( 5 );
		$resultPHPExcel->getActiveSheet ()->getColumnDimension ( 'C' )->setWidth ( 12 );
		$resultPHPExcel->getActiveSheet ()->getColumnDimension ( 'D' )->setWidth ( 12 );
	
		$i = 2;
		if ($data && count ( $data ) > 0) {
			foreach ( $data as $item ) {
				$progress = $item["total_head"]/1000;
				$resultPHPExcel->getActiveSheet ()->setCellValue ( 'A' . $i, ($i-1) );
				$resultPHPExcel->getActiveSheet ()->setCellValue ( 'B' . $i, $item ['name'] );
				$resultPHPExcel->getActiveSheet ()->setCellValue ( 'C' . $i, $item ['total_head'] );
				$resultPHPExcel->getActiveSheet ()->setCellValue ( 'D' . $i, round($progress ,2).'%' );
	
				$i ++;
			}
		}
		// 设置导出文件名
		$outputFileName = $name . '.xls';
		$xlsWriter = new PHPExcel_Writer_Excel5 ( $resultPHPExcel );
		// ob_start(); ob_flush();
		header ( "Content-Type: application/force-download" );
		header ( "Content-Type: application/octet-stream" );
		header ( "Content-Type: application/download" );
		header ( 'Content-Disposition:inline;filename="' . $outputFileName . '"' );
		header ( "Content-Transfer-Encoding: binary" );
		header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header ( "Last-Modified: " . gmdate ( "D, d M Y H:i:s" ) . " GMT" );
		header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
		header ( "Pragma: no-cache" );
		$xlsWriter->save ( "php://output" );
		exit ();
	}
	/**
	 * 读取excel数据返回数据
	 * @date 2016-10-6
	 * @author Gavin
	 */
	public function getArrayByExcel($filePath, $encode = 'utf-8', $sheet = 0) {
		include 'PHPExcel.php';
		if (empty ( $filePath ) or ! file_exists ( $filePath )) {
			die ( 'file not exists' );
		}
		$PHPReader = new PHPExcel_Reader_Excel2007 (); // 建立reader对象
		if (! $PHPReader->canRead ( $filePath )) {
			$PHPReader = new PHPExcel_Reader_Excel5 ();
			if (! $PHPReader->canRead ( $filePath )) {
				echo 'no Excel';
				return;
			}
		}
		$objPHPExcel = $PHPReader->load ( $filePath ); // 建立excel对象
		$objWorksheet = $objPHPExcel->getSheet ( $sheet ); // **读取excel文件中的指定工作表*/
		$highestColumn = $objWorksheet->getHighestColumn (); // **取得最大的列号*/
		$highestRow = $objWorksheet->getHighestRow (); // **取得一共有多少行*/
	
		//$highestColumnIndex = PHPExcel_Cell::columnIndexFromString ( $highestColumn );
		$excelData = array ();
		$key_array = $this->getExcelHeadLetter ();
		for($row = 2; $row <= $highestRow-1; $row ++) {
			for($col = 0; $col < 16; $col ++) {
				$excelData [$row] [$key_array [$col]] = ( string ) $objWorksheet->getCellByColumnAndRow ( $col, $row )->getCalculatedValue ();
				// $excelData [$row] [] = ( string ) $objWorksheet->getCellByColumnAndRow ( $col, $row )->getValue ();
			}
		}
		return $excelData;
	}
	
	// 存储文件
	function saveFileByNameAndPath($name, $dir) {
		$fileType = $this->getFileType ( $name );
		// $dir = $path.date('Ym');
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
		$file_path = $_FILES [$name] ['name'];
		$path_array = explode ( '.', $file_path );
		$file_type = count ( $path_array ) > 1 ? $path_array [count ( $path_array ) - 1] : '';
		return $file_type;
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
	
	/*
	 * 获取excel头部
	 */
	public function getExcelHeadLetter() {
		$excle_no = array (
				'A',
				'B',
				'C',
				'D',
				'E',
				'F',
				'G',
				'H',
				'I',
				'J',
				'K',
				'L',
				'M',
				'N',
				'O',
				'P',
				'Q',
				'R',
				'S',
				'T',
				'U',
				'V',
				'W',
				'X',
				'Y',
				'Z',
				'AA',
				'AB',
				'AC',
				'AD',
				'AE',
				'AF',
				'AG',
				'AH',
				'AI',
				'AJ',
				'AK',
				'AL',
				'AM',
				'AN',
				'AO',
				'AP',
				'AQ',
				'AR',
				'AS',
				'AT',
				'AU',
				'AV',
				'AW',
				'AX',
				'AY',
				'AZ',
				'BA',
				'BB',
				'BC',
				'BD',
				'BE',
				'BF',
				'BG',
				'BH',
				'BI',
				'BJ',
				'BK',
				'BL',
				'BM',
				'BN',
				'BO',
				'BP',
				'BQ',
				'BR',
				'BS',
				'BT',
				'BU',
				'BV',
				'BW',
				'BX',
				'BY',
				'BZ',
				'CA',
				'CB',
				'CC',
				'CD',
				'CE',
				'CF',
				'CG',
				'CH',
				'CI',
				'CJ',
				'CK',
				'CL',
				'CM',
				'CN',
				'CO',
				'CP',
				'CQ',
				'CR',
				'CS',
				'CT',
				'CU',
				'CV',
				'CW',
				'CX',
				'CY',
				'CZ',
				'DA',
				'DB',
				'DC',
				'DD',
				'DE',
				'DF',
				'DG',
				'DH',
				'DI',
				'DJ',
				'DK',
				'DL',
				'DM',
				'DN',
				'DO',
				'DP',
				'DQ',
				'DR',
				'DS',
				'DT',
				'DU',
				'DV',
				'DW',
				'DX',
				'DY',
				'DZ',
				'EA',
				'EB',
				'EC',
				'Ed',
				'EE',
				'EF',
				'EG',
				'EH',
				'EI',
				'EJ',
				'EK',
				'EL',
				'EM',
				'EN',
				'EO',
				'EP',
				'EQ',
				'ER',
				'ES',
				'ET',
				'EU',
				'EV',
				'EW',
				'EX',
				'EY',
				'EZ',
				'FA',
				'FB',
				'FC',
				'Fd',
				'EF',
				'FF',
				'FG',
				'FH',
				'FI',
				'FJ',
				'FK',
				'FL',
				'FM',
				'FN',
				'FO',
				'FP',
				'FQ',
				'FR',
				'FS',
				'FT',
				'FU',
				'FV',
				'FW',
				'FX',
				'FY',
				'FZ' 
		);
		return $excle_no;
	}
}

?>
