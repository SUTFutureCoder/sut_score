<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>欢迎使用德智体综合积分测评平台[教务处抽风版]</title>
        <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
        <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
        <script type="text/javascript" src="<?= base_url('js/jquery.form.js')?>"></script>
        <style>
            body
            {
                background-color: #eee;
                margin-bottom: 60px;
            }
            .footer {
              position: absolute;
              bottom: 0;
              width: 100%;
              height: 80px;
            }
        </style>
        <script>
            var options = {
                dataType : "json",
                beforeSubmit : function (){
                    $(".btn").html("正在提交中，请稍后");
                    $(".btn").attr("disabled", "disabled");
                },
                success : function (result){
                    console.log(result);
                    switch (result['code'])
                    {
                        case 1:
                            location.href='<?= base_url("index.php/control_center")?>';
                            break;
                        default:
                            alert(result['error']);
                            break;
                    }                        
                    
                    $(".btn").html("登录");
                    $(".btn").removeAttr("disabled");                    
                }
            };
            
            $(".form-signin").ajaxForm(options);  
        </script>
</head>
<body>
    <div class="col-sm-8 col-sm-offset-2">
        <form action="<?= base_url("index.php/index/PassCheckOffline")?>" class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">欢迎使用德智体综合积分测评平台[教务处抽风版]</h2>
        <br/>
        <div class="form-group">            
            <input type="text" name="WebUserNO" id="WebUserNO" class="form-control" placeholder="教务处用户名" required="" autofocus="">
            <input type="password" name="Password" id="Password" class="form-control" placeholder="教务处密码" required="">            
            <input type="text" name="Agnomen" id="Agnomen" class="form-control col-lg-2" required="" placeholder="验证码"><img id="Agnomen_img" src="<?= base_url("index.php/index/getOfflineAgnomen") ?>" width="100">
        </div>
        
        <br/>
        <button type="submit" class="btn btn-lg btn-primary btn-block">登录</button>
        </form>
        <br/>
        <div class="well well-sm">
            <p>离线版使用须知：</p>
            <p>1.您需要经过其他用户授予“完全控制”或“可写个人”权限，并且在此平台在线登录过。</p>
            <p>2.离线版仅保留最低权限，您无法进行除记录查询外的查询操作。</p>
        </div>
    </div>
    
    <div class="footer">
      <div class="container">
          <p class="text-muted"><a href="https://github.com/SUTFutureCoder/sut_score">Project sut_score</a><br/>版权所有(C) 2015-<?= date('Y')?> 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen<br/>Released under the GPL V3.0 License</p>
      </div>
    </div>
</body>
</html>