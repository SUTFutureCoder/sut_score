<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 记录相关
 * 
 * 
 *
 * @copyright  版权所有(C) 2015-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/
class Record extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  获取规章制度参考    
     *  @Method Name:
     *  getReference()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  
    */
    public function getReference(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('record_model');
        $this->load->view('record_reference_view', array('rule' => $this->record_model->getRule()));
    }
    
    /**    
     *  @Purpose:    
     *  显示德育录入界面    
     *  @Method Name:
     *  showRecordD()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  
    */
    public function showRecordD(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('record_model');
        $this->load->view('record_view', array('rule_item' => $this->record_model->getRuleList('d')));
    }
    
    /**    
     *  @Purpose:    
     *  显示文体录入界面    
     *  @Method Name:
     *  showRecordW()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  
    */
    public function showRecordW(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('record_model');
        $this->load->view('record_view', array('rule_item' => $this->record_model->getRuleList('w')));
    }
    
    /**    
     *  @Purpose:    
     *  显示智育录入界面    
     *  @Method Name:
     *  showRecordZ()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  
    */
    public function showRecordZ(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('record_model');
        $this->load->view('record_view', array('rule_item' => $this->record_model->getRuleList('z')));
    }
    
    
    /**    
     *  @Purpose:    
     *  获取规则相关    
     *  @Method Name:
     *  ajaxGetRuleReference()    
     *  @Parameter: 
     *  POST score_type_id  规则id
     * 
     *  @Return: 
     *  
    */
    public function ajaxGetRuleReference(){
        $this->load->library('session');
        $this->load->model('record_model');
        if (!$this->session->userdata('cookie')){
            echo json_encode(array('code' => -2, 'message' => '抱歉，您的权限不足或登录信息已过期,请重新登录'));
            return 0;
        }
        
        if (!$this->input->post('score_type_id', TRUE) || ($this->input->post('score_type_id', TRUE) != -1 && strlen($this->input->post('score_type_id', TRUE)) != 7)){
            echo json_encode(array('code' => -3, 'message' => '抱歉，规则id错误'));
            return 0;
        }
        
        $data = array();
        $data = $this->record_model->ajaxGetRuleDetail($this->input->post('score_type_id', TRUE));
        echo json_encode(array('code' => 1, 'data' => $data));
        return 0;
    }
    
    /**    
     *  @Purpose:    
     *  上传证明文件    
     *  @Method Name:
     *  ajaxFileUpload()    
     *  @Parameter: 
     *  POST score_type_id  规则id
     * 
     *  @Return: 
     *  
    */
    public function ajaxFileUpload(){
        $this->load->library('session');
        $this->load->model('record_model');
        header("Content-type: text/html; charset=utf-8");
        if (!$this->session->userdata('cookie')){
            echo '<script>alert("抱歉，您的权限不足或登录信息已过期,请重新登录");window.parent.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
                
        $data = array();
        $file_name = htmlentities($_FILES['file']['name'], ENT_QUOTES);
        $file_ext = strtolower(trim(substr(strrchr($file_name, '.'), 1)));
        $file_name =  rand() . '_' . htmlentities($_FILES['file']['name'], ENT_QUOTES);
        $return_file_name =  date('Ym') . '/' . $file_name;
        $ext_ban_list = array('php', 'sql', 'htm', 'html', 'js', 'css', 'asp', 'jsp', 'aspx', 'sh', 'exe');
        if (in_array($file_ext, $ext_ban_list)){
            echo '<script>alert("抱歉，您的文件拓展名非法");</script>';            
            return 0;
        }
        
        $uploaddir = BASEPATH . '../upload/' . date('Ym') . '/';
        if (!is_dir($uploaddir)){
            mkdir(BASEPATH . '../upload/' . date('Ym') . '/');
        }
        
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . $file_name)) {
            echo <<<FILESUCCESS
            <script>
                alert("文件上传成功");
                window.parent.document.getElementById("certify_file_info").value='$return_file_name';
            </script>
FILESUCCESS;
            return 0;
        } else {
            echo '<script>alert("抱歉，您的文件上传失败");</script>';   
            return 0;
        }
        
        switch ($_FILES['file']['error']){
            case '1':
                echo '<script>alert("抱歉，您的文件大小超过服务器限制[' .  ini_get('upload_max_filesize') . ']");</script>';   
                return 0;
                break;
            case '2':
                echo '<script>alert("抱歉，您的文件大小超过表单限制");</script>';   
                return 0;
                break;
            case '3':
                echo '<script>alert("抱歉，您的文件只有部分被上传");</script>';   
                return 0;
                break;
            case '4':
                echo '<script>alert("抱歉，您的文件没有被上传");</script>';   
                return 0;
                break;
            case '6':
                echo '<script>alert("抱歉，无法找到临时文件夹");</script>';   
                return 0;
                break;
            case '7':
                echo '<script>alert("抱歉，文件写入失败");</script>';   
                return 0;
                break;
        }
        
        echo json_encode(array('code' => 1, 'data' => $_FILES['file']));
        return 0;
    }
    
    
    /**    
     *  @Purpose:    
     *  添加记录    
     *  @Method Name:
     *  setScoreLog()    
     *  @Parameter: 
     *  POST class_student_id           班级或学生id
     *  POST score_type_id              项目id
     *  POST score_mod                  + / -
     *  POST score_log_judge            分数
     *  POST score_log_event_time       项目发生时间
     *  POST score_log_event_tag        项目标签
     *  POST score_log_event_intro      项目介绍
     *  POST score_log_event_certify    项目证明单位
     *  POST score_log_event_file       项目证明文件路径
     * 
     *  @Return: 
     *  
    */
    public function setScoreLog(){
        $this->load->library('session');
        $this->load->model('record_model');
        if (!$this->session->userdata('cookie')){
            echo json_encode(array('code' => -2, 'message' => '抱歉，您的权限不足或登录信息已过期,请重新登录'));
            return 0;
        }
        $data = array();
        
        if (!$this->input->post('class_student_id', TRUE) || !ctype_digit($this->input->post('class_student_id', TRUE)) || strlen($this->input->post('class_student_id', TRUE)) > 9){
            echo json_encode(array('code' => -3, 'message' => '班级或学生id必须为数字', 'id' => 'student_class_id'));
            return 0;
        } else {
            $data['class_student_id'] = $this->input->post('class_student_id', TRUE);
        }
        
        if (!$this->input->post('score_type_id', TRUE) || strlen($this->input->post('score_type_id', TRUE)) > 8){
            echo json_encode(array('code' => -3, 'message' => '请选择正确的项目', 'id' => 'rule_item'));
            return 0;
        } else {
            $data['score_type_id'] = $this->input->post('score_type_id', TRUE);
        }
        
        if (!$this->input->post('score_log_judge', TRUE) || !is_numeric($this->input->post('score_log_judge', TRUE))){
            echo json_encode(array('code' => -3, 'message' => '请选择数字分数', 'id' => 'score_judge'));
            return 0;
        } else {
            $data['score_log_judge'] = (float)$this->input->post('score_log_judge', TRUE) * (int)(($this->input->post('score_mod', TRUE)) . 1);
        }
        
        if (!$this->input->post('score_log_event_time', TRUE) || !preg_match('/\d\d\d\d-[0-1]?[1-9]-[0-3]?[0-9]/', $this->input->post('score_log_event_time', TRUE))){
            echo json_encode(array('code' => -3, 'message' => '请输入正确的时间，例：2015-05-12', 'id' => 'event_time'));
            return 0;
        } else {
            $data['score_log_event_time'] = $this->input->post('score_log_event_time', TRUE);
        }
        
        if (!$this->input->post('score_log_event_tag', TRUE) || mb_strlen($this->input->post('score_log_event_tag', TRUE)) > 40){
            echo json_encode(array('code' => -3, 'message' => '标签不能为空或超过40个字符', 'id' => 'event_tag'));
            return 0;
        } else {
            $data['score_log_event_tag'] = $this->input->post('score_log_event_tag', TRUE);
        }
        
        if (!$this->input->post('score_log_event_intro', TRUE) || mb_strlen($this->input->post('score_log_event_intro', TRUE)) > 500){
            echo json_encode(array('code' => -3, 'message' => '说明不能为空或超过500个字符', 'id' => 'event_intro'));
            return 0;
        } else {
            $data['score_log_event_intro'] = $this->input->post('score_log_event_intro', TRUE);
        }
            
        if (!$this->input->post('score_log_event_certify', TRUE) || mb_strlen($this->input->post('score_log_event_certify', TRUE)) > 40){
            echo json_encode(array('code' => -3, 'message' => '证明人不能为空或超过40个字符', 'id' => 'event_certify'));
            return 0;
        } else {
            $data['score_log_event_certify'] = $this->input->post('score_log_event_certify', TRUE);
        }
        
        if ($this->input->post('score_log_event_file', TRUE) && mb_strlen($this->input->post('score_log_event_file', TRUE)) > 100){
            echo json_encode(array('code' => -3, 'message' => '请您精简文件名到80个字符以内', 'id' => 'certify_file_info'));
            return 0;
        } else {
            $data['score_log_event_file'] = $this->input->post('score_log_event_file', TRUE);
        }
        
        //添加额外信息
        $data['score_log_add_time'] = date('Y-m-d H:i:s');
        $data['teacher_id'] = $this->session->userdata('user_id');
        
        if ($this->record_model->setScoreLog($data)){
            echo json_encode(array('code' => 1));
            return 0;
        } else {
            echo json_encode(array('code' => 2, 'message' => '插入数据失败，请联系管理员'));
            return 0;   
        }
        
        
    }
}