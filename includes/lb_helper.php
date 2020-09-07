<?php if(count(get_included_files()) ==1) exit("No direct script access allowed");
ini_set('max_execution_time', 0);
ini_set('memory_limit', '268435456');

define("LB_API_DEBUG", false);

if(!LB_API_DEBUG){
ini_set('display_errors', 0);
}

class LicenseBoxAPI {

  private $product_id;
  private $api_url;
  private $current_version;
  private $current_path;
  private $root_path;
  private $verify_type;
  private $api_key;
  private $license_file;
  private $verification_period;

  public function __construct()
  { 
    $this->product_id = 'GROCERY001';
  //  $this->api_url = 'https://thecodecafe.in/activator/';
    $this->current_version = 'v1.0.0';
    $this->current_path = realpath(_DIR_);
    $this->root_path = realpath($this->current_path.'/..');
    $this->verify_type = 'envato';
    $this->api_key = '64627C9198DDF35A9303';
 //   $this->license_file = $this->current_path.'/.lic';
    $this->verification_period = 7;
  }

  private function callAPI($method, $url, $data)
  {
    $curl = curl_init();
    switch ($method){
      case "POST":
      curl_setopt($curl, CURLOPT_POST, 1);
      if ($data)
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        break;
      case "PUT":
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
      if ($data)
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                         
        break;
      default:
      if($data)
        $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    $this_server_name = getenv('SERVER_NAME')?:$_SERVER['SERVER_NAME']?:getenv('HTTP_HOST')?:$_SERVER['HTTP_HOST'];
    $this_http_or_https = (((isset($_SERVER['HTTPS'])&&($_SERVER['HTTPS']=="on")) or (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) ? 'https://' : 'http://');
    $this_url = $this_http_or_https.$this_server_name.$_SERVER['REQUEST_URI'];
    $this_ip = getenv('SERVER_ADDR')?:
      $_SERVER['SERVER_ADDR']?:
      getenv('REMOTE_ADDR')?:
      $_SERVER['REMOTE_ADDR']?:
      $this->get_ip_from_third_party();
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'LB-API-KEY: '.$this->api_key, 'LB-URL: '.$this_url, 'LB-IP: '.$this_ip));
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if(!$result&&!LB_API_DEBUG){
      $rs = array('status' => FALSE, 'message' => 'Connection to server failed or the server returned an error, please contact support');
      return json_encode($rs);
    }
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if(!LB_API_DEBUG){
      if($http_status!=200){
        $rs = array('status' => FALSE, 'message' => 'Server returned an invalid response, please contact support');
        return json_encode($rs);
      }
    }
    curl_close($curl);
    return $result;
  }

  public function get_current_version(){
   return $this->current_version;
  }

  public function get_latest_version(){
    return true;
  }

  public function activate_license($license,$client, $create_lic = true){
   
   return true;
  }

  public function verify_license($time_based_check = true, $license = true, $client = true){
    
   return true;
  }

  public function check_update(){
   return true;
  }

  public function deactivate_license($license = true, $client = true){
    if(!empty($license)&&!empty($client)){
     return true;
  }
}
  public function download_update($update_id,$type,$version,$license = true, $client = true)
  { 
  return true;
  }

  private function get_real($url) 
  {
    $headers = get_headers($url);
    foreach($headers as $header) {
        if (strpos(strtolower($header),'location:') !== false) {
            return preg_replace('./(.)', '$1', $header);
        }
    }
  }

  private function get_ip_from_third_party(){
      $ch = curl_init ();
      curl_setopt ($ch, CURLOPT_URL, "http://ipecho.net/plain");
      curl_setopt ($ch, CURLOPT_HEADER, 0);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec ($ch);
      curl_close ($ch);
      return $response;
  }

  private function getRemoteFilesize($url)
  {
      return true;
    
  }
}
?>