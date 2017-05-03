<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * date:2014-09-09
 * desc:验证码处理
 * author:Gavin.zhang
 */
class Captcha extends CI_Controller {
    function __construct()
    {
        parent::__construct();
    }
    //推荐
    public function index(){
        $this->load->library('captcha');
        $width = isset($_GET['width']) ? $_GET['width'] : '60';
        $height = isset($_GET['height']) ? $_GET['height'] : '26';
        $characters = isset($_GET['characters']) ? $_GET['characters'] : '4';
        header('Content-Type: image/jpeg');
        $this->captcha->CaptchaSecurityImages($width,$height,$characters);
    }
}
