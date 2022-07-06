<?php
defined('BASEPATH') OR exit('No direct script access allowed' );

class College_routine_execution_list extends NIC_Controller
{
    public function __construct()
    {
		parent::__construct();
		parent::check_privilege(166);
		$this->load->library('user_agent');
		$this->load->helper('url');
        $this->load->helper('routine_management_helper');
		$this->load->model('routine_management_m/college_routine/College_routine_model');
		//$this->output->enable_profiler(TRUE);
		 
		$this->js_foot = array(
				1 =>$this->config->item('theme_uri').'college_routine/js/college_routine_execution_revert.js',

		);
	}

	public function index($offset=NULL){

		$stake_id = $this->session->userdata('stake_id_fk');
        $stake_login_id = $this->session->userdata('stake_holder_login_id_pk');
        $college_id = $this->session->userdata('stake_details_id_fk');

        $this->load->library('pagination');
        $config['base_url']         = 'routine_management_c/college_routine/College_routine_execution_list/index';
        $config['total_rows']       = $this->College_routine_model->getcountexecution()[0]['count'];
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
        $data['offset']         = $offset;

        $data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
        $data['all_days'] = $this->College_routine_model->getAlldays();
        $data['period_no'] = $this->College_routine_model->getAllperiodno();
        $data['period_type'] = $this->College_routine_model->getAllperiodtype();
        $data['year'] = $this->College_routine_model->getAllyear();
        $data['semester'] = $this->College_routine_model->getAllsemester();
        $data['discipline'] = $this->College_routine_model->get_all_course();
        $data['subject'] = $this->College_routine_model->getAllsubject();
        
		$date = $this->input->post('date');
		$to_date = $this->input->post('to_date');
        $emp_id = $this->input->post('emp_id');
        $type = $this->input->post('type');

        if($this->input->post()){
        	 $data['all_execution'] = $this->College_routine_model->getAllexecution($college_id,$date,$to_date,$emp_id,$type);
        	 $data['page_links'] = "";
        	$this->load->view($this->config->item('theme').'routine_management_v/college_routine/college_routine_execution_view',$data);
        }else{
        	 $data['all_execution'] = $this->College_routine_model->getAllexecution_all($college_id,$config['per_page'],$offset);
        	 $data['page_links'] = $this->pagination->create_links();
        	 $this->load->view($this->config->item('theme').'routine_management_v/college_routine/college_routine_execution_view',$data);
        }
       
	}

	public function acceptExecution($excecution_id_pk){
		$data= $this->College_routine_model->executionApprove($excecution_id_pk);

		if($data){
			$this->session->set_flashdata('success','Class Execution Approved Successfully...');
			redirect('admin/routine_management_c/college_routine/College_routine_execution_list');
		}
		else{
			$this->session->set_flashdata('error','Something Went Wrong,Please Try Again');
			redirect('admin/routine_management_c/college_routine/College_routine_execution_list');
		}

	}


	public function approveAllexecution(){
		
		$class_execution_id = $this->input->post('routine_id');
		if($class_execution_id == ''){
			$this->session->set_flashdata('error','No routine has been selected,Please select any one routine');
				redirect('admin/routine_management_c/college_routine/College_routine_execution_list');
		}else{
			$data= $this->College_routine_model->approveAllexecutiondata($class_execution_id);
			if($data){
				$this->session->set_flashdata('success','All Routine Has Been Approved');
				redirect('admin/routine_management_c/college_routine/College_routine_execution_list');
			}
			else{
				$this->session->set_flashdata('error','Something Went Wrong,Please Try Again');
				redirect('admin/routine_management_c/college_routine/College_routine_execution_list');
			}
		}
			
		
	}

	//..................Class Execution Reject with rmarks..........................//
	public function ajax_result_revart_back($execution_manage_id = NULL)
    {   
        $execution_id = $execution_manage_id;

        $this->load->helper('string');
        if($execution_id == NULL || strlen($execution_id) != 32)
        {
          echo '<div class="alert alert-danger">Something went wrong. Please try again</div>';
        } 
        else 
        {
          $data['revert_data']= $this->College_routine_model->getRejectdetails($execution_id);
          $data['routine_manage_id_hash']= $execution_id;
          $this->load->view($this->config->item('theme').'routine_management_v/college_routine/ajax/ajax_class_execution_reject_view',$data);
        }
        
    }

  public function confirm_result_revart($routine_hash=NULL)
  {
   
    $routine_hash = $this->input->POST('routine_hash');


    $data['revert_data']= $this->College_routine_model->getRejectdetails($routine_hash);
    
    $data['routine_manage_id_hash']= $routine_hash;
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    $config = array(
                array(
                  'field' => 'approve_revirt_dec',
                  'label' => '<b>Reject Remarks</b>',
                  'rules' => 'trim|required'
                )
            );
    $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE)
        {
           $this->load->view($this->config->item('theme').'routine_management_v/college_routine/ajax/ajax_class_execution_reject_view',$data);
        }
      else
      {
        $update_array = array(
            'status_code_fk'                   => '6',
            'reject_remarks_time'              => date('Y-m-d H:i:s'),
            'remaks_rejecet_by_ip'             => $this->input->ip_address(),
            'remarks_reject_by'                => $this->session->userdata('stake_holder_login_id_pk'),
            'reject_remarks'                   => $this->input->post('approve_revirt_dec')
          );
       
          $result = $this->College_routine_model->rejectRemarks($routine_hash,$update_array);
          

        if($result)
        {
          $data['code'] = 1;
          $data['msg'] = "Execution Rejected Successfully...";
        }
        $this->load->view($this->config->item('theme').'routine_management_v/college_routine/ajax/ajax_class_execution_reject_view',$data);
    }
  
    
  }

      public function viewTopic(){
        $topic_id = $this->input->get('topic_id');
        $result = $this->College_routine_model->getCoverddetails($topic_id)[0];
        $data = array (
			'topic_coverd_desc' 			=>      $result['topic_coverd_desc'],
			'total_no_studnets_registerd' 	=>		$result['total_no_studnets_registerd'],
			'total_no_of_students_attends' 	=> 		$result['total_no_of_students_attends']
		);
		echo json_encode($data);
      }

	
}
