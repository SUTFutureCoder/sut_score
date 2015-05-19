<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 
 * 权限操作
 * 
 *
 * @copyright  版权所有(C) 2014-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/
class Authorizee{
    static private $_ci;


    /**    
     *  @Purpose:    
     *  检查权限   
     *  @Method Name:
     *  checkAuthorizee($user_id, $right_name)    
     *  @Parameter: 
     *  $user_id    用户角色
     *  $right_name 权限名字
     *  @Return: 
     *  1 成功
     *  0 失败
    */ 
    public function checkAuthorizee($user_id, $right_name){
        if (!self::$_ci){
            //在自定义类库中初始化CI资源
            self::$_ci =& get_instance();       
        }
        
        self::$_ci->load->database();
        self::$_ci->db->where('re_role_id.user_id', $user_id);
        self::$_ci->db->where('role.role_index', $right_name);
        self::$_ci->db->from('re_role_id');
        self::$_ci->db->join('role', 're_role_id.role_id = role.role_id');
        $result = self::$_ci->db->get();
        
        return $result->num_rows();
    }
}