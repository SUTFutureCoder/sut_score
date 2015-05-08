<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 记录相关数据库交互
 * 
 * 
 *
 * @copyright  版权所有(C) 2015-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/
class Record_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  获取规章制度
     *     
     *  @Method Name:
     *  getRule
     *  @Parameter: 
     * 
     *  @Return: 
     *  array 规章制度数组
    */
    public function getRule(){
        $this->load->database();
        $query = $this->db->get('score_type');
        $rule_array = array();
        foreach ($query->result_array() as $row){
            $rule_array[] = $row;
        }
        return $rule_array;
    }
}