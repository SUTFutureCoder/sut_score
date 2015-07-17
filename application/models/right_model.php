<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 权限模型
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/
class Right_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    
    /**    
     *  @Purpose:    
     *  获取权限列表    
     *  @Method Name:
     *  getRightList($right_id = 0)
     *  @Parameter: 
     *  $right_id  权限id
     *  @Return: 
     *  array $right_list 权限列表
    */
    public function getRightList($right_id = 0){
        $this->load->database();
        if (!$right_id){
            $this->db->where('role_id >=', $right_id);
        }
        $list = array();
        $result = $this->db->get('role');
        foreach ($result->result_array() as $item){
            $list[] = $item;
        }
        return $list;
    }
    
    /**    
     *  @Purpose:    
     *  获取用户权限列表    
     *  @Method Name:
     *  getUserRightList()
     *  @Parameter: 
     *  @Return: 
     *  array(
     *      array(
     *          'role_name' =>
     *          'user_name' =>
     *      )
     * )
    */
    public function getUserRightList(){
        $this->load->database();
        $this->db->select('role.role_name, teacher.teacher_name');
        $this->db->from('re_role_id');
        $this->db->join('teacher', 're_role_id.user_id = teacher.teacher_id');
        $this->db->join('role', 're_role_id.role_id = role.role_id');
        $result = $this->db->get();
        $list = array();
        foreach ($result->result_array() as $list_item){
            $list[] = $list_item;
        }
        
        return $list;
    }
    
    /**    
     *  @Purpose:    
     *  设置用户权限    
     *  @Method Name:
     *  setUserRole($data)
     * 
     *  @Parameter: 
     *  $data   信息数组
     *  @Return: 
     *  0   成功
     *  1   失败
    */
    public function setUserRole($data){
        $this->load->library('session');
        $this->load->database();
        //先查询再修改或添加
        $this->db->where('user_id', $data['user_id']);
        $result = $this->db->get('re_role_id');
        if ($result->num_rows()){
            if (!$data['role_id']){
                $this->db->where('user_id', $data['user_id']);
                $this->db->delete('re_role_id');
                if ($this->db->affected_rows()){
                    $this->db->where('teacher_id', $data['user_id']);
                    $this->db->delete('teacher');
                }
            }
        }
        
        $data['role_auth_id'] = $this->session->userdata('user_id');
        $data['role_auth_time'] = date('Y-m-d H:i:s');
        $this->db->replace('re_role_id', $data);
        
        if ($this->db->affected_rows()){
            $teacher_data = array();
            $teacher_data['teacher_id'] = $data['user_id'];
            $teacher_data['teacher_name'] = $data['user_id'];
            $this->db->replace('teacher', $teacher_data);
            return 1;
        } else {
            return 0;
        }
    }
}