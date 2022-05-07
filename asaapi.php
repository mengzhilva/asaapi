<?php

/**
 * Created by haoxin
 * Date: 2021/8/14
 */
namespace mylib;

class asaapi {
   	private $orgid = '';
    private $client_id = '';
   	private $team_id = '';
    private $key_id = '';
    private $route = '';
    private $iphonekeypath = '/home/wwwroot/asa/iphonekey.py';

    public function __construct()
    {
    }
    /*
     * 使用方法
		$asaapi = new asaapi();
		$url = 'https://api.searchads.apple.com/api/v4/campaigns';
		$cam = $asaapi->_geturl($url);
     * 
     * */

    public function _geturl($url){
    	$UserAgent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; .NET CLR 3.5.21022; .NET CLR 1.0.3705; .NET CLR 1.1.4322)";
    
    	$access_token=$this->lingpai();
    	$headers = ['Authorization: Bearer '.$access_token,'X-AP-Context:orgId='.$this->orgid,"Content-Type: application/json"];
    		
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    	curl_setopt($ch, CURLOPT_POST, 0);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_USERAGENT, $UserAgent);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	
    	$result = curl_exec($ch);
    	if(curl_getinfo($ch,CURLINFO_HTTP_CODE)!=200){
    		
    	}
    	curl_close($ch);
    	if(!$result){
    
    		return false;
    		//echo "Curl Error: " . curl_error($ch);
    	}else{
    		return (json_decode($result,true));exit;
    	}
    }
    
    public function _posturl($url,$jsonstr,$uuid=''){
    	$UserAgent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; .NET CLR 3.5.21022; .NET CLR 1.0.3705; .NET CLR 1.1.4322)";
    
    	$access_token=$this->lingpai();
    
    	$headers = ['Authorization: Bearer '.$access_token,'X-AP-Context:orgId='.$this->orgid,"Content-Type: application/json"];
    	
    	// var_dump($headers);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonstr);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_USERAGENT, $UserAgent);
    
    	$result = curl_exec($ch);
    
    	curl_close($ch);
    	if(!$result){
    
    		return false;
    		//echo "Curl Error: " . curl_error($ch);
    	}else{
    		return (json_decode($result,true));exit;
    	}
    }
    
    public function _puturl($url,$jsonstr,$uuid=''){
    	$UserAgent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; .NET CLR 3.5.21022; .NET CLR 1.0.3705; .NET CLR 1.1.4322)";
    
    	
    	$access_token=$this->lingpai();
    	$headers = ['Authorization: Bearer '.$access_token,'X-AP-Context:orgId='.$this->orgid,"Content-Type: application/json"];
    
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url); //定义请求地址
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); //定义请求类型，当然那个提交类型那一句就不需要了
    	curl_setopt($ch, CURLOPT_HEADER,0); //定义是否显示状态头 1：显示 ； 0：不显示 
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//定义header
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//定义是否直接输出返回流 
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonstr); //定义提交的数据
    

    	$result = curl_exec($ch);
    	curl_close($ch);
    	if(!$result){
    
    		return false;
    		//echo "Curl Error: " . curl_error($ch);
    	}else{
    		return (json_decode($result,true));
    	}
    }
    
    public function _deleteurl($url,$uuid=''){
    	$UserAgent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; .NET CLR 3.5.21022; .NET CLR 1.0.3705; .NET CLR 1.1.4322)";
    
    	$access_token=$this->lingpai();
    	$headers = ['Authorization: Bearer '.$access_token,'X-AP-Context:orgId='.$this->orgid,"Content-Type: application/json"];
    	
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_USERAGENT, $UserAgent);

    	$result = curl_exec($ch);
    	curl_close($ch);
    	if(!$result){
    		return false;
    		//echo "Curl Error: " . curl_error($ch);
    	}else{
    		return (json_decode($result,true));exit;
    	}
    }

    //获取密钥
    public function miyao(){
    	$res = exec("python3 $this->iphonekeypath $this->client_id $this->team_id $this->key_id $this->route",$out,$ress);
    	
    	return $res;
    }
    
    //请求访问令牌
    public function lingpai(){
/*
    	// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    	$cachefile = "/home/wwwroot/asa/public/ikaccess_token";
    	if(file_exists($cachefile)){
    	$data = json_decode($this->get_php_file($cachefile));
    	}
    	if ($data['expire_time'] < time()) {
  */  		
    		$url="https://appleid.apple.com/auth/oauth2/token";
    		$post_data=[
    		'grant_type'=>"client_credentials",
    		'client_id'=>$this->client_id,
    		'client_secret'=>$this->miyao(),
    		'scope'=>'searchadsorg'
    				];
    		$headers['Host']='appleid.apple.com';
    		$headers['Content-Type']='application/x-www-form-urlencoded';
    
    		$req=$this->http_post($url,$headers,$post_data);
    		//print_r($res);exit;
    
    		$req=json_decode($req,true);
    		$access_token=$req['access_token'];
    		//可以存表缓存
    		
	        //$data['expire_time'] = time() + 7000;
	       // $data['access_token'] = $access_token;
	       // $this->set_php_file($cachefile, json_encode($data));
    /*	
    }else{
     		$access_token = $data->access_token;
    	}
    	*/
	    
    
    	return $access_token;
    }

    private function get_php_file($filename) {
    	return trim(substr(file_get_contents($filename), 15));
    }
    private function set_php_file($filename, $content) {
    	$fp = fopen($filename, "w");
    	fwrite($fp, "<?php exit();?>" . $content);
    	fclose($fp);
    }

    //post传参数
    public function http_post($url,$headers,$param=''){
    	$oCurl 			= curl_init();
    	if(stripos($url,"https://")!==FALSE){
    		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
    		curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
    	}
    
    	if (is_string($param)) {
    		$strPOST 	= $param;
    	} else {
    		$aPOST 		= array();
    		foreach($param as $key=>$val){
    			$aPOST[]= $key."=".urlencode($val);
    		}
    		$strPOST 	=  join("&", $aPOST);
    	}
    
    	curl_setopt($oCurl, CURLOPT_URL, $url);
    	curl_setopt($oCurl, CURLOPT_HTTPHEADER, $headers);//设置header
    	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    	curl_setopt($oCurl, CURLOPT_POST,true);
    	curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
    
    	$sContent 		= curl_exec($oCurl);
    	$aStatus 		= curl_getinfo($oCurl);
    
    	curl_close($oCurl);
    
    	if(intval($aStatus["http_code"])==200){
    		return $sContent;
    	}else{
    		return false;
    	}
    }
    
    //get传参
    public function curl_get($url,$headers){
    
    	$curl = curl_init();
    	//设置抓取的url
    	curl_setopt($curl, CURLOPT_URL, $url);
    	//设置头文件的信息作为数据流输出
    	curl_setopt($curl, CURLOPT_HEADER, 0);
    	// 超时设置,以秒为单位
    	curl_setopt($curl, CURLOPT_TIMEOUT, 1);
    
    	// 超时设置，以毫秒为单位
    	// curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);
    
    	// 设置请求头
    	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    	//设置获取的信息以文件流的形式返回，而不是直接输出。
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    	//执行命令
    	$data = curl_exec($curl);
    
    	// 显示错误信息
    	if (curl_error($curl)) {
    		return "Error: " . curl_error($curl);
    	} else {
    		// 打印返回的内容
    		curl_close($curl);
    		return($data);
    	}
    }
    
}
