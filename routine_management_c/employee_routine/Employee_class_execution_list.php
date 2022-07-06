<?php
defined('BASEPATH') OR exit('No direct script access allowed' );

class Employee_class_execution_list extends NIC_Controller
{
    public function __construct()
    {
		parent::__construct();
	   parent::check_privilege(170);
		$this->load->library('user_agent');
		$this->load->helper('url');
		$this->load->helper('routine_management_helper');
		$this->load->model('operator/College_emp_basic_model');
		$this->load->model('routine_management_m/employee_routine/Employee_routine_model');
        $this->load->library('form_validation');
		//$this->output->enable_profiler(TRUE);
		
		// $this->js_foot = array(
		// 		1 =>$this->config->item('theme_uri').'college_routine/js/college_routine_approve_revert.js',
		// );
	}

	public function index($offset = NULL){
		$stake_id = $this->session->userdata('stake_id_fk');
        $emp_id = $this->session->userdata('stake_details_id_fk');
        $data['emp_details'] = $this->College_emp_basic_model->get_employee_details_by_id($emp_id);
         $this->load->library('pagination');
        $config['base_url']         = 'routine_management_c/employee_routine/Employee_class_execution_list/index';
        $config['total_rows']       = $this->Employee_routine_model->count_employee_execution_list()[0]['count'];
        $config['per_page']         = 20;
        $config['num_links']        = 3;
        $config['full_tag_open']    = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close']   = '</ul>';
        $config['first_link']       = '<i class="fa fa-fast-backward"></i>';
        $config['first_tag_open']   = '<li class="">';
        $config['first_tag_close']  = '</li>';
        $config['last_link']        = '<i class="fa fa-fast-forward"></i>';
        $config['last_tag_open']    = '<li class="">';
        $config['last_tag_close']   = '</li>';
        $config['first_tag_open']   = '<li>';
        $config['first_tag_close']  = '</li>';
        $config['prev_link']        = '<i class="fa fa-backward"></i>';
        $config['prev_tag_open']    = '<li class="prev">';
        $config['prev_tag_close']   = '</li>';
        $config['next_link']        = '<i class="fa fa-forward"></i>';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tag_close']   = '</li>';
        $config['cur_tag_open']     = '<li class="active"><a href="javascript:void(0)">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
		$this->pagination->initialize($config);
        
        $data['class_execution'] = $this->Employee_routine_model->getClassexecutiondata($emp_id,$config['per_page'], $offset);
        $data['page_links']     = $this->pagination->create_links();
        $data['offset']         = $offset;
        $this->load->view($this->config->item('theme').'routine_management_v/employee_routine/employee_class_execution_view.php',$data);
    }
    
    public function classExecutionupdate($excecution_id_pk){
        $emp_id = $this->session->userdata('stake_details_id_fk');
        $data['execution_details'] = $this->Employee_routine_model->getexecutionDetails($excecution_id_pk);
        $data['reason_deatils'] = $this->Employee_routine_model->getAllreason();
        $data['execution_id'] = $excecution_id_pk;
        if($this->input->post()){
            $routine_details_id_fk = $this->input->post('routine_details_id_fk');
            $employee_id_fk = $this->input->post('employee_id_fk');
            $college_id_fk = $this->input->post('college_id_fk');
            $class_execution_date = $this->input->post('class_execution_date');
            $class_execution = $this->input->post('class_execution');
            $topic_coverd = $this->input->post('topic_coverd');
            $remarks = $this->input->post('remarks');
            $class_execution_reason = $this->input->post('class_execution_reason');
            $class_execution_id = $this->input->post('execution_id');


            $this->form_validation->set_rules('class_execution','Class Execution','required');
            
            if($this->form_validation->run()==FALSE){
                $data['execution_details'] = $this->Employee_routine_model->getexecutionDetails($excecution_id_pk);
                $data['reason_deatils'] = $this->Employee_routine_model->getAllreason();
            }else{
                if($class_execution =='1'){
                    $data = array(
                        'routine_details_id_fk'=>$routine_details_id_fk,
                        'employee_id_fk'=>$employee_id_fk,
                        'college_id_fk'=>$college_id_fk,
                        'class_execution_date'=>$class_execution_date,
                        'topic_coverd'=>$class_execution,
                        'topic_coverd_desc'=>$topic_coverd,
                        'remarks'=>$remarks,
                        'active_status'=>'1',
                        'status_code_fk'=>'5',
                        'entry_time'=>date('Y-m-d H:i:s'),
                        'entry_ip'=>$this->input->ip_address(),

                    );
                }
                if($class_execution =='0'){
                    $data = array(
                        'routine_details_id_fk'=>$routine_details_id_fk,
                        'employee_id_fk'=>$employee_id_fk,
                        'college_id_fk'=>$college_id_fk,
                        'class_execution_date'=>$class_execution_date,
                        'topic_coverd'=>$class_execution,
                        'topic_coverd_desc_no'=>$class_execution_reason,
                        'active_status'=>'1',
                        'status_code_fk'=>'5',
                        'entry_time'=>date('Y-m-d H:i:s'),
                        'entry_ip'=>$this->input->ip_address()
                    );
                }
               
                $result = $this->Employee_routine_model->updateExecutiondetails($data,$class_execution_id);
                if($result){
                    $this->session->set_flashdata('success','Execution has been successfully updated ');
                    redirect('admin/routine_management_c/employee_routine/Employee_class_execution_list');
                }else{
                    $this->session->set_flashdata('error','Something Went Wrong, Please try again');
                    redirect('admin/routine_management_c/employee_routine/Employee_class_execution_list');
                }
            }


        }
        $this->load->view($this->config->item('theme').'routine_management_v/employee_routine/employee_class_execution_edit_view.php',$data);
    }

    public function viewTopic(){
        $topic_id = $this->input->get('topic_id');
        $result = $this->Employee_routine_model->getCoverddetails($topic_id);
        echo $result;
      }
}