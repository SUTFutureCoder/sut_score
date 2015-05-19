<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 权限相关
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/
class Right extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  显示授权界面    
     *  @Method Name:
     *  showAuthorizeeSet()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  
    */
    public function showAuthorizeeSet(){
        $this->load->library('session');
        $this->load->library('authorizee');
        $this->load->model('authorizee_model');
        
        if (!$this->session->userdata('cookie')){
            echo json_encode(array('code' => -2, 'message' => '抱歉，您的权限不足或登录信息已过期,请重新登录'));
            return 0;
        }
        
        echo $this->authorizee->checkAuthorizee($this->session->userdata('user_id'), 'all');
        exit();
        
        $this->load->view('authorizee_set_view');
        
    }
    
}