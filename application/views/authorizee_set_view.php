<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>欢迎使用德智体综合积分测评平台</title>
        <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <br/>
    <form class="form-horizontal col-sm-10 col-sm-offset-1">
        <div class="form-group">
            <label for="teacher_student_id" class="col-sm-2 control-label">教师/学生id</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="teacher_student_id">
            </div>
        </div>
        <div class="form-group">
            <label for="role_list" class="col-sm-2 control-label">权限</label>
            <div class="col-sm-10">
                <select class="form-control" id="role_list">
                    <option value="0">全部年级</option>
                    <?php for($i = date('Y'); $i >= ORIGIN_GRADE; $i--): ?>
                    <option value="<?= substr($i, 2, 2) ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <button class="form-control btn btn-primary" id="class_submit" onclick="setRight()">授权</button>
        </div>
    </form>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
    <script type="text/javascript" src="<?= base_url('js/jquery.form.js')?>"></script>
    <script>
        var select_term = 0;
        var options = {
            dataType : "json",
            beforeSubmit : function (){
                $("#student_submit").html("正在提交中，请稍后");
                $("#student_submit").attr("disabled", "disabled");
            },
            success : function (result){
                console.log(result);
                switch (result['code'])
                {
                    case 1:
                        var student_score_stat = $("#student_score_stat");
                        student_score_stat.find("#d_total_score").html(result['data']['score']['d_sum']);
                        student_score_stat.find("#w_total_score").html(result['data']['score']['w_sum']);
                        student_score_stat.find("#z_total_score").html(result['data']['score']['z_sum']);
                        student_score_stat.find("#total_score").html(result['data']['score']['sum']);
                        
                        //填充主体
                        var student_accordion = $("#student_accordion");
                        student_accordion.html('');
                        $.each(result['data']['data'], function(i, item){
                            var content = '<div class="panel panel-default"><div class="panel-heading" role="tab" id="heading_stu_' + i + '">\n\
                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse_stu_' + i + '" data-toggle="collapse" aria-expanded="false" aria-controls="collapse_stu_' + i + '">' + item['score_type_content'] + '【' + item['score_log_judge'] + '】</a></h4></div>\n\
<div id="collapse_stu_' + i + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_stu_' + i +'"><div class="panel-body">\n\
<table class="table table-hover"><tbody><tr><th scope="row" class="col-sm-1">标签</th><td>' + item['score_log_event_tag'] + '</td></tr><tr><th scope="row">说明</th><td>' + item['score_log_event_intro'] + '</td></tr><tr><th scope="row">时间</th><td>' + item['score_log_event_time'] + '</td></tr><tr><th scope="row">证明</th><td>' + item['teacher_name'] + '-' + item['score_log_add_time'];
                            if (item['score_log_event_file'] != ""){
                                content += '<a type="button" target="_blank" href="<?= base_url()?>upload/' + item['score_log_event_file']  + '" class="btn btn-default">下载证明文件</a></td></tr><tr><th scope="row">变更</th><td>Larry</td></tr></tbody></table></div></div></div>';
                            } else {
                                content += '</td></tr><tr><th scope="row">变更</th><td>Larry</td></tr></tbody></table></div></div></div>';
                            }   
                            student_accordion.append(content);
                        });
                        
                        break;
                    default:
                        alert(result['message']);
                        break;
                }                        

                $("#student_submit").html("查询");
                $("#student_submit").removeAttr("disabled");                    
            }
        };

        $("#student_score_search").ajaxForm(options);  
    </script>
    <script>
        function updateList(type){
            $.post(
                '<?= base_url('index.php/search/ajaxGetMajorClassList')?>',
                {
                    school_id : $("#form_search_school").val(),
                    major_id : $("#form_search_major").val(),
                    grade_id : $("#form_search_grade").val()
                },
                function (data){
                    var data = JSON.parse(data);
                    
                    if (type != 'major' && type != 'grade'){
                        $("#form_search_major").empty();
                        $("#form_search_major").append('<option value="00">全部专业</option>');
                        $.each(data['major'], function(i, item){
                            $("#form_search_major").append('<option value="' + item['major_id'] + '">' + item['major_name'] + '</option>');
                        });
                    }
                    
                    $("#form_search_class").empty();
                    $("#form_search_class").append('<option value="0000">班级</option>');
                    $.each(data['class'], function(i, item){
                        $("#form_search_class").append('<option value="' + item['class_id'] + '">' + item['class_id'] + '[' + item['class_name'] + ']'  + '</option>');
                    });
                }
            )
        }
        
    </script>
</body>
</html>