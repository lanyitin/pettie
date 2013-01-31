<?php
function redirect($para_url)
{
	if(Debug){
		//file_put_contents(ROOT.DS."log/redirect_log", $para_url."\n", FILE_APPEND);
	}
	if(is_string($para_url)){
		header("location:".url_for($para_url));
		exit;//http://blog.longwin.com.tw/2006/05/php_header_location_2006/
	}
}

function url_for($para_url)
{
	return sprintf("%s%s", PETTIE_URL, $para_url);
}

function generateRandomString($length = 10, $letters = '1234567890qwertyuiopasdfghjklzxcvbnm') 
{ 
	$s = ''; 
	$lettersLength = strlen($letters)-1; 

	for($i = 0 ; $i < $length ; $i++) 
	{ 
		$s .= $letters[rand(0,$lettersLength)]; 
	} 

	return $s; 
} 

function ccStrLen($str) #計算中英文混合字元串的長度 
{ 
	$ccLen=0; 
	$ascLen=strlen($str); 
	$ind=0; 
	$hasCC=preg_match('/[xA1-xFE]/',$str); #判斷是否有中文字 
	$hasAsc=preg_match('/[x01-xA0]/',$str); #判斷是否有ASCII字元
	if($hasCC && !$hasAsc) #只有中文字的情況 
		return strlen($str)/2; 
	if(!$hasCC && $hasAsc) #只有Ascii字元的情況 
		return strlen($str); 
	for($ind=0;$ind<$ascLen;$ind++) 
	{ 
		if(ord(substr($str,$ind,1))>0xa0) 
		{ 
			$ccLen++; 
			$ind++; 
		} 
		else 
		{ 
			$ccLen++; 
		} 
	} 
	return $ccLen; 
} 

const IS_SET = 1;
const NOT_NULL = 2;
const NOT_EMPTY_STRING = 4;

function arrayVarCheck($para_index, $para_array, $mask){//0b1111=27
	$result = isset($para_array[$para_index]);
	if(!$result){
		return $result;
	}
	if($mask&NOT_NULL){
		$result &= ($para_array[$para_index] !== null);
	}
	if($mask&NOT_EMPTY_STRING){
		$result &= ($para_array[$para_index] !== "");
	}
	return $result;
}
?>
