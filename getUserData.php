<?php
/**
 * 模拟API接口
 *  - 获取用户信息 
 */

 require_once './api.php';

 $api = new Api();

 $user_data = [];
 $user_data['nickname'] = 'env107';
 $user_data['age'] = 24;
 $user_data['reg_time'] = date("Y-m-d H:i",time());
 $user_data['openid'] = 'zF7ed8d67GHiy190d6H-Tgd72133sS';
 $json = [];

 if($_GET){
     $timestamp = $_GET['timestamp'];
     $nonce_str = $_GET['noncestr'];
     $token = $_GET['token'];

     if(time() - $timestamp > 15){
         json(0,"签名认证已过期，请刷新重试!");
     }

     //验证
     $_token = $api->getAuthToken($nonce_str,$timestamp);
   
     if($token === $_token){
        json(1,'',$user_data);
     }

     json(0,'签名认证失败!',['token'=>$token,'_token'=>$_token]);
     
     
 }

 function json($code,$msg = '',$data = []){
     $json = [];
     $json['code'] = $code;
     $json['msg'] = $msg;
     $json['data'] = $data;
     $json = json_encode($json);
     exit($json);
 }