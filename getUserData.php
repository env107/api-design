<?php
/**
 * 模拟API接口
 *  - 获取用户信息 
 */

 require_once './api.php';
 $user_data = [];
 $user_data['nickname'] = 'env107';
 $user_data['age'] = 24;
 $user_data['reg_time'] = date("Y-m-d H:i",time());
 $user_data['openid'] = 'zF7ed8d67GHiy190d6HTgd72133sS';
 $json = [];

 if($_GET){
     $timestamp = $_GET['timestamp'];
     $appid = $_GET['appid'];
     $nonce_str = $_SERVER['HTTP_NONCESTR'];
     $token = $_SERVER['HTTP_TOKEN'];
     $api = new Api($appid);

     if(time() - $timestamp > 15){
         json(0,"签名认证已过期，请刷新重试!");
     }

     //验证
     $_token = $api->getAuthToken($nonce_str,$timestamp);

     if($token === $_token){
        json(1,'success',$user_data);
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