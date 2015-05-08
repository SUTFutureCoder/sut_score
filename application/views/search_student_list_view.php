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
            <select class="form-control" onchange="check(this.value)" id="form_search_school">
                <option value="00">学院</option>
                <?php foreach ($school_list as $value): ?>
                <option value="<?= $value['school_id'] ?>"><?= $value['school_name'] ?></option>
                <?php endforeach ;?>
            </select>
            <br/>
            <select class="form-control" onchange="check(this.value)" id="form_search_school">
                <option value="00">专业</option>
                <?php foreach ($major_list as $value): ?>
                <option value="<?= $value['major_id'] ?>"><?= $value['major_name'] ?></option>
                <?php endforeach ;?>
            </select>
            <br/>
            <select class="form-control" onchange="check(this.value)" id="form_search_grade">
                <option value="0">年级</option>
                <?php for($i = date('Y'); $i >= ORIGIN_GRADE; $i--): ?>
                <option value="<?= substr($i, 2, 2) ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <br/>
            <select class="form-control" onchange="check(this.value)" id="form_search_class">
                <option value="0000">班级</option>
                <?php foreach ($class_list as $value): ?>
                <option value="<?= $value['class_id'] ?>"><?= $value['class_id'] . '[' . $value['class_name'] . ']'?></option>
                <?php endforeach ;?>
            </select>
        </div>
        <button class="form-control btn btn-default" onclick="getStudentList()">确定</button>
    </form>
    </div>    
    <div class="col-sm-12" id='result'>
        <hr>
    </div>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
    <script>
        function getMajorList(){
            $.post(
                '<?= base_url('index.php/test/saveAnswer')?>',
                {
                    answer_data : json,
                    fin : 0
                },
                function (data){
                    var data = JSON.parse(data);
                    switch (data['code']){
                        case 1:
                            break;
                    }
                }
            )
        }

            
        </script>
</body>
</html>