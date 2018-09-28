<?php


class Api{

        private $key = '';

        private $appid = '';

        public function __construct($appid){

            if(empty($appid)){
                throw new Exception("必须提供APPID");
            }
            //根据appid 查询到 appsecret
            if($appid == '1ab9mp8920279042'){
                $key = 'q7Tc0mB26nDtxxOd2161vgd9734u92';
            }else{
                $key = '96Tidi29J897Kkdo13982BVH783290';
            }        

            
            $this->appid = $appid;
            $this->key = $key;
        }

        /**
         * get signature string
         * @param length set the signature string length,default set to '8'
         * @return string signature string 
         */
        public function createNonceStr($length = 8){
            $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $tmp = '';
            $str_length = strlen($str);
            for($i = 0 ;$i < $length ; $i++){
                $tmp .= substr($str,mt_rand(0,$str_length - 1),1);
            }

            return $tmp;
        }

        /**
         * 获取appid
         */
        public function getApiAppID(){
            return $this->appid;
        }

        /**
         * 获取签名
         * 签名字符串生成规则
         * 随机字符串 + key + 时间戳
         */
        public function getAuthToken($nonceStr,$timestamp){
            $key = $this->key;

            if(empty($key)) return false;

            $data = [];
            $data['nonce_str'] = $nonceStr;
            $data['time_stamp'] = $timestamp;
            $data['key'] = $key;

            //按字典排序
            sort($data,SORT_STRING);
            $data = implode($data);
            //sha1 加密
            $sha1_data = sha1($data);
            //md5加密
            $auth_token = md5($sha1_data);
            $auth_token = strtoupper($auth_token);
            return $auth_token;
        }

}