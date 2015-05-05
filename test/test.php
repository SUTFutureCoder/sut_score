<?php

/**
 * 测试抓取
 * 
 * 
 *
 * @copyright  版权所有(C) 2015-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/
header("Content-Type:text/html; charset=gbk");

$ip=rand(0, 127).'.'.rand(0, 107).'.'.rand(0, 29) . '.' . rand(0, 179);

$ch = curl_init();
$postField = 'FirstYearTermNO=1&EndYearTermNO=14&ClassNO=1204063&xuanze=1';

curl_setopt($ch, CURLOPT_URL, "http://jwc.sut.edu.cn/ACTIONCLASSJDQUERY.APPPROCESS?mode=2&query=1&xuanzelei=总成绩");
curl_setopt($ch, CURLOPT_POST, 1);
$cookie = "JSESSIONID=VHDGeG9HfibVhbWetiI09RmlvPLP1hTsrOY1St0rtdaUr8ry9htq";//设置cookie值，cookie过期则需要重新写入
curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip, 'Cookie:' . $cookie));
curl_setopt($ch, CURLOPT_POSTFIELDS, $postField);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);

$table_pos = mb_strpos($result, '<tr class="color-header">');
$result = mb_substr($result, $table_pos, mb_strpos($result, '</table>') - $table_pos);
$result = str_replace(PHP_EOL, '', strip_tags($result)); 
//$output_array = explode(' ', $result);
//var_dump($output_array);
//var_dump(strip_tags($result));
var_dump($result);