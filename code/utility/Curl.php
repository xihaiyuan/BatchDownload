<?php

class Curl
{
	public  $cookie = "";

	function __construct($cookie)
	{
		$this->cookie = $cookie;
	}

	//curl
	function call($url, $type, $data, $reheader = 0)
	{
		//$url =  str_replace("http","https",$url);
		$cookie = $this->cookie;
		$ch = curl_init();
		$header = array();
		curl_setopt($ch, CURLOPT_URL, $url);
		if ($type == "post") {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, $reheader);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		$content = curl_exec($ch);
		return $content;
	}
}
