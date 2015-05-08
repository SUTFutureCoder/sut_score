<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 搜索和数据库交互部分
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/
class Search_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  获取学院列表    
     *  @Method Name:
     *  getSchoolList()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  array $data 学院数据
    */
    public function getSchoolList(){
        $this->load->database();
        $result = $this->db->get('school_info');
        $data = array();
        foreach ($result->result_array() as $value){
            $data[] = $value;
        }
        return $data;
    }
    
    /**    
     *  @Purpose:    
     *  获取专业列表    
     *  @Method Name:
     *  getMajorList($school_id = '00')
     *  @Parameter: 
     *  char $school_id 学院id【默认全抓】
     *  @Return: 
     *  array $data 专业数据
    */
    public function getMajorList($school_id = '00'){
        $this->load->database();
        if ($school_id != '00'){
            $this->db->where('major_id', $school_id, 'after');
        }
        $result = $this->db->get('major_info');
        $data = array();
        foreach ($result->result_array() as $value){
            $data[] = $value;
        }
        return $data;
    }
    
    /**    
     *  @Purpose:    
     *  获取班级列表    
     *  @Method Name:
     *  getClassList($major_id = '0000', $grade = '0')
     *  @Parameter: 
     *  char $major_id 专业id前四位【默认全抓】
     *  char $grade 年级【默认全抓】
     *  @Return: 
     *  array $data 班级数据
    */
    public function getClassList($major_id = '0000', $grade = '00'){
        $this->load->database();
        if ($major_id != '0000'){
            if ($grade != '0'){
                $this->db->where('class_id', $grade . $school_id, 'after');
            } else {
                $this->db->where('class_id', '__' . $school_id, 'after');
            }
        }
        $result = $this->db->get('class_info');
        $data = array();
        foreach ($result->result_array() as $value){
            $data[] = $value;
        }
        return $data;
    }
}