<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 抓取
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/
class Fetch extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  抓取学生基础信息接口    
     *  @Method Name:
     *  fetchStudentBasicInfo()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  
    */
    public function fetchStudentBasicInfo(){
        $this->load->library('session');
        $this->load->library('authorizee');
        set_time_limit(1800);
        header("Content-type:text/html;charset=utf-8");
        echo '<p style="color:red">请注意，每年度评比前请使用本功能进行更新缓存操作<p>';
        echo '<br/>';
        echo '<p style="color:red">10秒钟后开始更新缓存,您可以关闭本标签页以停止缓存<p>';
        echo '<br/>';
        ob_flush(); 
        flush();
        sleep(10);
        $class_list = array();
        echo '正在缓存学院/专业/班级基础信息,请稍候...';
        echo '<br/>';
        ob_flush(); 
        flush();
        $class_list = $this->fetchSchoolMajorClassInfo();
        echo '学院/专业/班级基础信息获取完毕';
        echo '<br/>';
        foreach ($class_list as $class_item){
            if ((int)(date('y')) > ((int)substr($class_item[0], 0, 2) + 5)){
                continue;
            }
            echo '正在缓存' . $class_item[0] . '-' . $class_item[1] . '信息';
            echo '<br/>';
            ob_flush(); 
            flush();
            $this->fetchStudentList($class_item[0]);
        }        
        echo '全部信息缓存完毕';
        echo '<br/>';
        ob_flush(); 
        flush();
    }
    
    /**    
     *  @Purpose:    
     *  抓取学院、专业、班级信息    
     *  @Method Name:
     *  PassCheck()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  
    */
    private function fetchSchoolMajorClassInfo(){
        $this->load->library('session');
        $this->load->model('fetch_model');
        
        //cURL请求
        $url = BASE_SCHOOL_URL . 'ACTIONCLASSJDQUERY.APPPROCESS';
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie:' . $this->session->userdata('cookie')));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        
        $result = iconv('gb2312', 'utf-8//IGNORE', $result);
        
        $result = strip_tags($result, '<option>');
        $result = explode('院&nbsp;&nbsp;系', $result);
        $school_raw = mb_substr($result[1], 0, mb_strpos($result[1], '专&nbsp;&nbsp;业'));
        $school_raw_array = explode('<option value="', $school_raw);
        foreach ($school_raw_array as $value){
            $temp = explode('">', $value);
            if (!$temp[0] || !isset($temp[1])){
                continue;
            }
            $temp[1] = str_replace(array("\n", "\r", ' '), '', strip_tags($temp[1]));
            $school_value[] = $temp;
        }
        
        $result = explode('专&nbsp;&nbsp;业', $result[1]);
        $major_raw = mb_substr($result[1], 0, mb_strpos($result[1], '班&nbsp;&nbsp;级'));
        $major_raw_array = explode('<option value="', $major_raw);
        foreach ($major_raw_array as $value){
            $temp = explode('">', $value);
            if (!$temp[0] || !isset($temp[1])){
                continue;
            }
            $temp[1] = str_replace(array("\n", "\r", ' '), '', strip_tags($temp[1]));
            $major_value[] = $temp;
        }

        $result = explode('班&nbsp;&nbsp;级', $result[1]);
        $class_raw = mb_substr($result[1], 0, mb_strpos($result[1], '&nbsp;'));
        $class_raw_array = explode('<option value="', $class_raw);
        foreach ($class_raw_array as $value){
            $temp = explode('">', $value);
            if (!$temp[0] || !isset($temp[1]) || $temp[0] == '-1' || $temp[1][0] == '0'){
                continue;
            }
            $temp[1] = str_replace(array("\n", "\r", ' '), '', strip_tags($temp[1]));
            $temp[1] = mb_substr($temp[1], mb_strpos($temp[1], '[') + 1, mb_strpos($temp[1], ']') - mb_strpos($temp[1], '[') - 1);
            $class_value[] = $temp;
        }
        
        $this->fetch_model->updateSchoolMajorClass($school_value, $major_value, $class_value);
        return $class_value;
    }
    
    /**    
     *  @Purpose:    
     *  抓取全部班级学生列表信息    
     *  @Method Name:
     *  fetchStudentList($class_id)    
     *  @Parameter: 
     *  int $class_id 班级id
     *  @Return: 
     *  
    */
    private function fetchStudentList($class_id){
        $this->load->library('session');
        $this->load->model('fetch_model');
        
        //cURL请求
        $url = BASE_SCHOOL_URL . 'ACTIONQUERYCLASSSTUDENT.APPPROCESS?mode=2&query=1';
      
        $ch = curl_init();
        $postField = 'ClassNO=' . (int)$class_id;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie:' . $this->session->userdata('cookie')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postField);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = iconv('gb2312', 'utf-8//IGNORE', $result);
        $result = strip_tags($result, '<tr>');
        $result = explode("\n", $result);
        
        $result_count = count($result) - 20;
        $data_array = array();
        
        
        for ($i = 34; $i < $result_count; $i += 10){
            $data_array[] = array(
                'student_id' => trim($result[$i++]),
                'student_name' => trim($result[$i++]),  
                'student_class' => $class_id
            );   
        }
        $this->fetch_model->fetchStudentList($data_array);
    }
    
    /**    
     *  @Purpose:    
     *  抓取全部学生平均绩点信息【测试用，不存库，随填随取】    
     *  @Method Name:
     *  fetchStudentAveragePoint()    
     *  @Parameter: 
     *  @Return: 
     *  
    */
    public function fetchStudentAveragePoint(){
        $this->load->library('session');
        $this->load->model('fetch_model');
        
        //cURL请求
        $url = BASE_SCHOOL_URL . 'ACTIONCLASSJDQUERY.APPPROCESS?mode=2&query=1&xuanzelei=总成绩';
      
        $ch = curl_init();
        $postField = 'FirstYearTermNO=13&EndYearTermNO=14&xuanze=1&ClassNO=1204063';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie:' . $this->session->userdata('cookie')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postField);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = iconv('gb2312', 'utf-8//IGNORE', $result);
        $result = explode("\n", strip_tags($result, '<td>'));
        
        $result_count = count($result) - 14;
        $average_point = array();
        $n = 0;
        
        for ($i = 84; $i < $result_count; $i++, $n++){
            while (trim($result[$i]) == ''){
                $i++;
            }        
            $average_point[$n]['student_id'] = $result[++$i];
            $i += 6;
            while (trim($result[$i]) == ''){
                $i++;
            }      
            $average_point[$n]['average_point'] = $result[$i];
            $i += 5;
        }
        
        var_dump($average_point);
    }
    
}