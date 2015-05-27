<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>欢迎使用德智体综合积分测评平台</title>
        <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
        <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
        <script type="text/javascript" src="<?= base_url('js/jquery.form.js')?>"></script>
        <script>
            var options = {
                dataType : "json",
                beforeSubmit : function (){
                    $(".btn").html("正在提交中，请稍后");
                    $(".btn").attr("disabled", "disabled");
                },
                success : function (result){
                    switch (result['code'])
                    {
                        case 1:
                            $("#result .well").html(result['data']);
                            break;
                        default:
                            alert(result['message']);
                            break;
                    }                        
                    
                    $(".btn").html("查询");
                    $(".btn").removeAttr("disabled");                    
                }
            };
            
            $("#form_search").ajaxForm(options);  
        </script>
</head>
<body>
    <br/>        
    <form class="form-inline col-sm-offset-3" id='form_search' action="<?= base_url("index.php/search/getStudentPoint")?>" method="post">
        <div class="form-group col-sm-2">
            <select class="form-control" name="term_id" id="term_id">
                <option value="0">请选择学年</option>
                <?php for ($i = date('Y'); $i >= BASIC_TERM_ID; $i--): ?>
                    <option value="<?= ($i - BASIC_TERM_ID) * 2 + 1 ?>"><?php echo ($i . '-' . ($i + 1) . '学年') ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="form-group col-sm-5">
            <input type="text" class="form-control" name="student_id" id="student_id" placeholder="学号">
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
    <br/>
    <br/>
    <hr>
    <div id='result'>
        <div class="well well-lg"></div>
    </div>
</body>
</html>