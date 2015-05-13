<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 
 * 
 *
 * @copyright  版权所有(C) 2015-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    0.1
 * @link       https://github.com/SUTFutureCoder 
*/
         
class Index extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  显示主页    
     *  @Method Name:
     *  Index()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  
     * :WARNING: 请不要地址末尾加上index.php打开 :WARNING:
    */
    public function Index()
    {          
        $this->load->library('session');
        
        $this->load->view('login_view');
    }
    
    //显示验证码
    public function getAgnomen(){
        $this->load->library('session');
        $url = BASE_SCHOOL_URL . 'ACTIONVALIDATERANDOMPICTURE.APPPROCESS';
        
        $ch_cookie = curl_init();
        curl_setopt($ch_cookie, CURLOPT_URL, $url);
        curl_setopt($ch_cookie, CURLOPT_HEADER, 1); 
        curl_setopt($ch_cookie, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch_cookie);
        curl_close($ch_cookie);
        
        list($header, $body) = explode("\r\n\r\n", $content);
        preg_match("/set\-cookie:([^\r\n!]*)/i", $header, $matches); 
        $cookie = $matches[1];  
        
        $this->session->set_userdata('cookie', $cookie);
        header("Content-Type:image/jpg");
        echo ($body);
    }
    
    
    
    /**    
     *  @Purpose:    
     *  验证用户登陆    
     *  @Method Name:
     *  PassCheck()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  
    */
    public function PassCheck(){
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->model('user_model');
        
        $clean = array();
        if (!$this->input->post('WebUserNO', TRUE) || !ctype_digit($this->input->post('WebUserNO', TRUE))){
            echo json_encode(array('code' => -1, 'error' => '抱歉，您的教务处账号不合法'));
            return 0;
        } else {
            $clean['WebUserNO'] = $this->input->post('WebUserNO', TRUE);
        }
        
        //cURL请求
        $url = BASE_SCHOOL_URL . 'ACTIONLOGON.APPPROCESS?mode=4';
        $clean['Password'] = $this->input->post('Password', TRUE);
        $clean['Agnomen'] = $this->input->post('Agnomen', TRUE);
        
        $ch = curl_init();
        $postField = 'WebUserNO=' . $clean['WebUserNO'] . '&Password=' . $clean['Password'] . '&Agnomen=' . $clean['Agnomen'];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie:' . $this->session->userdata('cookie')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postField);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        
        
        $result_array = array();
        $result_array = explode('<td align="left">', $result);
        $result_array = explode('</td>', $result_array[1]);
        
        if (strstr($result_array[0], '<input')){
            echo json_encode(array('code' => -1, 'error' => '抱歉，您的密码错误或输入错误的验证码'));
            return 0;
        }
        
        //写入session
        $clean['teacher_name'] = htmlentities(iconv('gb2312', 'utf-8//IGNORE', $result_array[0]), ENT_QUOTES);
        $clean['teacher_id'] = htmlentities(iconv('gb2312', 'utf-8//IGNORE', $clean['WebUserNO']), ENT_QUOTES);
        $clean['teacher_password'] = $this->encrypt->encode($clean['Password']);
        
        $this->session->set_userdata('user_name', iconv('gb2312', 'utf-8//IGNORE', $result_array[0]));
        $this->session->set_userdata('user_id', iconv('gb2312', 'utf-8//IGNORE', $clean['WebUserNO']));
        echo json_encode(array('code' => 1));
    }
}