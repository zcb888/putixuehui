<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Location
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }
    /**
     * 根据当前用的ip地址判断用户所在地，返回的结果为省份或者直辖市信息
     * @return string
     */
    public function get()
    {
        $loc_name = $this->getLocation();
        if ($loc_name) {
            $this->CI->db->select('region_id id');
            $this->CI->db->where('region_type', 1);
            $this->CI->db->where('region_name', $loc_name);
            $region = $this->CI->db->get('region')->first_row();
            if ($region) return $region->id;
            else return 1;
        } else {
            return 1; // 中国？
        }
    }
	public function getLo(){
		return $this->getLocation();
	}
    /**
     * 获取用户的ip地址，暂时忽略掉类似'58.240.190.146, 58.240.190.146'的情况
     * @return string ip地址
     */
    public function getIp()
    {
        $onlineip = '';
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } //elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            //$onlineip = getenv('HTTP_X_FORWARDED_FOR');
        //}
        elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $onlineip = getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }
        return $onlineip;
    }

	public function getMobileIP()
	{
	    $ip=getenv('REMOTE_ADDR');
	    $ip_ = getenv('HTTP_X_FORWARDED_FOR');
	    if (($ip_ != "") && ($ip_ != "unknown"))
	    {
	        $ip=$ip_;
	    }
	    return $ip;
	}
    
    private function getLocation()
    {
        $ip = $this->getIp();
//        $ip = '58.240.190.146';
        $ch = curl_init(base_url() . 'ip/get.php?ip=' . $ip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        $info = json_decode($json);
        return $info[0];
        // 考虑使用本地和淘宝相结合的方式进行综合查询
        /*
        $ch = curl_init('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        $info = json_decode($json);
        if (!is_null($info)) {
            if ($info->code == 1) {
                return false;
            } else {
                return mb_substr($info->data->region, 0, -1, 'utf-8');
            }
        } else {
            return false;
        }
        */
    }
}