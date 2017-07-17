<?php
date_default_timezone_set("Asia/Shanghai");
class Get_info_model extends CI_Model {

    static private $store_info ='http://oa.faxianbook.com:9001/index.php/funs/getJumpUrl/aHR0cDovLzE5Mi4xNjguMTAuMTIwOjgwODAvYXBwQVBJL3N0b3JlLw../Y29udHJvPWZpbmRTdG9yZSZpbmRleD0xJmFyZWFJZD0wJmJyYW5kSWQ9MA..';

	public function get_url($TOKEN_URL){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $TOKEN_URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);   
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$json = curl_exec($ch);  
		curl_close($ch); 
		return $json;
	}

    public function select_info($type)
	{
		echo 3434;exit;
		switch ($type) {
			case 'storeinfo':
					$url =self::$store_info;
			break;
			
			default:
				# code...
			break;
		}

		$data = self::get_url($url);
		return $data;
	}

}

?>