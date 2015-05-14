<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>欢迎使用德智体综合积分测评平台</title>
        <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#student" aria-controls="student" role="tab" data-toggle="tab">学生</a></li>
            <li role="presentation"><a href="#class" aria-controls="class" role="tab" data-toggle="tab">班级</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="student">
                <br/>
                <form class="form-inline col-sm-offset-3" id='student_score_search' action="<?= base_url("index.php/record/getStudentScoreLogList")?>" method="post">
                    <div class="form-group col-sm-2">
                        <select class="form-control" name="student_term_id" id="student_term_id">
                            <option value="0">请选择学年</option>
                            <?php for ($i = date('Y'); $i >= BASIC_TERM_ID; $i--): ?>
                                <option value="<?= ($i - BASIC_TERM_ID) * 2 + 1 ?>"><?php echo ($i . '-' . ($i + 1) . '学年') ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-5">
                        <input type="text" class="form-control" name="student_id" id="student_id" placeholder="学号">
                    </div>
                    <button type="submit" id="student_submit" class="btn btn-default">查询</button>
                </form>
                <hr>
                <div class="alert alert-info" id="student_score_stat" role="alert"><a class="col-sm-offset-2">德育：</a><a id="d_total_score"></a><a class="col-sm-offset-2">文体：</a><a id="w_total_score"></a><a class="col-sm-offset-2">智育：</a><a id="z_total_score"></a><a class="col-sm-offset-2">总分：</a><a id="total_score"></a></div>
                <!--<form class="form-horizontal col-sm-10 col-sm-offset-1">
                    <button class="form-control btn btn-primary">导出Excel表格</button>
                    <hr>
                </form> -->
                <div class="panel-group" id="student_accordion" role="tablist" aria-multiselectable="true">
                    
                </div>
                
                <div id='result'>
                    
                </div>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="class">
                <br/>
                <form class="form-horizontal col-sm-10 col-sm-offset-1" id='form_search'>
                    <div class="form-group">
                        <select class="form-control" id="form_search_term">
                            <option value="0">请选择学年</option>
                            <?php for ($i = date('Y'); $i >= BASIC_TERM_ID; $i--): ?>
                                <option value="<?= ($i - BASIC_TERM_ID) * 2 + 1 ?>"><?php echo ($i . '-' . ($i + 1) . '学年') ?></option>
                            <?php endfor; ?>
                        </select>
                        <br/>
                        <select class="form-control" onchange="updateList('school')" id="form_search_school">
                            <option value="00">全部学院</option>
                            <?php foreach ($school_list as $value): ?>
                            <option value="<?= $value['school_id'] ?>"><?= $value['school_name'] ?></option>
                            <?php endforeach ;?>
                        </select>
                        <br/>
                        <select class="form-control" onchange="updateList('major')" id="form_search_major">
                            <option value="00">全部专业</option>
                            <?php foreach ($major_list as $value): ?>
                            <option value="<?= $value['major_id'] ?>"><?= $value['major_name'] ?></option>
                            <?php endforeach ;?>
                        </select>
                        <br/>
                        <select class="form-control" onchange="updateList('grade')" id="form_search_grade">
                            <option value="0">全部年级</option>
                            <?php for($i = date('Y'); $i >= ORIGIN_GRADE; $i--): ?>
                            <option value="<?= substr($i, 2, 2) ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <br/>
                        <select class="form-control" id="form_search_class">
                            <option value="0000">班级</option>
                            <?php foreach ($class_list as $value): ?>
                            <option value="<?= $value['class_id'] ?>"><?= $value['class_id'] . '[' . $value['class_name'] . ']'?></option>
                            <?php endforeach ;?>
                        </select>
                    </div>
                    <button class="form-control btn btn-primary" id="class_submit" onclick="getClassPointList()">查询</button>
                    <!--
                    <hr>
                    <button class="form-control btn btn-primary">导出分项表格</button>
                    <button class="form-control btn btn-primary">导出合计表格</button> -->
                </form>
                <div class="col-sm-12" id='result'>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
    <script type="text/javascript" src="<?= base_url('js/jquery.form.js')?>"></script>
    <script>
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
                            student_accordion.append('<div class="panel panel-default"><div class="panel-heading" role="tab" id="heading_stu_' + i + '">\n\
                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse_stu_' + i + '" data-toggle="collapse" aria-expanded="false" aria-controls="collapse_stu_' + i + '">' + item['score_type_content'] + '【' + item['score_log_judge'] + '】</a></h4></div>\n\
<div id="collapse_stu_' + i + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_stu_' + i +'"><div class="panel-body">\n\
<table class="table table-hover"><tbody><tr><th scope="row">标签</th><td>' + item['score_log_event_tag'] + '</td></tr><tr><th scope="row">说明</th><td>' + item['score_log_event_intro'] + '</td></tr><tr><th scope="row">时间</th><td>' + item['score_log_event_time'] + '</td></tr><tr><th scope="row">证明</th><td>' + item['teacher_name'] + '-' + item['score_log_add_time'] + '<?= base_url()?>upload/' + item['score_log_event_file']  + '</td></tr><tr><th scope="row">变更</th><td>Larry</td></tr></tbody></table></div></div></div>');
                        });
                        
                        $("#accordion").html(result['data']);
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