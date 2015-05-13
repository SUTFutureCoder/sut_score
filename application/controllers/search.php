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
     *  获取班级学生列表信息    
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
        
        if (!$this->session->userdata('cookie')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的权限不足或登录信息已过期");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        //cURL请求
        $url = BASE_SCHOOL_URL . 'ACTIONQUERYCLASSSTUDENT.APPPROCESS?mode=2&query=1';
        
        if (!$this->input->post('class_id', TRUE) || !ctype_digit((int)$this->input->post('class_id', TRUE))){
            echo json_encode(array('code' => -2, 'message' => '请选择正确的班级号'));
            return 0;
        } else {
            $clean['ClassNO'] = $this->input->post('class_id', TRUE);
        }
        
        $ch = curl_init();
        $postField = 'ClassNO=' . $clean['ClassNO'];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie:' . $this->session->userdata('cookie')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postField);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = iconv('gb2312', 'utf-8//IGNORE', $result);        
        echo json_encode(array('code' => 1, 'data' => $result));
        return 0;
    }
    
    /**    
     *  @Purpose:    
     *  ajax获取专业列表[数据库]    
     *  @Method Name:
     *  ajaxGetMajorClassList()    
     *  @Parameter: 
     *  POST school_id  学院id
     *  POST major_id   专业id
     *  POST grade_id   年级id
     *  @Return: 
     *  
    */
    public function ajaxGetMajorClassList(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('search_model');
        if (!$this->session->userdata('cookie')){
            json_encode(array('code' => -1, 'message' => '抱歉，您的权限不足或登录信息已过期'));
        }
        
        $class_list = array();
        $class_list = $this->search_model->ajaxGetClassList($this->input->post('school_id', TRUE), $this->input->post('major_id', TRUE), $this->input->post('grade_id', TRUE));
        echo json_encode($class_list);
    }
    
    
    /**    
     *  @Purpose:    
     *  显示班级绩点统计界面    
     *  @Method Name:
     *  showSearchClassPoint()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  
    */
    public function showSearchClassPoint(){
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
        
        $this->load->view('search_class_point_statis_view', array('school_list' => $school_list, 'major_list' => $major_list, 'class_list' => $class_list));
    }
    
    
    /**    
     *  @Purpose:    
     *  获取班级学生绩点统计    
     *  @Method Name:
     *  getClassPointStatis()    
     *  @Parameter: 
     *  POST class  班级id
     * 
     *  @Return: 
     *  
    */
    public function getClassPointStatis(){
        $this->load->library('session');
        $this->load->library('authorizee');
        
        if (!$this->session->userdata('cookie')){
            echo json_encode(array('code' => -1, 'message' => '您的会话数据已过期，请重新登录'));
            return 0;
        }
        
        if (!$this->input->post('term_id', TRUE) || !ctype_digit($this->input->post('term_id', TRUE))){
            echo json_encode(array('code' => -2, 'message' => '请选择正确的起始学期'));
            return 0;
        } else {
            $clean['FirstYearTermNO'] = $this->input->post('term_id', TRUE);
        }
        
        $clean['EndYearTermNO'] = $clean['FirstYearTermNO'] + 1;
        
        //cURL请求
        $url = BASE_SCHOOL_URL . 'ACTIONCLASSJDQUERY.APPPROCESS?mode=2&query=1&xuanzelei=总成绩';
        
        if (!$this->input->post('class_id', TRUE) || !ctype_digit((int)$this->input->post('class_id', TRUE))){
            echo json_encode(array('code' => -2, 'message' => '请选择正确的班级号'));
            return 0;
        } else {
            $clean['ClassNO'] = $this->input->post('class_id', TRUE);
        }
        
        $ch = curl_init();
        $postField = 'FirstYearTermNO=' . $clean['FirstYearTermNO'] . '&EndYearTermNO=' . $clean['EndYearTermNO'] . '&xuanze=1&ClassNO=' . $clean['ClassNO'];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie:' . $this->session->userdata('cookie')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postField);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = iconv('gb2312', 'utf-8//IGNORE', $result);        
        echo json_encode(array('code' => 1, 'data' => $result));
        exit();
    }
    
    
    /**    
     *  @Purpose:    
     *  显示查询学生平均绩点界面    
     *  @Method Name:
     *  showSearchStudentPoint()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  
    */
    public function showSearchStudentPoint(){
        $this->load->library('session');
        $this->load->library('authorizee');
        
//        if (!$this->session->userdata('cookie') || !$this->authorizee->CheckAuthorizee($this->session->userdata('user_role'), 'showSearchStudent')){
        if (!$this->session->userdata('cookie')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的权限不足或登录信息已过期");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        $this->load->view('search_student_point_view');
    }
    
    
    /**    
     *  @Purpose:    
     *  获取学生平均绩点    
     *  @Method Name:
     *  getStudentPoint()    
     *  @Parameter: 
     *  POST student_id  学生id
     * 
     *  @Return: 
     *  
    */
    public function getStudentPoint(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('search_model');
        
        if (!$this->session->userdata('cookie')){
            echo json_encode(array('code' => -2, 'message' => '抱歉，您的权限不足或登录信息已过期'));
            return 0;
        }
        
        if (!$this->input->post('term_id', TRUE) || !ctype_digit($this->input->post('term_id', TRUE))){
            echo json_encode(array('code' => -2, 'message' => '请选择正确的起始学期'));
            return 0;
        } else {
            $clean['YearTermNO'] = $this->input->post('term_id', TRUE);
        }
        
        $clean['EndYearTermNO'] = (int)$clean['YearTermNO'] + 1;
        
        if (!$this->input->post('student_id', TRUE)){
            echo json_encode(array('code' => -2, 'message' => '请输入正确的学号'));
            return 0;
        } else {
            $clean['ByStudentNO'] = $this->input->post('student_id', TRUE);
        }
        
        $class = $this->search_model->getStudentClassId($clean['ByStudentNO']);
        
        if (!$class){
            echo json_encode(array('code' => -3, 'message' => '抱歉，未找到此学生'));
            return 0;
        }
        
        //cURL请求
        $url = BASE_SCHOOL_URL . 'ACTIONCLASSJDQUERY.APPPROCESS?mode=2&query=1&xuanzelei=总成绩';
      
        $ch = curl_init();
        $postField = 'FirstYearTermNO=' . $clean['YearTermNO'] . '&EndYearTermNO=' . $clean['EndYearTermNO'] . '&xuanze=1&ClassNO=' . $class;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie:' . $this->session->userdata('cookie')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postField);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = iconv('gb2312', 'utf-8//IGNORE', $result);
        $result = explode("\n", strip_tags($result));
        
        
        $result_count = count($result) - 14;
        $average_point = array();
        $n = 0;
        
        for ($i = 84; $i < $result_count; $i++, $n++){
            while (trim($result[$i]) == ''){
                $i++;
            }        
            if (trim($result[++$i]) == $clean['ByStudentNO']){
                $i += 6;
                while (trim($result[$i]) == ''){
                    $i++;
                }      
                echo json_encode(array('code' => 1, 'data' => trim($result[$i])));
                return 0;
            } else {
                $i += 7;
                while (trim($result[$i]) == ''){
                    $i++;
                }      
                $i += 5;
            }
        }
        
        echo json_encode(array('code' => -1, 'message' => '抱歉，未能搜索到'));
        return 0;
    }
    
    
    /**    
     *  @Purpose:    
     *  显示查询学生成绩界面    
     *  @Method Name:
     *  showSearchStudentMark()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  
    */
    public function showSearchStudentMark(){
        $this->load->library('session');
        $this->load->library('authorizee');
        
//        if (!$this->session->userdata('cookie') || !$this->authorizee->CheckAuthorizee($this->session->userdata('user_role'), 'showSearchStudent')){
        if (!$this->session->userdata('cookie')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的权限不足或登录信息已过期");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        $this->load->view('search_student_mark_view');
    }
    
    
    /**    
     *  @Purpose:    
     *  获取学生成绩    
     *  @Method Name:
     *  getStudentMark()    
     *  @Parameter: 
     *  POST student_id  学生id
     *  POST term_id     起始学期id
     *  @Return: 
     *  
    */
    public function getStudentMark(){
        $this->load->library('session');
        $this->load->library('authorizee');
        
        if (!$this->session->userdata('cookie')){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的权限不足或登录信息已过期'));
            return 0;
        }
        
        if (!$this->input->post('term_id', TRUE) || !ctype_digit($this->input->post('term_id', TRUE))){
            echo json_encode(array('code' => -2, 'message' => '请选择正确的起始学期'));
            return 0;
        } else {
            $clean['YearTermNO'] = $this->input->post('term_id', TRUE);
        }
        
        $clean['EndYearTermNO'] = (int)$clean['YearTermNO'] + 1;
        
        if (!$this->input->post('student_id', TRUE)){
            echo json_encode(array('code' => -2, 'message' => '请输入正确的学号'));
            return 0;
        } else {
            $clean['ByStudentNO'] = $this->input->post('student_id', TRUE);
        }
        
        //cURL请求
        $url = BASE_SCHOOL_URL . 'ACTIONQUERYSTUDENTSCOREBYSTUDENTNO.APPPROCESS?mode=2';
        
        $ch = curl_init();
        $postField = 'YearTermNO=' . $clean['YearTermNO'] . '&EndYearTermNO=' . $clean['EndYearTermNO'] . '&ByStudentNO=' . $clean['ByStudentNO'];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie:' . $this->session->userdata('cookie')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postField);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = iconv('gb2312', 'utf-8//IGNORE', $result);        
        echo json_encode(array('code' => 1, 'data' => $result));
        return 0;
    }
    
    /**    
     *  @Purpose:    
     *  获取学生班级名称    
     *  @Method Name:
     *  ajaxGetStudentClassName()    
     *  @Parameter: 
     *  POST id  学生/班级id
     * 
     *  @Return: 
     *  
    */
    public function ajaxGetStudentClassName(){
        $this->load->library('session');
        $this->load->model('search_model');
        if (!$this->session->userdata('cookie')){
            echo json_encode(array('code' => -2, 'message' => '抱歉，您的权限不足或登录信息已过期,请重新登录'));
            return 0;
        }
        
        if (!$this->input->post('id', TRUE) || !ctype_digit($this->input->post('id', TRUE))){
            echo json_encode(array('code' => -3, 'message' => '抱歉，请输入正确的id号'));
            return 0;
        }
        
        $data = $this->search_model->ajaxGetStudentClassName($this->input->post('id', TRUE));
        
        echo json_encode(array('code' => 1, 'data' => $data));
        return 0;
    }
}