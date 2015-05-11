<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>欢迎使用德智体综合积分测评平台</title>
        <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <br/>        
    <div class="col-sm-10 col-sm-offset-1">
    <?php foreach ($rule as $rule_item): ?>
    <?php if ($rule_item['score_type_id'][0] == 'd'): ?>
    <div class="panel panel-default">
    <?php endif; ?>
    <?php if ($rule_item['score_type_id'][0] == 'z'): ?>
    <div class="panel panel-primary">
    <?php endif; ?>
    <?php if ($rule_item['score_type_id'][0] == 'w'): ?>
    <div class="panel panel-warning">
    <?php endif; ?>
        <div class="panel-heading">
            <h3 class="panel-title"><?= $rule_item['score_type_content'] ?></h3>
        </div>
        <div class="panel-body">
            <?= $rule_item['score_type_comment'] ?>
        </div>
        <?php if ($rule_item['score_mod'] == 'i'): ?>
        <div class="panel-footer" style="color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6;"><?= $rule_item['score_min'] ?>-<?= $rule_item['score_max'] ?></div>
        <?php else:?>
        <div class="panel-footer" style="background-color: #f2dede; color: #a94442; border-color: #ebccd1;"><?= $rule_item['score_min'] ?>-<?= $rule_item['score_max'] ?></div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
    </div>
</body>
</html>