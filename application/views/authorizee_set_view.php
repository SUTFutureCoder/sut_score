<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>欢迎使用德智体综合积分测评平台</title>
        <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <br/>
    <form class="form-horizontal col-sm-10 col-sm-offset-1" action="<?= base_url("index.php/right/setAuthorizee")?>" method="post" id="right_set_form">
        <div class="form-group">
            <label for="teacher_student_id" class="col-sm-2 control-label">教师/学生id</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="teacher_student_id">
            </div>
        </div>
        <div class="form-group">
            <label for="role_list" class="col-sm-2 control-label">权限</label>
            <div class="col-sm-10">
                <select class="form-control" id="right_set_form_type">
                    <option value="0">只读</option>
                    <?php foreach ($right_list as $item): ?>
                        <option value="<?= $item['role_id'] ?>"><?= $item['role_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <button class="form-control btn btn-primary" id="right_submit">授权</button>
        </div>
    </form>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
    <script type="text/javascript" src="<?= base_url('js/jquery.form.js')?>"></script>
    <script>
        var right_set_form = $("#right_set_form");
        var options = {
            dataType : "json",
            beforeSubmit : function (){
                right_set_form.find("#right_submit").attr("disabled", "disabled").html("正在提交中，请稍后");
            },
            success : function (result){
                console.log(result);
                switch (result['code'])
                {
                    case 1:
                        
                        
                        break;
                    default:
                        alert(result['message']);
                        break;
                }                        
                right_set_form.find("#right_submit").html("查询").removeAttr("disabled");
            }
        };

        right_set_form.ajaxForm(options);  
    </script>
</body>
</html>