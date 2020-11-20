<?php
$username='825395018';//接口用户名
$password='fA4yIDz17BXCzG';//接口密码
$real_page = 'wrg.html';//广告页面文件名
$safe_page = 'safe.html';//伪装页面文件名
$jsonData = array();
$jsonData['country']= 'TW';//投放的国家地区，ALL为全可以访问，留空为全部不允许
$jsonData['mobile']='0';//1为只允许手机 2为只允许pc 0为不限制
$jsonData['domain'] = $_SERVER['HTTP_HOST'];
$jsonData['ua'] = $_SERVER['HTTP_USER_AGENT'];
$jsonData['referer'] = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
if(isset($_SERVER['HTTP_X_SHOPIFY_CLIENT_IP'])){
    $jsonData['ip'] = $_SERVER['HTTP_X_SHOPIFY_CLIENT_IP']; 
}
else if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $jsonData['ip'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
} else {
    if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $jsonData['ip'] = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $jsonData['ip'] = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $jsonData['ip'] = getenv('REMOTE_ADDR');
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $jsonData['ip'] = $_SERVER['REMOTE_ADDR'];
    }
}
$ch = curl_init('https://cloakplus.com/v2/');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_TIMEOUT,1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($jsonData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$return = curl_exec($ch);
$return = json_decode($return, true);
$boolean = $return['result'];
if ($boolean){
    echo file_get_contents($real_page);
    //或者header("location:$$real_url");
    //推荐echo file_get_contents实现，跳转目前容易被封
}else{
    echo file_get_contents($safe_page);
}