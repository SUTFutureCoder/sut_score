<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 安全
 * 负责用户的密钥解密，权限验证，密码验证
 * 
 *
 * @copyright  版权所有(C) 2015-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    0.1
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Secure{
    
    /**    
     *  @Purpose:    
     *  验证传入的时间是否正确   
     *  @Method Name:
     *  CheckDateTime($date_time)
     *  @Parameter: 
     *  $date_time 需要检测的date('Y-m-d H:i:s')时间 
     *  @Return: 
     *      0|不正确
     *      时间戳|正确
    */ 
    public function CheckDateTime($date_time){
        if (!preg_match("/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/",$date_time)){
            return 0;
        } else {
            return strtotime($date_time);            
        }
    }
}