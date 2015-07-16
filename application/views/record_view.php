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
                <?php if (in_array($role_index, array('god', 'admin', 'write_all'))): ?>
                    <input type="text" class="form-control" oninput="getStudentOrClassName(this.value)" onPropertyChange="getStudentOrClassName(this.value)"  aria-describedby="student_class_info" id="student_class_id">
                    <span class="input-group-addon" id="student_class_info"></span>
                <?php else: ?>
                    <input type="text" class="form-control" value="<?= $user_id ?>" readonly="readonly" aria-describedby="student_class_info" id="student_class_id">
                <?php endif; ?>
            </div>
        </div>
        <hr class="col-sm-offset-2">
        <div class="form-group">
            <label for="rule_item" class="col-sm-2 control-label">项目</label>
            <div class="col-sm-10">
                <select class="form-control" id="rule_item" onchange="getRuleReference(this.value)" >
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
            <label for="event_tag" class="col-sm-2 control-label">标签</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" placeholder="例：ACM程序设计大赛 请填写关键字以用于同项高计" id="event_tag">
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
    </form>
    <form action="<?= base_url('index.php/record/ajaxFileUpload')?>" class="form-horizontal col-sm-10" id="form1" name="form1" encType="multipart/form-data"  method="post" target="file_frame">
        <div class="form-group">
            <label for="event_certify_file" class="col-sm-2 control-label">证明材料</label>
            <div class="col-sm-9">
                <input type="hidden" hidden="hidden" class="form-control" name="certify_class_user_id" id="certify_class_user_id">
                <input type="hidden" hidden="hidden" class="form-control" name="certify_rule_id" id="certify_rule_id">
                <input type="hidden" hidden="hidden" class="form-control" name="certify_file_info" id="certify_file_info">
                <input type="file" class="form-control" id="event_certify_file" name="file">
            </div>
            <button class="btn btn-info" id="upload_submit" type="submit">上传</button>
        </div>
        <hr>
        <div class="form-group">
            <div class="col-sm-11 col-sm-offset-1">
                <button type="button" class="btn btn-info btn-block" onclick="submitScore()" id="score_log_submit">添加记录</button>
            </div>
        </div>
    </form>
    <iframe name='file_frame' id="file_frame" style='display:none'></iframe>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
    <script type="text/javascript" src="<?= base_url('js/jquery.form.js')?>"></script>        
    <script type="text/javascript" src="<?= base_url('js/ajaxfileupload.js')?>"></script>        
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
                                $("#certify_class_user_id").val(value);
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
                            $("#certify_rule_id").val(value);
                            score_max = data['data'][0]['score_max'];
                            score_min = data['data'][0]['score_min'];
                            score_mod = data['data'][0]['score_mod'];
                            //规则提示区
                            if (data['data'][0]['score_mod'] == 'i'){
                                $("#rule_comment").removeClass('alert-danger').addClass('alert-info').html(data['data'][0]['score_type_comment']);
                                $("#upload_submit").removeClass('btn-danger').addClass('btn-info');
                                $("#score_log_submit").removeClass('btn-danger').addClass('btn-info');
                                $("#score_mod").html('+');
                            } else {
                                $("#rule_comment").removeClass('alert-info').addClass('alert-danger').html(data['data'][0]['score_type_comment']);
                                $("#upload_submit").removeClass('btn-info').addClass('btn-danger');
                                $("#score_log_submit").removeClass('btn-info').addClass('btn-danger');
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
    
    //完成填写，传送数据
    function submitScore(){
        $.post(
            '<?= base_url('index.php/record/setScoreLog')?>',
            {
                class_student_id    : $("#student_class_id").val(),
                score_type_id       : $("#rule_item").val(),
                score_mod           : $("#score_mod").html(),
                score_log_judge     : $("#score_judge").val(),
                score_log_event_time: $("#event_time").val(),
                score_log_event_tag : $("#event_tag").val(),
                score_log_event_intro:$("#event_intro").val(),
                score_log_event_certify:$("#event_certify").val(),
                score_log_event_file: $("#certify_file_info").val()
            },
            function (data){
                var data = JSON.parse(data);
                console.log(data);
                switch (data['code'])
                {
                    case 1:
                        alert('添加成功');
                        <?php if ('write_person' != $role_index): ?>
                            $("#student_class_id").val('');
                        <?php endif; ?>
                        $("#event_time").val('');
                        $("#event_tag").val('');
                        $("#event_intro").val('');
                        $("#event_certify").val('');
                        $("#certify_file_info").val('');
                        var file = $('#event_certify_file');
                        file.after(file.clone().val(''));
                        file.remove();
                        break;
                    case 3:
                        alert(data['message']);
                        $("#" + data['id']).focus();
                        break;
                    default:
                        alert(data['message']);
                        break;
                }      
            }
        )
    }
    
    </script>
</body>
</html>