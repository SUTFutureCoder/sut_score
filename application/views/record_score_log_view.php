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
            <li role="presentation" class="active"><a href="#student" id="student_aria_tab" aria-controls="student" role="tab" data-toggle="tab">学生</a></li>
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
                    <button type="button" class="btn btn-primary" id="export_excel_button" onclick="exportExcel(this, 'student')">导出Excel表格</button>
                </form>
                <hr>
                <div class="alert alert-info" id="student_score_stat" role="alert"><a class="col-sm-offset-2">德育：</a><a id="d_total_score"></a><a class="col-sm-offset-2">文体：</a><a id="w_total_score"></a><a class="col-sm-offset-2">智育：</a><a id="z_total_score"></a><a class="col-sm-offset-2">总分：</a><a id="total_score"></a></div>
                <!--<form class="form-horizontal col-sm-10 col-sm-offset-1">
                    <button class="form-control btn btn-primary">导出Excel表格</button>
                    <hr>
                </form> -->
                <div class="panel-group" id="student_accordion" role="tablist" aria-multiselectable="true">
                    
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
                    <hr/>
                    <input type="button" class="form-control btn btn-primary" id="class_export_excel" onclick="exportExcel(this, 'class')" value="导出Excel表格">
                    <!--
                    <hr>
                    <button class="form-control btn btn-primary">导出分项表格</button>
                    <button class="form-control btn btn-primary">导出合计表格</button> -->
                </form>
                <div class="col-sm-12" id='class_result'>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div hidden="hidden" id="export_excel">
                
    </div>
    <div class="modal fade " id="score_update_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="score_update_modal_title"></h4>
            </div>        
            <div class="modal-body" id="score_update_modal_body">     
                <form role="form" id="data_update_list">
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>            
                <button type="button" class="btn btn-danger" >确认</button>                
            </div>
        </div>
        </div>
    </div> 
    
    <div class="modal fade " id="score_dele_confirm_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">确认操作</h4>
            </div>        
            <div class="modal-body" id="danger_confirm_body">     
                <h3 style="color:red">您确定删除此记录吗</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>            
                <button type="button" class="btn btn-danger" onclick="" id="dele_confirm">确认</button>           
            </div>
        </div>
        </div>
    </div>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
    <script type="text/javascript" src="<?= base_url('js/jquery.form.js')?>"></script>
    <script>
        var select_term = 0;
        var options = {
            dataType : "json",
            beforeSubmit : function (){
                $("#student_submit").html("正在提交中，请稍后").attr("disabled", "disabled");
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
                            var content = '<div class="panel panel-default" id="panel_' + item['score_log_id'] + '" score="' + item['score_log_judge'] + '"><div class="panel-heading" role="tab" id="heading_stu_' + i + '">\n\
                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse_stu_' + i + '" data-toggle="collapse" aria-expanded="false" aria-controls="collapse_stu_' + i + '">' + item['score_type_content'] + '【' + item['score_log_judge'] + '】</a></h4></div>\n\
<div id="collapse_stu_' + i + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_stu_' + i +'"><div class="panel-body">\n\
<table class="table table-hover"><tbody><tr><th scope="row" class="col-sm-1">标签</th><td>' + item['score_log_event_tag'] + '</td></tr><tr><th scope="row">说明</th><td>' + item['score_log_event_intro'] + '</td></tr><tr><th scope="row">时间</th><td>' + item['score_log_event_time'] + '</td></tr><tr><th scope="row">证明</th><td><a>' + item['teacher_name'] + '-' + item['score_log_add_time'] + '</a>';
                            if (item['score_log_event_file'] != ""){
                                content += '<a type="button" target="_blank" href="<?= base_url()?>upload/' + item['score_log_event_file']  + '" class="btn btn-default">下载证明文件</a></td></tr>';
                            }  
                            
                            if (item['score_type_id'] != "z_1_1_1"){
                                content += '</td></tr><tr><th scope="row">变更</th><td><button score_log_id="' + item['score_log_id'] + '" class="btn btn-info" onclick="updateScoreLog(this)" type="button">修改</button>&nbsp;&nbsp;<button class="btn btn-danger" onclick="deleScoreLog(\'' + item['score_log_id'] + '\')" type="button">删除</button></td></tr></tbody></table></div></div></div>';
                            } else {
                                content += '</td></tr></tbody></table></div></div></div>';                                            
                            }
                                
                            student_accordion.append(content);
                        });
                        
                        break;
                    default:
                        alert(result['message']);
                        break;
                }                        

                $("#student_submit").html("查询").removeAttr("disabled");
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
        
        //导出excel
        function exportExcel(obj, type){
            if (type == 'student'){
                $("#export_excel").html('<iframe src="<?= base_url('index.php?c=record&m=getStudentScoreExcel') ?>&student_term_id=' + $("#student_term_id").val() + '&student_id=' + $("#student_id").val() +'"></iframe>');
            } else if (type == 'class'){
                $("#export_excel").html('<iframe src="<?= base_url('index.php?c=record&m=getClassScoreExcel') ?>&class_term_id=' + $("#form_search_term").val() + '&class_id=' + $("#form_search_class").val() +'"></iframe>');
            }
        }
        
        //导出班级
        function getClassPointList(){
            $("#class_submit").attr("disabled", "disabled").html("正在提交中，请稍后");
            select_term = $("#form_search_term").val();
            $.post(
                '<?= base_url('index.php/record/getClassScoreLogList')?>',
                {
                    class_term_id   : select_term,
                    class_id        : $("#form_search_class").val(),
                },
                function (result){
                    var result = JSON.parse(result);
                    switch (result['code'])
                    {
                        case 1:
                            //填充主体
                            var class_result = $("#class_result");
                            class_result.html('<hr>');
                            var content = '<table class="table table-striped table-hover"><tr><th>学号</th><th>姓名</th><th>德育</th><th>文体</th><th>智育</th><th>总分</th></tr><tbody>';
                            for (student_id in result['data']){
                                content += '<tr><th scope="row" style="cursor:pointer" onclick="searchStudentId(\'' + student_id + '\')">' + student_id + '</th><td style="cursor:pointer" onclick="searchStudentId(\'' + student_id + '\')">' + result['data'][student_id]['name'] + '</td><td>' + result['data'][student_id]['score']['d_sum'] + '</td><td>' + result['data'][student_id]['score']['w_sum'] + '</td><td>' + result['data'][student_id]['score']['z_sum'] + '</td><td>' + result['data'][student_id]['score']['sum'] + '</td></tr>';
                            }
                            content += '</tbody></table>';
                            class_result.append(content);
                            break;
                        default:
                            alert(result['message']);
                            break;
                    }
                    
                    $("#class_submit").removeAttr("disabled").html("查询");
                }
            )
        }
        
        //在班级面板中点击id或姓名切换标签页并搜索
        function searchStudentId(student_id){
            var student_tab = $("#student");
            $("#student_aria_tab").tab('show');
            student_tab.find("#student_term_id option[value='" + select_term + "']").attr("selected", true);
            student_tab.find("#student_term_id option[value='" + select_term + "']").attr("selected", true);
            student_tab.find("#student_id").val(student_id);
            student_tab.find("#student_score_search").submit();
        }
        
        //显示确认删除框
        var score_dele_confirm_modal = $("#score_dele_confirm_modal");
        function deleScoreLog(score_log_id){
            score_dele_confirm_modal.find('#dele_confirm').attr('onclick', 'deleScoreLogConfirm("' + score_log_id + '")');
            score_dele_confirm_modal.modal('show');
        }
        
        //确认删除
        function deleScoreLogConfirm(score_log_id){
            $.post(
                '<?= base_url('index.php/record/deleScoreLog')?>',
                {
                    score_log_id : score_log_id
                },
                function (result){
                    var result = JSON.parse(result);
                    switch (result['code'])
                    {
                        case 1:
                            var score_log_panel = $("#panel_" + score_log_id);
                            var score = parseFloat(score_log_panel.attr("score"));
                            score_dele_confirm_modal.modal('hide');
                            var student_score_stat = $("#student_score_stat");
                            student_score_stat.find('#d_total_score,#w_total_score,#z_total_score').html(' ');
                            var total_score = parseFloat(student_score_stat.find('#total_score').html());
                            if (score < 0){
                                total_score += score;
                            } else {
                                total_score -= score
                            }
                            student_score_stat.find('#total_score').html(total_score);
                            score_log_panel.remove();
                            break;
                        default:
                            alert(result['message']);
                            break;
                    }
                }
            )
        }
        
        //修改
        var score_update_modal = $("#score_update_modal");
        function updateScoreLog(obj){
            score_update_modal.find('#dele_confirm').attr('onclick', 'deleScoreLogConfirm("' + score_log_id + '")');
            score_update_modal.modal('show');
        }
    </script>
</body>
</html>