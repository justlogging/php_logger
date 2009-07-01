<?php
class Justlogging {
  
  var $api_key;
  var $host;
  var $log_key;
  
  function __construct($api_key, $host, $log_key){
    $this->api_key = $api_key;
    $this->log_key = $log_key;
    $this->host = $host;
  }
  
  function host(){
    return "http://".$this->host."/log";
  }
  
  function log($entry, $log_key = null){
    $log_key = ($log_key) ? $log_key : $this->log_key;

	// Check if cURL exists
	if(!function_exists('curl_exec')){
		throw new Exception('cURL is not installed, please install cURL.');
	}
    
    $post_data = "access_key=".$this->api_key."&log_key=".$log_key."&entry=".$entry;
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$this->host()); // set url to post to 
    curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable 
    curl_setopt($ch, CURLOPT_TIMEOUT, 0); // times out after Ns 
    curl_setopt($ch, CURLOPT_POST, 1); // set POST method 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); // add POST fields 
    curl_setopt($ch, CURLOPT_VERBOSE, 0); // Shows debug info if set to 1
    $result = curl_exec($ch); // run the whole process 
	$info = curl_getinfo($ch); // get header info
	curl_close($ch); 
    
	if ($info['http_code'] != 201) {
	  return false;
	} else {
	  return true;
	}
  }
}
?>