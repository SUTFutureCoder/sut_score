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
     *  right_id 成功&id
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
        
        if ($result->num_rows()){
            foreach ($result->result_array() as $item){
                return $item['role_id'];
            }
        } else {
            return 0;
        }
        
    }

    /**    
     *  @Purpose:    
     *  获取用户权限id
     *    
     *  @Method Name:
     *  getAuthorizeeId($user_id)    
     *  @Parameter: 
     *  $user_id    用户角色
     *  @Return: 
     *  right_id 成功&id
     *  0 失败
    */ 
    public function getAuthorizeeId($user_id){
        if (!self::$_ci){
            //在自定义类库中初始化CI资源
            self::$_ci =& get_instance();       
        }
        
        self::$_ci->load->database();
        self::$_ci->db->select('role_id');
        self::$_ci->db->where('user_id', $user_id);
        $result = self::$_ci->db->get('re_role_id');
        if ($result->num_rows()){
            foreach ($result->result_array() as $item){
                return $item['role_id'];
            }
        } else {
            return 0;
        }
    }

    /**    
     *  @Purpose:    
     *  获取用户权限id
     *    
     *  @Method Name:
     *  getRoleId($role_index)
     *  @Parameter: 
     *  $role_index    角色索引
     *  @Return: 
     *  right_id 成功&id
     *  0 失败
    */ 
    public function getRoleId($role_index){
        if (!self::$_ci){
            //在自定义类库中初始化CI资源
            self::$_ci =& get_instance();       
        }
        
        self::$_ci->load->database();
        self::$_ci->db->select('role_id');
        self::$_ci->db->where('role_index', $role_index);
        $result = self::$_ci->db->get('role');
        if ($result->num_rows()){
            foreach ($result->result_array() as $item){
                return $item['role_id'];
            }
        } else {
            return 0;
        }
    }
}