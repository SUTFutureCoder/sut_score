<?php

/**
 * 测试登录
 * 
 * 
 *
 * @copyright  版权所有(C) 2015-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/

header('Content-Type: text/html; charset=utf-8');

$cookieJar = dirname(__FILE__) . '/pic.cookie';

$url = 'http://jwc.sut.edu.cn/ACTIONLOGON.APPPROCESS?mode=4';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
$content = curl_exec($ch);
curl_close($ch);