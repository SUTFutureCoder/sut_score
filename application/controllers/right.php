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
        
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的登录信息已过期");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        if (!in_array($this->session->userdata('role_index'), array('all', 'write_person'))){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的权限不足");window.parent.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        $list = array();
        if ($role_id = $this->authorizee->getRoleId($this->session->userdata('role_index'))){
            $list = $this->right_model->getRightList($role_id);
        }
        
        
        $this->load->view('authorizee_set_view', array(
            'right_list' => $list,
            'user_right_list' => $this->right_model->getUserRightList()
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
        $this->load->library('authorizee');
        $this->load->model('right_model');
        if ((!$this->session->userdata('cookie') && $this->session->userdata('online')) || !$this->session->userdata('user_id')){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的登录信息已过期,请重新登录'));
            return 0;
        }
        if (!in_array($this->session->userdata('role_index'), array('all', 'write_person'))){
            echo json_encode(array('code' => -1, 'message' => '抱歉，您的权限不足'));
            return 0;
        }
        
        $data = array();
        
        if (!$this->input->post('right_teacher_id', TRUE) || !ctype_digit($this->input->post('right_teacher_id', TRUE)) || 9 < strlen($this->input->post('right_teacher_id', TRUE))){
            echo json_encode(array('code' => -2, 'message' => '抱歉，教师或学生id需要为数字'));
            return 0;
        } else {
            $data['user_id'] = $this->input->post('right_teacher_id', TRUE);
        }
        
        if (!ctype_digit($this->input->post('right_set_form_type', TRUE))
                || ($this->input->post('right_set_form_type', TRUE) != 0 && !$this->authorizee->getRoleIndex($this->input->post('right_set_form_type', TRUE)))){
            echo json_encode(array('code' => -3, 'message' => '抱歉，权限id错误'));
            return 0;
        } else {
            $data['role_id'] = $this->input->post('right_set_form_type', TRUE);
        }
        
        var_dump($data);
        exit();
        if ($this->right_model->setUserRole($data)){
            echo json_encode(array('code' => 1));
            return 0;
        } else {
            echo json_encode(array('code' => -4, 'message' => '处理失败'));
            return 0;
        }
    }
}