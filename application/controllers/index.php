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
    
    /**    
     *  @Purpose:    
     *  显示离线版主页    
     *  @Method Name:
     *  IndexOffline()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  
     * :WARNING: 请不要地址末尾加上index.php打开 :WARNING:
    */
    public function IndexOffline()
    {          
        $this->load->library('session');
        
        $this->load->view('login_offline_view');
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
     *  显示离线验证码    
     *  @Method Name:
     *  getOfflineAgnomen()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  
    */
    public function getOfflineAgnomen(){
        $this->load->library('session');
        $this->load->library('ValidateCode');
        $_vc = new ValidateCode();            
        $_vc->doimg();
        $this->session->set_userdata('authnum_session', $_vc->getCode());
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
        $this->load->library('authorizee');
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
        
        //本地数据库权限检查
        if($role_index = $this->authorizee->getAuthorizeeIndex($clean['WebUserNO'])){
            //为0则只读，只能读取除平均绩点外的数据
             if ($role_index == 'ban_use'){
                //ban
                echo json_encode(array('code' => -1, 'error' => '抱歉，您的账户已被封禁'));
                return 0;
            }
        } else {
            $role_index = 'readonly';
        }
        
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
        
        if (1 != $this->user_model->updateTeacherInfo($clean['teacher_id'], $clean['teacher_name'], $clean['teacher_password'])){
            echo json_encode(array('code' => -1, 'error' => '抱歉，您的信息存储错误'));
            return 0;
        }
        
        $this->session->set_userdata('user_name', $clean['teacher_name']);
        $this->session->set_userdata('user_id',  $clean['teacher_id']);
        $this->session->set_userdata('role_index', $role_index);
        $this->session->set_userdata('online', true);
        
        $this->session->unset_userdata('authnum_session');
        
        echo json_encode(array('code' => 1));
    }
    
    /**    
     *  @Purpose:    
     *  离线验证用户登陆    
     *  @Method Name:
     *  PassCheckOffline()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  
    */
    public function PassCheckOffline(){
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('authorizee');
        $this->load->model('user_model');

        if ($this->session->userdata('authnum_session') == $this->input->post('Agnomen', true)){
            echo json_encode(array('code' => -1, 'error' => '抱歉，您输入的验证码有误'));
            return 0;
        }
        
        $clean = array();
        if (!$this->input->post('WebUserNO', TRUE) || !ctype_digit($this->input->post('WebUserNO', TRUE))){
            echo json_encode(array('code' => -1, 'error' => '抱歉，您的教务处账号不合法'));
            return 0;
        } else {
            $clean['WebUserNO'] = $this->input->post('WebUserNO', TRUE);
        }
            
        //本地数据库权限检查
        if($role_index = $this->authorizee->getAuthorizeeIndex($clean['WebUserNO'])){
            //为0则只读，只能读取除平均绩点外的数据
             if ($role_index == 'ban_use'){
                //ban
                echo json_encode(array('code' => -1, 'error' => '抱歉，您的账户已被封禁'));
                return 0;
            }
        } else {
            $role_index = 'readonly';
        }
        
        //本地数据库检查用户名密码
        if ($user_info_array = $this->user_model->getTeacherInfo($clean['WebUserNO'])){
            if ($this->encrypt->decode($user_info_array['teacher_password']) != $this->input->post('Password', true)){
                echo json_encode(array('code' => -1, 'error' => '抱歉，您的密码有误或未曾在在线模式下登录过'));
                return 0;
            } else {
                //写入session
                $clean['teacher_name'] = htmlentities($user_info_array['teacher_name'], ENT_QUOTES);
                $clean['teacher_id'] = htmlentities($user_info_array['teacher_id'], ENT_QUOTES);
            }
        } else {
            echo json_encode(array('code' => -1, 'error' => '抱歉，您尚未被授权使用本平台'));
            return 0;
        }
        
        $this->session->set_userdata('user_name', $clean['teacher_name']);
        $this->session->set_userdata('user_id', $clean['teacher_id']);
        $this->session->set_userdata('role_index', $role_index);
        $this->session->set_userdata('online', false);
        
        $this->session->unset_userdata('cookie');
        
        echo json_encode(array('code' => 1));
    }
}