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
    
}