<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funs extends CI_Controller {
	public function index()
	{
		echo "200";
	}

	public function getJumpUrl($urlBase64, $postdata)
	{
		$urlBase64 = str_replace(".","=",$urlBase64);
		$urlBase64 = str_replace("#","+",$urlBase64);
		$urlBase64 = str_replace("_","-",$urlBase64);


		$url = base64_decode($urlBase64);
		$data = base64_decode($postdata);

		//print_r($url);g2q4c3
		// 初始化curl
		$ch = curl_init ();
		// 设置URL参数 
		curl_setopt( $ch, CURLOPT_URL, $url );
		// 设置cURL允许执行的最长秒数
		curl_setopt( $ch, CURLOPT_TIMEOUT, 60);
		// 要求CURL返回数据
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);    
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);

		// 执行请求
		$result = curl_exec($ch);
		// 获取http状态
		$http_code = curl_getinfo ($ch, CURLINFO_HTTP_CODE );
		curl_close ( $ch );
		print_r($result);
		//print_r($http_code);
	}
}

?>