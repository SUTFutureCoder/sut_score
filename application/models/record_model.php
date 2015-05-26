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
    
    /**    
     *  @Purpose:    
     *  获取学生分数记录
     *  @Method Name:
     *  getStudentScoreList($start_term, $student_id)
     *  @Parameter: 
     *  int $start_term 开始学期
     *  int $student_id 学生id
     *  char $mode      模式【'score'/'all'】
     *  @Return: 
     *  0 添加失败
     *  1 添加成功
    */
    public function getStudentScoreList($start_term, $student_id, $mode = 'all'){
        $this->load->database();
        $this->load->model('search_model');
        $class = $this->search_model->getStudentClassId($student_id);
        $data = array();
        if ($mode == 'all'){
            $this->db->select('score_log.score_log_id, score_log.score_log_judge, score_log.score_log_event_tag, score_log.score_type_id,'
                . 'score_log.score_log_add_time, score_log.score_log_event_time, '
                . 'score_log.score_log_event_intro, score_log.score_log_event_certify, '
                . 'score_log.score_log_event_file, score_log.score_log_valid, teacher.teacher_name, score_type.score_type_content');
            $this->db->where('(score_log.class_student_id = "' .$student_id . '" OR score_log.class_student_id = "' . $class . '") AND score_log.score_log_valid = "1"');

            $start_time = $start_term . '-09-01';
            $end_time   = $start_term + 1 . '-08-31';
            $this->db->where('score_log.score_log_event_time >=', $start_time);
            $this->db->where('score_log.score_log_event_time <=', $end_time);

            $this->db->order_by('score_log.score_type_id asc, score_log.score_log_event_time asc');
            $this->db->from('score_log');
            $this->db->join('score_type', 'score_type.score_type_id = score_log.score_type_id');
            $this->db->join('teacher', 'teacher.teacher_id = score_log.teacher_id');

            $result = $this->db->get();
        } else if ($mode = 'score'){
            $this->db->select('score_log_id, score_log_judge, score_type_id');  
            
            $start_time = $start_term . '-09-01';
            $end_time   = $start_term + 1 . '-08-31';
            $this->db->where('score_log_event_time >=', $start_time);
            $this->db->where('score_log_event_time <=', $end_time);
            $this->db->where('(class_student_id = "' . $student_id . '" OR class_student_id = "' . $class . '") AND score_log_valid = "1"');
            $this->db->order_by('score_type_id asc, score_log_event_time asc');
            $result = $this->db->get('score_log');
        }
        foreach ($result->result_array() as $value){
            $data[] = $value;
        }
        return $data;
        
    }
    
    /**    
     *  @Purpose:    
     *  获取记录对应学生id
     *  @Method Name:
     *  getScoreStudent($score_log_id)
     *  @Parameter: 
     *  int $score_log_id 记录id
     * 
     *  @Return: 
     *  0 查询失败
     *  class_student_id 查询成功
    */
    public function getScoreStudent($score_log_id){
        $this->load->database();
        $this->db->select('class_student_id');
        $this->db->where('score_log_id', $score_log_id);
        $result = $this->db->get('score_log');
        if ($result->num_rows()){
            foreach ($result->result_array() as $value){
                return $value['class_student_id'];
            }
        } else {
            return 0;
        }
    }
    
    /**    
     *  @Purpose:    
     *  删除记录
     *  @Method Name:
     *  deleScoreLog($score_log_id)
     *  @Parameter: 
     *  int $score_log_id 记录id
     * 
     *  @Return: 
     *  0 删除失败
     *  1 删除成功
    */
    public function deleScoreLog($score_log_id){
        $this->load->database();
        $this->db->where('score_log_id', $score_log_id);
        $this->db->update('score_log', array('score_log_valid' => 0));
        return $this->db->affected_rows();
    }
}