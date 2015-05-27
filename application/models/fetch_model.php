<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 抓取相关
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/
class Fetch_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  更新学院、专业、班级信息数据库数据
     *     
     *  @Method Name:
     *  updateSchoolMajorClass($school_data, $major_data, $class_data)    
     *  @Parameter: 
     *  array $school_data 学院信息
     *  array $major_data  专业信息
     *  array $class_data  班级信息 
     * 
     *  @Return: 
     *  array 更新失败或其他错误
     *  bool 1 更新成功
    */
    public function updateSchoolMajorClass($school_data, $major_data, $class_data){
        $this->load->database();
        
        $this->db->empty_table('school_info');
        $this->db->empty_table('major_info');
        
        try{
            $school_key = array('school_id', 'school_name');
            foreach ($school_data as $school_value){
                $this->db->insert('school_info', array_combine($school_key, array_values($school_value)));
            }

            $major_key = array('major_id', 'major_name');
            foreach ($major_data as $major_value){
                $this->db->insert('major_info', array_combine($major_key, array_values($major_value)));
            }

            $class_key = array('class_id', 'class_name');
            foreach ($class_data as $class_value){
                $this->db->replace('class_info', array_combine($class_key, array_values($class_value)));
            }
        } catch (Exception $ex) {
            return array('error' => $ex->getMessage());
        }
    }
    
    /**    
     *  @Purpose:    
     *  
     *     
     *  @Method Name:
     *  fetchStudentList($student_data)    
     *  @Parameter: 
     *  array $student_data  学生信息
     * 
     *  @Return: 
     *  array 更新失败或其他错误
     *  bool 1 更新成功
    */
    public function fetchStudentList($student_data){
        $this->load->database();
        
        try{
            foreach ($student_data as $student_item){
                $this->db->replace('student', $student_item);
            }
        } catch (Exception $ex) {
            return array('error' => $ex->getMessage());
        }
    }
}