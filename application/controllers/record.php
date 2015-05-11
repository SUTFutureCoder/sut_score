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
        
        if (!$this->input->post('score_type_id', TRUE) || strlen($this->input->post('score_type_id', TRUE)) != 7){
            echo json_encode(array('code' => -3, 'message' => '抱歉，规则id错误'));
            return 0;
        }
        
        $data = array();
        $data = $this->record_model->ajaxGetRuleDetail($this->input->post('score_type_id', TRUE));
        echo json_encode(array('code' => 1, 'data' => $data));
        return 0;
    }
}