<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php if ($online): ?>
<title>德智体综合积分控制面板</title>
<?php else: ?>
<title>德智体综合积分控制面板[离线版]</title>
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('/jq-ui/themes/cupertino/easyui.css')?>" id="swicth-style">
<script type="text/javascript" src="<?php echo base_url('/jq-ui/jquery-1.7.2.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('/jq-ui/jquery.easyui.min.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('/jq-ui/style.css')?>" id="swicth-style">
</head> 
<body class="easyui-layout">
<div region="north" border="false" class="cs-north" style="height:30px; overflow:hidden">
                <div  style="height: 30px; top:5px; overflow: hidden; position: relative; left: 10px; float: left">
                    <?php if ($online && 5 == strlen($user_id)): ?>
                        <a href="javascript:void(0);" src="<?= base_url('index.php/control_center/getTeacherInfo') ?>" class="cs-navi-tab">您好，尊敬的&nbsp;<?= $user_name ?></a>
                    <?php else: ?>
                        <a href="#">您好，尊敬的&nbsp;<?= $user_name ?></a>
                    <?php endif; ?>
                </div>
		<div class="cs-north-bg"style="top:0%" >
		<ul class="ui-skin-nav">				
			<li class="li-skinitem" title="gray"><span class="gray" rel="gray"></span></li>
			<li class="li-skinitem" title="pepper-grinder"><span class="pepper-grinder" rel="pepper-grinder"></span></li>
			<li class="li-skinitem" title="blue"><span class="blue" rel="blue"></span></li>
			<li class="li-skinitem" title="cupertino"><span class="cupertino" rel="cupertino"></span></li>
			<li class="li-skinitem" title="dark-hive"><span class="dark-hive" rel="dark-hive"></span></li>
			<li class="li-skinitem" title="sunny"><span class="sunny" rel="sunny"></span></li>
		</ul>	
		</div>	</div>
	<div region="west" border="true" split="true" title="索引" class="cs-west">
                <div class="easyui-accordion" fit="true" border="false">
                        <div title="记录管理">
                        <?php if ($role_index != 'readonly'): ?>
                            <a href="javascript:void(0);" src="<?= base_url('index.php/record/showRecordD') ?>" class="cs-navi-tab">德育</a></p>
                            <a href="javascript:void(0);" src="<?= base_url('index.php/record/showRecordZ') ?>" class="cs-navi-tab">智育</a></p>
                            <a href="javascript:void(0);" src="<?= base_url('index.php/record/showRecordW') ?>" class="cs-navi-tab">文体</a></p>
                        <?php endif; ?>
                            <a href="javascript:void(0);" src="<?= base_url('index.php/record/getReference') ?>" class="cs-navi-tab">规则参考</a></p>
                            <a href="javascript:void(0);" src="<?= base_url('index.php/record/showGetScoreLog') ?>" class="cs-navi-tab">记录查询</a></p>
                        </div>
                    <?php if ($role_index != 'readonly'): ?>
                    <?php if ($online && 5 == strlen($user_id)): ?>
                        <div title="抓取查询">
                            <a href="javascript:void(0);" src="<?= base_url('index.php/search/showSearchStudent') ?>" class="cs-navi-tab">学生信息查询</a></p>
                            <a href="javascript:void(0);" src="<?= base_url('index.php/search/showSearchStudentList') ?>" class="cs-navi-tab">班级学生名单查询</a></p>
                            <a href="javascript:void(0);" src="<?= base_url('index.php/search/showSearchClassPoint') ?>" class="cs-navi-tab">班级绩点统计</a></p>
                            <a href="javascript:void(0);" src="<?= base_url('index.php/search/showSearchStudentMark') ?>" class="cs-navi-tab">学生成绩查询</a></p>
                            <a href="javascript:void(0);" src="<?= base_url('index.php/search/showSearchStudentPoint') ?>" class="cs-navi-tab">学生平均绩点查询</a></p>
                            <!-- <a href="javascript:void(0);" src="<?= base_url('index.php/search/showSearchStudentMark') ?>" class="cs-navi-tab">竞赛时间数据挖掘</a></p> -->
                        <?php if (in_array($role_index, array('god', 'admin'))): ?>
                            <a href="javascript:void(0);" src="<?= base_url('index.php/fetch/fetchStudentBasicInfo') ?>" class="cs-navi-tab">全校名单缓存更新</a></p>
                        <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (in_array($role_index, array('god', 'admin'))):?>
                        <div title="权限相关">
                            <a href="javascript:void(0);" src="<?= base_url('index.php/right/showAuthorizeeSet')?>" class="cs-navi-tab">授权用户</a></p>
                        </div>       
                    <?php endif; ?>
                    <?php endif; ?>
		</div>
	</div>
	<div id="mainPanle" region="center" border="true" border="false">
            <div id="tabs" class="easyui-tabs"  fit="true" border="false" >
                <div title="Home">
                    <div class="cs-home-remark">
                        <?php if ($online): ?>
                        <h1>德智体综合积分测评控制面板</h1> <br>
                        <?php else: ?>
                        <h1>德智体综合积分测评控制面板[离线版]</h1> <br>
                        <?php endif; ?>
                        <h2>Shenyang University Of Technology </h2><br/>
                        Copyright 2015.05-<?=  date("Y") . '.' . date('m')?> SUT ACM/NWS<br/> 
                        Powered By *Chen Lin 保留著作权<br/>
                        Alpha1 build 0001<br/>
                    </div>
                </div>
            </div>
	</div>

	<div region="south" border="false" class="cs-south">©沈阳工业大学ACM实验室</div>
	
	<div id="mm" class="easyui-menu cs-tab-menu">
		<div id="mm-tabupdate">刷新</div>
		<div class="menu-sep"></div>
		<div id="mm-tabclose">关闭</div>
		<div id="mm-tabcloseother">关闭其他</div>
		<div id="mm-tabcloseall">关闭全部</div>
	</div>
    <script>
        $(function(){
            $(".layout-split-proxy-h").css('left', '200px');
        })
    </script>
</body>
</html>