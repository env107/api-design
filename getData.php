<?php 
    require_once "./api.php";
    $api = new Api();
    $data = [];
    if($_POST){
        
        $token = $_POST['token'];
        $nonce_str = $_POST['nonce_str'];
        $timestamp = $_POST['timestamp'];
            
        $rs = httpGet('http://localhost/getUserData.php',[
            'timestamp' => $timestamp,
            'noncestr' => $nonce_str,
            'token' => $token
        ]);

        $rs_data = json_decode($rs,true);
        if($rs_data['code'] != 1){
            echo "请求错误:".$rs_data['msg'];
        }else{
            echo "请求成功!";
            $data = $rs_data['data'];
        }
    }else{
        $timestamp = time();
        $nonce_str = $api->createNonceStr(); //随机字符串
        $token = $api->getAuthToken($nonce_str,$timestamp); 
    }

    function httpGet($url,$data = []){
        $ch = curl_init();//初始化curl函数
        if(!empty($data)){
            $query = "?";
            foreach($data as $key=>$value){
                $query .= $key."=".$value."&";
            }
            $query = trim($query,"&");
        }
        $url = $url.$query;
        echo "url:".$url;
        curl_setopt($ch,CURLOPT_URL,$url);//GET方式抓取url
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        return $res;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>请求用户信息</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<form name="form" action="" method="post">
    <div class="get-user">
        点击此处获取用户信息:
        <?php if(!empty($data)){ ?>
            <div class="user-item">昵称: <?php echo $data['nickname'];?></div>
            <div class="user-item">年龄: <?php echo $data['age'];?></div>
            <div class="user-item">注册时间: <?php echo $data['reg_time'];?></div>
            <div class="user-item">openid: <?php echo $data['openid'];?></div>
        <?php } ?>
        <input type="submit" name="submit" value="提交" />
        <input type="hidden" name="token" value="<?php echo $token;?>" />
        <input type="hidden" name="timestamp" value="<?php echo $timestamp;?>" />
        <input type="hidden" name="nonce_str" value="<?php echo $nonce_str;?>" />
    </div>
</form>
</body>
</html>