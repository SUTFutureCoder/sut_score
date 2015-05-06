<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 连接memcache
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/

class Cache{
    static private $_mc;
    
    static public function memcache(){
        if (self::$_mc){
            return self::$_mc;
        } else {
            self::$_mc = new Memcached();  
            self::$_mc->addServer('127.0.0.1', 11211);
            return self::$_mc;
        }
    }    
}