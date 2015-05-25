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
        $this->load->model('right_model');
        
        if (!$this->session->userdata('cookie')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的登录信息已过期");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        if (!$role_id = $this->authorizee->checkAuthorizee($this->session->userdata('user_id'), 'all') && !$role_id = $this->authorizee->checkAuthorizee($this->session->userdata('user_id'), 'write_person')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的权限不足");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        $list = array();
        if ($role_id){
            $list = $this->right_model->getRightList($role_id);
        }
        
        $this->load->view('authorizee_set_view', array(
            'right_list' => $list
        ));
    }
    
    /**    
     *  @Purpose:    
     *  授权    
     *  @Method Name:
     *  setAuthorizee()    
     *  @Parameter: 
     *  POST $user_id   用户id
     *  POST $role_id   角色id
     *  @Return: 
     *  
    */
    public function setAuthorizee(){
        $this->load->library('session');
        $this->load->library('Authorizee');
        $this->load->model('right_model');
        if (!$this->session->userdata('cookie')){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的登录信息已过期,请重新登录'));
            return 0;
        }
        
        if (!$role_id = $this->authorizee->checkAuthorizee($this->session->userdata('user_id'), 'all') && !$role_id = $this->authorizee->checkAuthorizee($this->session->userdata('user_id'), 'write_person')){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的权限不足'));
            return 0;
        }
        
        $data = array();
    }
    
}