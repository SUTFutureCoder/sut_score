<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>欢迎使用德智体综合积分测评平台</title>
        <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <br/>        
    <form class="form-horizontal col-sm-10">
        <div class="form-group">
            <label for="student_class_id" class="col-sm-2 control-label">学号/班号</label>
            <div class="input-group col-sm-10">
                <input type="text" class="form-control" oninput="getStudentOrClassName(this.value)" onPropertyChange="getStudentOrClassName(this.value)"  aria-describedby="student_class_info" id="student_class_id">
                <span class="input-group-addon" id="student_class_info"></span>
            </div>
        </div>
        <hr class="col-sm-offset-2">
        <div class="form-group">
            <label for="rule_itme" class="col-sm-2 control-label">项目</label>
            <div class="col-sm-10">
                <select class="form-control" id="rule_itme" onchange="getRuleReference(this.value)" >
                    <option value="-1">请选择</option>
                    <?php foreach ($rule_item as $value): ?>
                    <option value="<?= $value['score_type_id'] ?>"><?= $value['score_type_content'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="alert alert-info col-sm-10 col-sm-offset-2" id="rule_comment" role="alert"></div>
        </div>        
        <div class="form-group">
            <label for="score_judge" class="col-sm-2 control-label">加/减分</label>
            <div class="input-group col-sm-10">
                <span class="input-group-addon" id="score_mod"></span>
                <input type="text" class="form-control" onblur="checkScoreJudge(this.value)" aria-describedby="score_range" id="score_judge">
                <span class="input-group-addon" id="score_range"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="event_time" class="col-sm-2 control-label">发生时间</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="例：2015-05-11" id="event_time">
            </div>
        </div>
        <div class="form-group">
            <label for="event_intro" class="col-sm-2 control-label">说明</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="5" id="event_intro"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="event_certify" class="col-sm-2 control-label">证明人/单位</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="event_certify">
            </div>
        </div>
        <div class="form-group">
            <label for="event_certify_file" class="col-sm-2 control-label">证明材料</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="event_certify_file">
            </div>
        </div>
    </form>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
    <script type="text/javascript" src="<?= base_url('js/jquery.form.js')?>"></script>        
    <script>
    var score_min = 0.0;
    var score_max = 0.0;
    var score_mod = '';
    function getStudentOrClassName(value){
        if (value.length == 7 || value.length == 9){
            $.post(
                '<?= base_url('index.php/search/ajaxGetStudentClassName')?>',
                {
                    id : value,
                },
                function (data){
                    var data = JSON.parse(data);
                    switch (data['code'])
                    {
                        case 1:
                            if (undefined != data['data'][0]){
                                if (undefined != data['data'][0]['student_name']){
                                    $("#student_class_info").html(data['data'][0]['student_name'] + '-' + data['data'][0]['class_name']);
                                } else {
                                    $("#student_class_info").html(data['data'][0]['class_name']);
                                }
                            }
                            break;
                        default:
                            alert(data['message']);
                            $("#student_class_id").focus();
                            break;
                    }      
                }
            )
        }
    }
    
    function getRuleReference(value){
        $.post(
            '<?= base_url('index.php/record/ajaxGetRuleReference')?>',
            {
                score_type_id : value,
            },
            function (data){
                var data = JSON.parse(data);
                console.log(data);
                switch (data['code'])
                {
                    case 1:
                        //写入两个地方well和计分参考处
                        if (undefined != data['data'][0]){
                            score_max = data['data'][0]['score_max'];
                            score_min = data['data'][0]['score_min'];
                            score_mod = data['data'][0]['score_mod'];
                            //规则提示区
                            if (data['data'][0]['score_mod'] == 'i'){
                                $("#rule_comment").removeClass('alert-danger').addClass('alert-info').html(data['data'][0]['score_type_comment']);
                                $("#score_mod").html('+');
                            } else {
                                $("#rule_comment").removeClass('alert-info').addClass('alert-danger').html(data['data'][0]['score_type_comment']);
                                $("#score_mod").html('-');
                            }
                            
                            //分数提示区
                            if (data['data'][0]['score_min'] == data['data'][0]['score_max']){
                                $("#score_range").html(data['data'][0]['score_min']);
                                $("#score_judge").val(data['data'][0]['score_min']).attr('disabled', 'disabled');
                            } else {
                                $("#score_range").html(data['data'][0]['score_min'] + '--' + data['data'][0]['score_max']);
                                if (data['data'][0]['score_mod'] == 'i'){
                                    $("#score_judge").val(data['data'][0]['score_max']).removeAttr('disabled');
                                } else {
                                    $("#score_judge").val(data['data'][0]['score_min']).removeAttr('disabled');
                                }
                            }
                        }
                        break;
                    default:
                        alert(data['message']);
                        $("#student_class_id").focus();
                        break;
                }      
            }
        )
    }
    
    //检查分数判定
    function checkScoreJudge(value){
        if (value > score_max || value < score_min){
            alert('请输入正确的数值');
            $("#score_judge").focus();
        }
    }
    </script>
</body>
</html>