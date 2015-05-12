<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2015 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    
 * @link       https://github.com/SUTFutureCoder/
*/
class Control_center extends CI_Controller{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->library('session');
        if (!$this->session->userdata('cookie')){
            header("Content-type: text/html; charset=utf-8");
            echo '<script>alert("抱歉，您的权限不足或登录信息已过期");window.location.href="' . base_url() . '";</script>';            
            return 0;
        }
        
        $this->load->view('control_center_view', array('user_name' => $this->session->userdata('user_name')));
    }
}