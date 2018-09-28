<?php 
    require_once "./api.php";
    
        $appid = '1ab9mp8920279042';
        $api = new Api($appid);
        $timestamp = time();
        $nonce_str = $api->createNonceStr(); //随机字符串
        $token = $api->getAuthToken($nonce_str,$timestamp); 
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>请求用户信息</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>

        function getUserInfo(){

            var token = '<?php echo $token;?>'
            var timestamp = '<?php echo $timestamp; ?>';
            var nonce_str = '<?php echo $nonce_str; ?>';
            var appid = '<?php echo $appid;?>';

            $.ajax({
                url:'/getUserData.php',
                data:{
                    timestamp:timestamp,
                    appid:appid,
                },
                headers:{
                    token:token,
                    noncestr:nonce_str,
                },
                method:"get",
                success:function(res){
                    var res = $.parseJSON(res);
                    if(res.code != 1){
                        alert("API错误:" + res.msg);
                        return false;
                    }else{
                        alert("请求成功!");
                        setUserInfo({
                            nickname:res.data.nickname,
                            age:res.data.age,
                            regtime:res.data.reg_time,
                            openid:res.data.openid
                        });
                    }
                }
            });

            return false;
        }

        function setUserInfo(data){
            for(var k in data){
                $("#" + k).text(data[k]);
            }

            return true;
        }

    </script>
</head>
<body>
    <div class="get-user">
        用户信息
            <div class="user-item">昵称: <span id="nickname"></span></div>
            <div class="user-item">年龄: <span id="age"></span></div>
            <div class="user-item">注册时间: <span id="regtime"></span> </div>
            <div class="user-item">openid: <span id="openid"></span></div>
            <input type="submit" onclick="return getUserInfo()" name="submit" value="点击获取用户信息" />
    </div>

</body>
</html>