<?php


class Api{

        private $key = 'q7Tc0mB26nDtxxOd@216';

        public function __construct(){
            if(empty($this->key)){
                throw new Exception('The "ApiKey" must a needed params');
            }
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
         * 获取key
         */
        public function getApiKey(){
            return $this->key;
        }

        /**
         * 获取签名
         * 签名字符串生成规则
         * 随机字符串 + key + 时间戳
         */
        public function getAuthToken($nonceStr,$timestamp){
            $key = $this->key;
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