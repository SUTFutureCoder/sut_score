<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 用于关于用户的和数据库交互
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/

class User_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  更新教师信息
     *  @Method Name:
     *  updateTeacherInfo($teacher_id, $teacher_name, $teacher_password)
     *  @Parameter: 
     *  string $teacher_id      教师id
     *  string $teacher_name    教师姓名
     *  string $teacher_password教师密码
     * 
     *  @Return: 
     *  1   更新成功
    */
    public function updateTeacherInfo($teacher_id, $teacher_name, $teacher_password){
        $this->load->database();
        try {
            $this->db->replace('teacher', array(
                'teacher_id'    =>  $teacher_id,
                'teacher_name'  =>  $teacher_name,
                'teacher_password' => $teacher_password
            ));
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        
        return 1;
    }
    
    /**    
     *  @Purpose:    
     *  获取数据库教师(用户)信息(包括加密后密码)
     *  @Method Name:
     *  getTeacherInfo($teacher_id)
     *  @Parameter: 
     *  string $teacher_id      教师id
     * 
     *  @Return: 
     *  array(
     *      'teacher_id', 'teacher_name', 'teacher_password'
     *  )
    */
    public function getTeacherInfo($teacher_id){
        $this->load->database();
        $this->db->where('teacher_id', $teacher_id);
        $result = $this->db->get('teacher');
        if ($result->num_rows() > 0){
            return $result->row_array();
        }
        return 0;
    }
}