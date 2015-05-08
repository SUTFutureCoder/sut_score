<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 
 * 记录查询
 * 
 *
 * @copyright  版权所有(C) 2015-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/
class Search extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  显示学生信息查询界面    
     *  @Method Name:
     *  showSearchStudent()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  
    */
    public function showSearchStudent(){
        $this->load->library('session');
        $this->load->library('authorizee');
        
//        if (!$this->session->userdata('cookie') || !$this->authorizee->CheckAuthorizee($this->session->userdata('user_role'), 'showSearchStudent')){
        if (!$this->session->userdata('cookie')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的权限不足或登录信息已过期");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        $this->load->view('search_student_view');
    }
    
    /**    
     *  @Purpose:    
     *  获取用户信息    
     *  @Method Name:
     *  getStudentInfo()    
     *  @Parameter: 
     *  POST student_id
     *  @Return: 
     *  
    */
    public function getStudentInfo(){
        $this->load->library('session');
        $this->load->library('authorizee');
               
        
        //cURL请求
        $url = BASE_SCHOOL_URL . 'ACTIONQUERYSTUDENTBYSTUDENTNO.APPPROCESS?mode=2';
        
        if (!$this->input->post('student_id', TRUE) || !ctype_digit($this->input->post('student_id', TRUE))){
            echo json_encode(array('code' => -2, 'message' => '请输入正确的学号'));
            return 0;
        } else {
            $clean['ByStudentNO'] = $this->input->post('student_id', TRUE);
        }
        
        $ch = curl_init();
        $postField = 'ByStudentNO=' . $clean['ByStudentNO'];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie:' . $this->session->userdata('cookie')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postField);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = explode('<form name="" action="" id="" method="post" target="_parent" enctype="multipart/form-data">', $result);
        $result = explode('</form>', $result[1]);
        $result = iconv('gb2312', 'utf-8//IGNORE', $result[0]);
        $result = str_replace('ACTIONQUERYSTUDENTPIC.APPPROCESS?ByStudentNO=', BASE_SCHOOL_URL . 'ACTIONQUERYSTUDENTPIC.APPPROCESS?ByStudentNO=', $result);
        $result = str_replace('<span class="style2">更换照片</span>', ' ', $result);
        
        echo json_encode(array('code' => 1, 'data' => $result));
    }
    
    
    /**    
     *  @Purpose:    
     *  显示班级学生名单信息查询界面    
     *  @Method Name:
     *  showSearchStudent()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  
    */
    public function showSearchStudentList(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('search_model');
//        if (!$this->session->userdata('cookie') || !$this->authorizee->CheckAuthorizee($this->session->userdata('user_role'), 'showSearchStudent')){
        if (!$this->session->userdata('cookie')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的权限不足或登录信息已过期");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        $school_list = array();
        $school_list = $this->search_model->getSchoolList();
        
        $major_list = array();
        $major_list = $this->search_model->getMajorList();
        
        $class_list = array();
        $class_list = $this->search_model->getClassList();
        
        $this->load->view('search_student_list_view', array('school_list' => $school_list, 'major_list' => $major_list, 'class_list' => $class_list));
    }    
    
    
    /**    
     *  @Purpose:    
     *  获取班级学生列表信息[数据库]    
     *  @Method Name:
     *  getStudentList()    
     *  @Parameter: 
     *  POST class  班级id
     * 
     *  @Return: 
     *  
    */
    public function getStudentList(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('search');

    }
    
}