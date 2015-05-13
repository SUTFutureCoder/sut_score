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
     *  查询记录    
     *  @Method Name:
     *  showGetScoreLog()    
     *  @Parameter: 
     *  @Return: 
     *  
    */
    public function showGetScoreLog(){
        $this->load->library('session');
        $this->load->model('search_model');
        if (!$this->session->userdata('cookie')){
            echo json_encode(array('code' => -2, 'message' => '抱歉，您的权限不足或登录信息已过期,请重新登录'));
            return 0;
        }
        
        $school_list = array();
        $school_list = $this->search_model->getSchoolList();
        
        $major_list = array();
        $major_list = $this->search_model->getMajorList();
        
        $class_list = array();
        $class_list = $this->search_model->getClassList();
        
        $this->load->view('record_score_log_view', array('school_list' => $school_list, 'major_list' => $major_list, 'class_list' => $class_list));
    }
    
    /**    
     *  @Purpose:    
     *  查询学生记录列表    
     *  @Method Name:
     *  getStudentScoreLogList()    
     *  @Parameter: 
     *  POST student_term_id    学年id
     *  POST student_id         学号
     *  @Return: 
     *  
    */
    public function getStudentScoreLogList(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('search_model');
        $this->load->model('record_model');
        
        if (!$this->session->userdata('cookie')){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的权限不足或登录信息已过期'));
            return 0;
        }
        
        if (!$this->input->post('student_term_id', TRUE) || !ctype_digit($this->input->post('student_term_id', TRUE))){
            echo json_encode(array('code' => -2, 'message' => '请选择正确的起始学期'));
            return 0;
        } else {
            $clean['YearTermNO'] = $this->input->post('student_term_id', TRUE);
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
                //记录平均绩点
                $student_point = trim($result[$i]);
                //计算绩点对应智育基础分    60+(x-2.0)/0.2
                $z_basic_score = (60 + ($student_point - 2.0) / 0.2) * 0.7;
                break;
            } else {
                $i += 7;
                while (trim($result[$i]) == ''){
                    $i++;
                }      
                $i += 5;
            }
        }
        
        //还原真实查询起始年份($i - BASIC_TERM_ID) * 2 + 1
        $term_year = ($this->input->post('student_term_id', TRUE) - 1) / 2 + BASIC_TERM_ID;
        $data = $this->record_model->getStudentScoreList($term_year, $clean['ByStudentNO']);
        $data[] = array(
            'score_type_id' => 'z_1_1_1',
            'score_log_judge' => $z_basic_score,
            'score_type_content' => '智育基础分',
            'score_log_add_time' => date('Y-m-d H:i:s'),
            'score_log_event_time' => $term_year . '-' . ($term_year + 1) . '年度',
            'score_log_event_intro' => '',
            'score_log_event_certify' => '教务处',
            'score_log_event_file' => '',
            'score_log_valid' => 1,
            'teacher_name' => '自动获取',
        );
        $sum = 0.000;
        $d_sum = 0.000;
        $z_sum = 0.000;
        $w_sum = 0.000;
        foreach ($data as $item){
            $sum += $item['score_log_judge'];
            switch ($item['score_type_id'][0]){
                case 'd':
                    $d_sum += $item['score_log_judge'];
                    break;
                case 'w':
                    $w_sum += $item['score_log_judge'];
                    break;
                case 'z':
                    $z_sum += $item['score_log_judge'];
                    break;
            }
        }
        
        echo $d_sum;
        echo $w_sum;
        echo $z_sum;
    }
}