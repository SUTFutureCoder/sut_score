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
        if (!in_array($this->session->userdata('role_index'), array('god', 'admin', 'write_all', 'write_person'))){
            echo '<script>alert("抱歉，您的权限不足");</script>';            
            return 0;
        }
        
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，登录信息已过期");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        $this->load->view('record_view', array('rule_item' => $this->record_model->getRuleList('d'), 'role_index' => $this->session->userdata('role_index'),
            'user_id' => $this->session->userdata('user_id')));
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
        if (!in_array($this->session->userdata('role_index'), array('god', 'admin', 'write_all', 'write_person'))){
            echo '<script>alert("抱歉，您的权限不足");</script>';            
            return 0;
        }
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的权限不足或登录信息已过期");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        $this->load->view('record_view', array('rule_item' => $this->record_model->getRuleList('w'), 'role_index' => $this->session->userdata('role_index'),
            'user_id' => $this->session->userdata('user_id')));
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
        if (!in_array($this->session->userdata('role_index'), array('god', 'admin', 'write_all', 'write_person'))){
            echo '<script>alert("抱歉，您的权限不足");</script>';            
            return 0;
        }
        
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的权限不足或登录信息已过期");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        $this->load->view('record_view', array('rule_item' => $this->record_model->getRuleList('z'), 'role_index' => $this->session->userdata('role_index'),
            'user_id' => $this->session->userdata('user_id')));
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
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
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
        if (!in_array($this->session->userdata('role_index'), array('god', 'admin', 'write_all', 'write_person'))){
            echo '<script>alert("抱歉，您的权限不足");</script>';            
            return 0;
        }
        
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
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
        
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的登录信息已过期");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        $school_list = array();
        $school_list = $this->search_model->getSchoolList();
        
        $major_list = array();
        $major_list = $this->search_model->getMajorList();
        
        $class_list = array();
        $class_list = $this->search_model->getClassList();
        
        $this->load->view('record_score_log_view', array('school_list' => $school_list, 
            'major_list' => $major_list, 'class_list' => $class_list, 
            'role_index' => $this->session->userdata('role_index'), 'user_id' => $this->session->userdata('user_id')));
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
        
        if (strlen($this->session->userdata('user_id')) != 5){
            echo json_encode(array('code' => -1, 'message' => '抱歉您的权限不足'));
            return 0;
        }
        
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
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
        
        if (!$this->input->post('student_id', TRUE) || !ctype_digit($this->input->post('student_id', TRUE))){
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
        
        $data = $this->getStudentScore($clean['YearTermNO'], $class, $clean['ByStudentNO']);
        
        echo json_encode(array('code' => 1, 'data' => $data));
        return 0;
    }
    
    
    /**    
     *  @Purpose:    
     *  查询班级记录列表    
     *  @Method Name:
     *  getClassScoreLogList()    
     *  @Parameter: 
     *  POST student_term_id    学年id
     *  POST class_id           班级id
     *  @Return: 
     *  
    */
    public function getClassScoreLogList(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('search_model');
        $this->load->model('record_model');
        
        if (strlen($this->session->userdata('user_id')) != 5){
            echo json_encode(array('code' => -1, 'message' => '抱歉您的权限不足'));
            return 0;
        }
        
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的权限不足或登录信息已过期'));
            return 0;
        }
        
        if (!$this->input->post('class_term_id', TRUE) || !ctype_digit($this->input->post('class_term_id', TRUE))){
            echo json_encode(array('code' => -2, 'message' => '请选择正确的起始学期'));
            return 0;
        } else {
            $clean['YearTermNO'] = $this->input->post('class_term_id', TRUE);
        }
        
        if (!$this->input->post('class_id', TRUE) || !ctype_digit($this->input->post('class_id', TRUE))){
            echo json_encode(array('code' => -2, 'message' => '请输入正确的班级id'));
            return 0;
        } else {
           $class = $this->input->post('class_id', TRUE);
        }
        
        $data = $this->getClassScore($clean['YearTermNO'], $class, 'score');
        echo json_encode(array('code' => 1, 'data' => $data));
        return 0;
    }
    
    /**    
     *  @Purpose:    
     *  获取学生积分
      * 
     *  @Method Name:
     *  getStudentScore($year_term_no, $class, $student_no)
     *  @Parameter: 
     *  int $year_term_no   起始学期id
     *  int $class          班级id
     *  int $student_no     学生id
     * 
     *  @Return: 
     *  array $data         积分明细
    */ 
    private function getStudentScore($year_term_no, $class, $student_no){
        $this->load->library('session');
        $this->load->model('record_model');
        
        if ($this->session->userdata('online')){
            $end_year_term_no = $year_term_no + 1;
        
        
        //cURL请求
        $url = BASE_SCHOOL_URL . 'ACTIONCLASSJDQUERY.APPPROCESS?mode=2&query=1&xuanzelei=总成绩';
        
        $ch = curl_init();
        $postField = 'FirstYearTermNO=' . $year_term_no . '&EndYearTermNO=' . $end_year_term_no . '&xuanze=1&ClassNO=' . $class;
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
            if (trim($result[++$i]) == $student_no){
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
        } else {
            
        }
        
        
        //还原真实查询起始年份($i - BASIC_TERM_ID) * 2 + 1
        $term_year = ($year_term_no - 1) / 2 + BASIC_TERM_ID;
        $data['data'] = $this->record_model->getStudentScoreList($term_year, $student_no);
        array_unshift($data['data'], array(
            'score_type_id' => 'z_1_1_1',
            'score_log_judge' => $z_basic_score,
            'score_type_content' => '智育基础分',
            'score_log_add_time' => date('Y-m-d H:i:s'),
            'score_log_event_time' => $term_year . '-' . ($term_year + 1) . '年度',
            'score_log_event_intro' => '',
            'score_log_event_certify' => '教务处',
            'score_log_event_file' => '',
            'score_log_valid' => 1,
            'score_log_event_tag' => '',
            'teacher_name' => '自动获取',
        ));
        
        $data['score']['sum'] = 0.000;
        $data['score']['d_sum'] = 0.000;
        $data['score']['z_sum'] = 0.000;
        $data['score']['w_sum'] = 0.000;
        
        $flag_d_2_2_1 = 0;
        $flag_d_2_2_2 = 0;
        foreach ($data['data'] as $key => $item){
            //进行同项高计
            if ($item['score_type_id'] == 'd_2_2_1' && !$flag_d_2_2_1){
                $flag_d_2_2_1 = 1;
            }
            
            if ($item['score_type_id'] == 'd_2_2_2' && !$flag_d_2_2_2){
                $flag_d_2_2_2 = 1;
            }
            
            if ($item['score_type_id'] == 'd_2_2_2' && $flag_d_2_2_1){
                $data['data'][$key]['score_log_judge'] = 0;
                continue;
            }
            
            if ($item['score_type_id'] == 'd_2_2_1' && $flag_d_2_2_2){
                $data['data'][$key]['score_log_judge'] = 0;
                continue;
            }

            switch ($item['score_type_id'][0]){
                case 'd':
                    $data['score']['d_sum'] += $item['score_log_judge'];
                    break;
                case 'w':
                    $data['score']['w_sum'] += $item['score_log_judge'];
                    break;
                case 'z':
                    $data['score']['z_sum'] += $item['score_log_judge'];
                    break;
            }
        }
        
        if ($data['score']['d_sum'] >= 20){
            $data['score']['d_sum'] = 20;
        }
        
        if ($data['score']['w_sum'] >= 10){
            $data['score']['w_sum'] = 10;
        }
        
        if ($data['score']['z_sum'] >= 70){
            $data['score']['z_sum'] = 70;
        }
        
        $data['score']['sum'] = $data['score']['d_sum'] + $data['score']['w_sum'] + $data['score']['z_sum'];
        
        return $data;
    }

    
    /**    
     *  @Purpose:    
     *  获取班级积分
      * 
     *  @Method Name:
     *  getClassScore($year_term_no, $class)
     *  @Parameter: 
     *  int $year_term_no   起始学期id
     *  int $class          班级id
     *  char $mode          模式【score/all】
     *  @Return: 
     *  array $data         积分明细
    */ 
    private function getClassScore($year_term_no, $class, $mode = 'score'){
        $this->load->library('session');
        $this->load->model('record_model');
        $end_year_term_no = $year_term_no + 1;
        
        //cURL请求
        $url = BASE_SCHOOL_URL . 'ACTIONCLASSJDQUERY.APPPROCESS?mode=2&query=1&xuanzelei=总成绩';
        
        $ch = curl_init();
        $postField = 'FirstYearTermNO=' . $year_term_no . '&EndYearTermNO=' . $end_year_term_no . '&xuanze=1&ClassNO=' . $class;
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
            $average_point[$n]['student_id'] = trim($result[++$i]);
            $average_point[$n]['student_name'] = trim($result[++$i]);
            $i += 5;
            while (trim($result[$i]) == ''){
                $i++;
            }      
            $average_point[$n]['average_point'] = trim($result[$i]);
            //计算绩点对应智育基础分    60+(x-2.0)/0.2
            $average_point[$n]['z_basic_score'] = (60 + ($average_point[$n]['average_point'] - 2.0) / 0.2) * 0.7;
            $i += 5;
        }
        
        $data = array();
        //还原真实查询起始年份($i - BASIC_TERM_ID) * 2 + 1
        $term_year = ($year_term_no - 1) / 2 + BASIC_TERM_ID;
        foreach ($average_point as $average_point_item){
            $data[$average_point_item['student_id']]['name'] = $average_point_item['student_name'];
            $data[$average_point_item['student_id']]['data'] = $this->record_model->getStudentScoreList($term_year, $average_point_item['student_id'], $mode);
            if ($mode == 'all'){
                array_unshift($data[$average_point_item['student_id']]['data'], array(
                    'score_type_id' => 'z_1_1_1',
                    'score_log_judge' => $average_point_item['z_basic_score'],
                    'score_type_content' => '智育基础分',
                    'score_log_add_time' => date('Y-m-d H:i:s'),
                    'score_log_event_time' => $term_year . '-' . ($term_year + 1) . '年度',
                    'score_log_event_intro' => '',
                    'score_log_event_certify' => '教务处',
                    'score_log_event_file' => '',
                    'score_log_valid' => 1,
                    'score_log_event_tag' => '',
                    'teacher_name' => '自动获取',
                ));
                
            } else if($mode == 'score'){
                array_unshift($data[$average_point_item['student_id']]['data'], array(
                    'score_log_judge' => $average_point_item['z_basic_score'],
                    'score_type_id' => 'z_1_1_1'
                ));
            }
 
            $data[$average_point_item['student_id']]['score']['sum'] = 0.000;
            $data[$average_point_item['student_id']]['score']['d_sum'] = 0.000;
            $data[$average_point_item['student_id']]['score']['z_sum'] = 0.000;
            $data[$average_point_item['student_id']]['score']['w_sum'] = 0.000;
            $flag_d_2_2_1 = 0;
            $flag_d_2_2_2 = 0;
            foreach ($data[$average_point_item['student_id']]['data'] as $key => $item){
                //进行同项高计
                if ($item['score_type_id'] == 'd_2_2_1' && !$flag_d_2_2_1){
                    $flag_d_2_2_1 = 1;
                }
                
                if ($item['score_type_id'] == 'd_2_2_2' && !$flag_d_2_2_2){
                    $flag_d_2_2_2 = 1;
                }

                if ($item['score_type_id'] == 'd_2_2_1' && $flag_d_2_2_2){
                    $data[$average_point_item['student_id']]['data'][$key]['score_log_judge'] = 0;
                    continue;
                }

                if ($item['score_type_id'] == 'd_2_2_2' && $flag_d_2_2_1){
                    $data[$average_point_item['student_id']]['data'][$key]['score_log_judge'] = 0;
                    continue;
                }
                
                switch ($item['score_type_id'][0]){
                    case 'd':
                        $data[$average_point_item['student_id']]['score']['d_sum'] += $item['score_log_judge'];
                        break;
                    case 'w':
                        $data[$average_point_item['student_id']]['score']['w_sum'] += $item['score_log_judge'];
                        break;
                    case 'z':
                        $data[$average_point_item['student_id']]['score']['z_sum'] += $item['score_log_judge'];
                        break;
                }
            }

            if ($data[$average_point_item['student_id']]['score']['d_sum'] >= 20){
                $data[$average_point_item['student_id']]['score']['d_sum'] = 20;
            }

            if ($data[$average_point_item['student_id']]['score']['w_sum'] >= 10){
                $data[$average_point_item['student_id']]['score']['w_sum'] = 10;
            }

            if ($data[$average_point_item['student_id']]['score']['z_sum'] >= 70){
                $data[$average_point_item['student_id']]['score']['z_sum'] = 70;
            }

            $data[$average_point_item['student_id']]['score']['sum'] = $data[$average_point_item['student_id']]['score']['d_sum'] + $data[$average_point_item['student_id']]['score']['w_sum'] + $data[$average_point_item['student_id']]['score']['z_sum'];
        }
        return $data;
    }


    /**    
     *  @Purpose:    
     *  生成学生积分列表表格
      * 
     *  @Method Name:
     *  getStudentScoreExcel()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  $student_info['school_name'] . '-' . $student_info['class_name'] . '-' . $clean['ByStudentNO'] . '-' . $term_year . '-' . ($term_year + 1) . '年度德智体综合积分明细.xls';
    */        
    public function getStudentScoreExcel(){
        $this->load->library('session');
        $this->load->library('PHPExcel');
        $this->load->model('search_model');
        
        if (strlen($this->session->userdata('user_id')) != 5){
            echo '<script>alert("抱歉，抱歉您的权限不足");</script>';
            return 0;
        }
        
        $excel = new PHPExcel();
        $clean = array();
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
            echo '<script>alert("抱歉，您的登录信息已过期,请重新登录");window.parent.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        if (!$this->input->get('student_term_id', TRUE) || !ctype_digit($this->input->get('student_term_id', TRUE))){
            echo '<script>alert("请选择正确的起始学期");</script>';            
            return 0;
        } else {
            $clean['YearTermNO'] = $this->input->get('student_term_id', TRUE);
        }
        
        $term_year = ($clean['YearTermNO'] - 1) / 2 + BASIC_TERM_ID;
        
        if (!$this->input->get('student_id', TRUE) || !ctype_digit($this->input->get('student_id', TRUE))){
            echo '<script>alert("请输入正确的学号");</script>';            
            return 0;
        } else {
            $clean['ByStudentNO'] = $this->input->get('student_id', TRUE);
        }
        
        $student_info = $this->search_model->getStudentInfo($clean['ByStudentNO']);
        
        if (!$student_info){
            echo '<script>alert("抱歉，未找到此学生");</script>';            
            return 0;
        }
        
        $data = $this->getStudentScore($clean['YearTermNO'], $student_info['student_class'], $clean['ByStudentNO']);
        
        $objPHPExcel = new PHPExcel();
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);     
        
        $clean['file_name'] = $student_info['school_name'] . '-' . $student_info['class_name'] . '-' . $clean['ByStudentNO'] . '-' . $term_year . '-' . ($term_year + 1) . '年度德智体综合积分明细.xls';
    
        
        $objPHPExcel->getProperties()->setCreator('SUTACM *Chen Lin')
            ->setTitle($student_info['school_name'] . '-' . $student_info['class_name'] . '-' . $clean['ByStudentNO'] . '-' . $term_year . '-' . ($term_year + 1) . '年度德智体综合积分明细');

        $objPHPExcel->getActiveSheet()->setCellValue('A1', '姓名');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $student_info['student_name']);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '学院');
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('D1', $student_info['school_name']);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '班级');
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('F1', $student_info['class_name']);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '生成时间');
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('H1', date('Y-m-d H:i:s'));
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A2', '序号');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('B2', '项目');
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('C2', '分数');
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('D2', '标签');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('E2', '说明');
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('F2', '时间');
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('G2', '证明人');
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
        
        
        $objPHPExcel->getActiveSheet()->setCellValue('H2', '审核章');
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
        
        $i = 3;
        foreach ($data['data'] as $data_item){
            //第一列
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ($i - 2));
            
            //第二列
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data_item['score_type_content']);
            
            //第三列
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $data_item['score_log_judge']);
            
            //第四列
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $data_item['score_log_event_tag']);
            
            //第五列
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $data_item['score_log_event_intro']);
            
            //第六列
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $data_item['score_log_event_time']);
            
            //第七列
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $data_item['teacher_name']);
            
            //设置高度
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);
            
            //居中
            $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            ++$i;
        }
        
        ++$i;
        
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '总分');
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data['score']['sum']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, '德育');
        if ($data['score']['d_sum'] >= 12){
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $data['score']['d_sum']);
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $data['score']['d_sum'] . '【无评优资格】');
        }
        
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '文体');
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $data['score']['w_sum']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, '智育');
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $data['score']['z_sum']);
        
        //居中
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

        
        
        header("Content-Type: application/force-download");  
        header("Content-Type: application/octet-stream");  
        header("Content-Type: application/download");  
        header('Content-Disposition:inline;filename="' . $clean['file_name'] . '"');  
        header("Content-Transfer-Encoding: binary");  
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
        header("Pragma: no-cache");  
        $objWriter->save('php://output');
        
    }
    

    /**    
     *  @Purpose:    
     *  生成班级积分列表/统计表格
      * 
     *  @Method Name:
     *  getClassScoreExcel()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  $class_info['school_name'] . '-' . $class_info['class_name'] . '-' . $term_year . '-' . ($term_year + 1) . '年度德智体综合积分明细.xls';
    */        
    public function getClassScoreExcel(){
        $this->load->library('session');
        $this->load->library('PHPExcel');
        $this->load->model('search_model');
        if (strlen($this->session->userdata('user_id')) != 5){
            echo '<script>alert("抱歉，抱歉您的权限不足");</script>';
            return 0;
        }
        
        $excel = new PHPExcel();
        $clean = array();
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
            echo '<script>alert("抱歉，您的登录信息已过期,请重新登录");window.parent.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        if (!$this->input->get('class_term_id', TRUE) || !ctype_digit($this->input->get('class_term_id', TRUE))){
            echo '<script>alert("请选择正确的起始学期");</script>';            
            return 0;
        } else {
            $clean['YearTermNO'] = $this->input->get('class_term_id', TRUE);
        }
//        $clean['YearTermNO'] = '13';
        $term_year = ($clean['YearTermNO'] - 1) / 2 + BASIC_TERM_ID;
        
        if (!$this->input->get('class_id', TRUE) || !ctype_digit($this->input->get('class_id', TRUE))){
            echo '<script>alert("请输入正确的班级id");</script>';            
            return 0;
        } else {
            $clean['class_id'] = $this->input->get('class_id', TRUE);
        }
        
//        $clean['class_id'] = '1204063';
        if (!$class_info = $this->search_model->getClassInfo($clean['class_id'])){
            echo '<script>alert("抱歉，未找到此班级");</script>';            
            return 0;
        }
        
        $data = $this->getClassScore($clean['YearTermNO'], $clean['class_id'], 'all');
        
        $objPHPExcel = new PHPExcel();
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);     
        
        $clean['file_name'] = $class_info['school_name'] . '-' . $class_info['class_name'] . '-' . $term_year . '-' . ($term_year + 1) . '年度德智体综合积分明细.xls';
        
        $objPHPExcel->getProperties()->setCreator('SUTACM *Chen Lin')
            ->setTitle($class_info['school_name'] . '-' . $class_info['class_name'] . '-' . $term_year . '-' . ($term_year + 1) . '年度德智体综合积分明细');

        
        $objPHPExcel->createSheet(0);
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('明细表');
        
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '学院');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $class_info['school_name']);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '班级');
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('D1', $class_info['class_name']);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '生成时间');
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('F1', date('Y-m-d H:i:s'));
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
        
        $objPHPExcel->getActiveSheet()->setCellValue('A2', '序号');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('B2', '学号');
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('C2', '姓名');
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('D2', '项目');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('E2', '分数');
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('F2', '标签');
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('G2', '说明');
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('H2', '时间');
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('I2', '证明人');
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
        
        
        $objPHPExcel->getActiveSheet()->setCellValue('J2', '审核章');
        $objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);

        $i = 3;
        $score_array = array();
        foreach ($data as $data_key => $data_item){
            $score_array[$data_key]['score'] = $data_item['score'];
            $score_array[$data_key]['name'] = $data_item['name'];
            foreach ($data_item['data'] as $data_data_item){
                //第一列
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ($i - 2));

                //第二列
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $data_key);

                //第三列
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $data_item['name']);

                //第四列
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $data_data_item['score_type_content']);

                //第五列
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $data_data_item['score_log_judge']);
                
                //第六列
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $data_data_item['score_log_event_tag']);

                //第七列
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $data_data_item['score_log_event_intro']);

                //第八列
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $data_data_item['score_log_event_time']);

                //第九列
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $data_data_item['teacher_name']);

                //设置高度
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);

                //居中
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('H' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('I' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                ++$i;
            }
        }
        ++$i;

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);

        
        //第二标签页
        $objPHPExcel->createSheet(1);
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->getActiveSheet()->setTitle('分数统计');
        $objPHPExcel->getActiveSheet()->mergeCells('F1:G1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '学院');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $class_info['school_name']);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '班级');
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('D1', $class_info['class_name']);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '生成时间');
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('F1', date('Y-m-d H:i:s'));
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
        
        $objPHPExcel->getActiveSheet()->setCellValue('A2', '序号');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('B2', '学号');
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('C2', '姓名');
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('D2', '德育');
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('E2', '文体');
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('F2', '智育');
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->setCellValue('G2', '总分');
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
        
        $i = 3;
        foreach ($score_array as $score_key => $score_value){
            //第一列
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, ($i - 2));

            //第二列
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $score_key);

            //第三列
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $score_value['name']);
            
            //第四列
            if ($score_value['score']['d_sum'] >= 12){
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $score_value['score']['d_sum']);
            } else {
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $score_value['score']['d_sum'] . '【无评优资格】');
            }

            //第五列
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $score_value['score']['w_sum']);

            //第六列
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $score_value['score']['z_sum']);

            //第七列
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $score_value['score']['sum']);

            //设置高度
            $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(30);

            //居中
            $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            ++$i;
        }
        
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        
        header("Content-Type: application/force-download");  
        header("Content-Type: application/octet-stream");  
        header("Content-Type: application/download");  
        header('Content-Disposition:inline;filename="' . $clean['file_name'] . '"');  
        header("Content-Transfer-Encoding: binary");  
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
        header("Pragma: no-cache");  
        $objWriter->save('php://output');
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
        
        if (!in_array($this->session->userdata('role_index'), array('god', 'admin', 'write_all', 'write_person'))){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的权限不足'));
            return 0;
        }
        
        if ('write_person' == $this->session->userdata('role_index') && $this->input->post('class_student_id', TRUE) != $this->session->userdata('user_id')){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您只能添加自己的信息'));
            return 0;
        }
        
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的登录信息已过期,请重新登录'));
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
        
        if (!$this->record_model->checkScoreJudge($data['score_type_id'], $data['score_log_judge'])){
            echo json_encode(array('code' => -3, 'message' => '抱歉，分数错误，请参考评分标准', 'id' => 'score_judge'));
            return 0;
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
    
    /**    
     *  @Purpose:    
     *  删除记录    //将valid置0    
     *  @Method Name:
     *  deleScoreLog()    
     *  @Parameter: 
     *  POST score_log_id               流水号
     *  @Return: 
    */
    public function deleScoreLog(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('record_model');
        
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的登录信息已过期,请重新登录'));
            return 0;
        }
        $data = array();
        
        if (!$this->input->post('score_log_id', TRUE) || !ctype_digit($this->input->post('score_log_id', TRUE))){
            echo json_encode(array('code' => -3, 'message' => '记录id必须为数字'));
            return 0;
        } else {
            $data['score_log_id'] = $this->input->post('score_log_id', TRUE);
        }
        
        if (!in_array($this->session->userdata('role_index'), array('god', 'admin', 'write_all', 'write_person'))){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的权限不足'));
            return 0;
        }
        
        if ($this->session->userdata('role_index') == 'write_person' && ($this->session->userdata('user_id') == $this->authorizee->getScoreStudent($data['score_log_id']))){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的不能更改其他用户记录'));
            return 0;   
        }
        
        if ($this->record_model->deleScoreLog($data['score_log_id'])){
            echo json_encode(array('code' => 1));
            return 0;
        } else {
            echo json_encode(array('code' => -4, 'message' => '删除数据失败'));
            return 0;   
        }
    }
}