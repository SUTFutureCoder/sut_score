<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| 学校教务处根域名
|--------------------------------------------------------------------------
|
| 例：http://jwc.sut.edu.cn/
|
*/
define('BASE_SCHOOL_URL', 'http://jwc.sut.edu.cn/');

/*
|--------------------------------------------------------------------------
| 基础学期时间id
|--------------------------------------------------------------------------
|
| 例：
 * 1 2008-2009学年第一学期
 * 2 2008-2009学年第二学期
 * 则基础学年为2008.9-2009.7
|
*/
define('BASIC_TERM_ID', '2008');

/*
|--------------------------------------------------------------------------
| 抓取的起始年级
|--------------------------------------------------------------------------
|
| 
|
*/
define('ORIGIN_GRADE', '2010');


/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */