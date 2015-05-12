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
    
    /**    
     *  @Purpose:    
     *  获取规章制度列表
     *     
     *  @Method Name:
     *  getRuleList($type)
     *  @Parameter: 
     *  char $type d/z/w
     *  @Return: 
     *  array 规章制度项目数组
    */
    public function getRuleList($type){
        $this->load->database();

        $this->db->select('score_type_id, score_type_content');
        $this->db->like('score_type_id', $type, 'after');
        $query = $this->db->get('score_type');
        $rule_array = array();
        foreach ($query->result_array() as $row){
            $rule_array[] = $row;
        }
        
        return $rule_array;
    }
    
    /**    
     *  @Purpose:    
     *  获取规则细节    
     *  @Method Name:
     *  ajajaxGetRuleDetail($score_type_id)  
     *  @Parameter: 
     *  char(7) score_type_id  规则id
     * 
     *  @Return: 
     *  
    */
    public function ajaxGetRuleDetail($score_type_id){
        $this->load->database();
        $this->db->where('score_type_id', $score_type_id);
        $query = $this->db->get('score_type');
        $rule_detail_array = array();
        foreach ($query->result_array() as $row){
            $rule_detail_array[] = $row;
        }
                
        if (isset($rule_detail_array[0]['score_type_content'])){
            $rule_detail_array[0]['score_type_comment'] = nl2br($rule_detail_array[0]['score_type_comment']);
        }
        
        return $rule_detail_array;
    }
    
    /**    
     *  @Purpose:    
     *  添加记录
     *  @Method Name:
     *  setScoreLog($data)
     *  @Parameter: 
     *  array $data 记录数组
     * 
     *  @Return: 
     *  0 添加失败
     *  1 添加成功
    */
    public function setScoreLog($data){
        $this->load->database();
        $this->db->insert('score_log', $data);
        
        return $this->db->affected_rows();
    }
}