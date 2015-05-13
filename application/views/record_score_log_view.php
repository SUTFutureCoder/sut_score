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
                    <button type="submit" class="btn btn-default">确定</button>
                </form>
                <hr>
                <div class="alert alert-info" role="alert"><a class="col-sm-offset-2">德育：</a><a id="d_total_score"></a><a class="col-sm-offset-2">智育：</a><a id="z_total_score"></a><a class="col-sm-offset-2">文体：</a><a id="w_total_score"></a><a class="col-sm-offset-2">总分：</a><a id="total_score"></a></div>
                <!--<form class="form-horizontal col-sm-10 col-sm-offset-1">
                    <button class="form-control btn btn-primary">导出Excel表格</button>
                    <hr>
                </form> -->
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Collapsible Group Item #1
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                     Collapsible Group Item #2
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  Collapsible Group Item #3
                                </a>  
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
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
                    <button class="form-control btn btn-primary" onclick="getClassPointList()">查询</button>
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
                $(".btn").html("正在提交中，请稍后");
                $(".btn").attr("disabled", "disabled");
            },
            success : function (result){
                switch (result['code'])
                {
                    case 1:
                        $("#result").html(result['data']);
                        break;
                    default:
                        alert(result['message']);
                        break;
                }                        

                $(".btn").html("登录");
                $(".btn").removeAttr("disabled");                    
            }
        };

//        $("#student_score_search").ajaxForm(options);  
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