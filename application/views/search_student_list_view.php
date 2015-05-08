<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>欢迎使用德智体综合积分测评平台</title>
        <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <br/>        
    <div class="col-sm-12">
    <form class="form-horizontal col-sm-10 col-sm-offset-1" id='form_search'>
        <div class="form-group">
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
        <button class="form-control btn btn-primary" onclick="getStudentList()">查询</button>
    </form>
    </div>    
    <div class="col-sm-12" id='result'>
        <hr>
    </div>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
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

        function getStudentList(){
            if ($("#form_search_class").val() == '0000'){
                alert('请选择班级进行查询');
            } else {
                $(".btn").html("正在提交中，请稍后").attr("disabled", "disabled");
                $.post(
                    '<?= base_url('index.php/search/getStudentList')?>',
                    {
                        class_id : $("#form_search_class").val()
                    },
                    function (data){
                        $(".btn").html("查询").removeAttr("disabled");
                        var data = JSON.parse(data);
                        switch (data['code'])
                        {
                            case 1:
                                $("#result").html('<hr>' + data['data'] + '<br/>');
                                break;
                            default:
                                alert(data['message']);
                                break;
                        }                        
                    }
                )
            }
        }
        </script>
</body>
</html>