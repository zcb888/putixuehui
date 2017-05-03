<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index extends CI_Controller {
	public function __construct() {
		parent::__construct ();
	}
	
	/*
	 * 首页列表
	 */
	public function index() {
		echo 'welcome to suzhou ';
	}
	
	public function test(){
		//echo $this->router->method;
		echo strtotime(1264170665);
		//echo $this->view_path.'/add';
	}
	
	
	public function dealtxt() {
		echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
		$result = file_get_contents('txt/1.txt'); //$this->onefile ( 'txt/1.txt', 3 );
		
		$this->chapter('txt/1.txt', 1, $result,'2222');
	}
	
	public function chapter($filename, $book_id, $content, $title = '') {
		$book_array = $this->onefile ( $filename );
		$book_str = '';
		if ($book_array) {
			foreach ( $book_array as $item ) {
				$book_str .= '、' . $item;
			}
		}
		$date = date ( 'Y-m-d H:i:s' );
		$chapter_data = array (
				'title' => $title,
				'book_id' => $book_id,
				'content' => $content,
				'type' => 1,
				'book_str' => $book_str,
				'add_time' => $date 
		);
		$this->db->insert ( 'chapter', $chapter_data );
		$chapter_id = $this->db->insert_id();
		if ($chapter_id) {
			$jiaozheng_array = $this->onefile ( $filename, 3 );
			if ($jiaozheng_array) {
				foreach ( $jiaozheng_array as $item ) {
					$book_name = substr ( $item, 0, strpos ( $item, '》' ) );
					$book_name = str_ireplace ( '《', '', $book_name );
					$content = trim ( $item );
					
					$jinglun_id = 0;
					$jinglun_model = $this->db->select ( 'id' )->where ( 'name', $book_name )->or_where ( 'alias', $book_name )->get ( 'jinglun' )->first_row ();
					if ($jinglun_model) {
						$jinglun_id = $jinglun_model->id;
					} else {
						$jinglun_data = array (
								'name' => $book_name,
								'add_time' => $date 
						);
						$this->db->insert ( 'jinglun', $jinglun_data );
						$jinglun_id = $this->db->insert_id();
					}
					$jiaozheng_data = array (
							'book_id' => $book_id,
							'chapter_id' => $chapter_id,
							'jinglun_id' => $jinglun_id,
							'jinglun' => $book_name,
							'content' => $content,
							'type' => 2,
							'add_time' => $date 
					);
					$this->db->insert('jiaozheng',$jiaozheng_data);
				}
			}
		}
	}
	
	/**
	 * 方法描述 type=1、书名称 2、文字
	 * @date 2016-12-22
	 *
	 * @author Gavin
	 */
	function onefile($filename, $type = 1) {
		$book_array = array ();
		$content = file_get_contents ( $filename );
		$result = array ();
		switch ($type) {
			case 1 :
				preg_match_all ( '/《.*?》/', $content, $result );
				break;
			case 2 :
				preg_match_all ( '/“.*?”/', $content, $result );
				break;
			case 3 :
				preg_match_all ( '/《.*?》.*?”/', $content, $result );
				break;
			default :
				preg_match_all ( '/《.*?》/', $content, $result );
				break;
		}
		// preg_match_all('/《.*?》/', $content, $result);
		if (! empty ( $result )) {
			$book_array = array_unique ( $result [0] );
		}
		return $book_array;
	}
}