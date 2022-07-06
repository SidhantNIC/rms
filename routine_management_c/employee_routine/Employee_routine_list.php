<?php
defined('BASEPATH') OR exit('No direct script access allowed' );

class Employee_routine_list extends NIC_Controller
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
        
        $this->js_foot = array(
            2 => $this->config->item('theme_uri') . 'publications/js/rms_employee_class_execution.js',
        );
    }

    public function index($offset = NULL){  
        //print_r($_SESSION);
		
        $stake_id = $this->session->userdata('stake_id_fk');
        $emp_id = $this->session->userdata('stake_details_id_fk');
        $college_id = $this->session->userdata('stake_details_id_fk');

        $this->load->library('pagination');
        $config['base_url']         = 'employee_routine/Employee_routine_list/index';
        $config['total_rows']       = $this->Employee_routine_model->getCountroutinelist()[0]['count'];
        $config['per_page']         = 50;
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
        $data['all_days'] = $this->Employee_routine_model->getAlldays();
        $data['period_no'] = $this->Employee_routine_model->getAllperiodno();
        $data['period_type'] = $this->Employee_routine_model->getAllperiodtype();
        $data['year'] = $this->Employee_routine_model->getAllyear();
        $data['semester'] = $this->Employee_routine_model->getAllsemester();
        $data['discipline'] = $this->Employee_routine_model->getEmployeewisecoursename();
        $data['subject'] = $this->Employee_routine_model->getAllsubject();
        $data['all_emp'] = $this->Employee_routine_model->get_allemp($college_id);
        $data['all_reason'] = $this->Employee_routine_model->getAllreason();
		 $data['section_data'] = $this->Employee_routine_model->fetchSectiondata();
        //$data['count'] = $this->Employee_routine_model->getCountroutinelist();

        
        $data['emp_details'] = $this->College_emp_basic_model->get_employee_details_by_id($emp_id);
        $data['emp_details_view'] = $this->Employee_routine_model->get_all_routine_list_using_id($emp_id);
        
		//echo"<pre>";
		//print_r($data['emp_details_view']);
		//echo"</pre>";
		//die();
		
        $days_name = $this->input->post('days_name');
        $discipline_type = $this->input->post('discipline_type');
        $stud_year = $this->input->post('stud_year');
        $semester = $this->input->post('semester');
        $period_no = $this->input->post('period_no');
		$section_id = $this->input->post('section_name');
        $date = $this->input->post('date');

        if($this->input->post()){
            $data['emp_details_view'] = $this->Employee_routine_model->get_all_routine_list_using_id($emp_id,$days_name,$discipline_type,$stud_year,$semester,$section_id);
            $data['page_links'] = "";
            
       $this->load->view($this->config->item('theme').'routine_management_v/employee_routine/employee_routine_list_view',$data);
        }else{
            $data['emp_details_view'] = $this->Employee_routine_model->get_all_routine_list_using_id_all_data($emp_id,$config['per_page'],$offset);
            $data['page_links'] = $this->pagination->create_links();
           
       $this->load->view($this->config->item('theme').'routine_management_v/employee_routine/employee_routine_list_view',$data);
        }
        
         
        

    }

    public function executionClass(){
        
        $date = $this->input->get('date');
        $class_execution_yes_no = $this->input->get('class_execution_yes_no');
        $class_execution_yes = $this->input->get('class_execution_yes');
        $class_execution_no = $this->input->get('class_execution_no');
        $rouitne_id_exe = $this->input->get('rouitne_id_exe');
        $periodnoexe = $this->input->get('periodnoexe');
        $emp_id = $this->session->userdata('stake_details_id_fk');
        $remarks = $this->input->get('remarks');
		
		$registerd_class = $this->input->get('registerd_class');
		$attended_class = $this->input->get('attended_class');
		
        $college_id = $this->Employee_routine_model->getCollegenewid($emp_id);
        
        $resultExe = $this->Employee_routine_model->checkingExecution($date,$rouitne_id_exe,$periodnoexe,$emp_id);
		
		//$this->form_validation->set_rules('class_execution_yes','Topic Coverd','required|max_length[255]|trim');
		//$this->form_validation->set_rules('remarks','Remarks','max_length[255]|trim');
		
		//if($this->form_validation->run()== FALSE){
			//$output = array('msg'=>'Description and Remarks Filed Allowed Maximum 255 character');
		//}else{

				if($resultExe>0){
					$output = array('msg'=>'Routine has been already executed, Please Chose another date');
				}else{
					if($class_execution_yes_no == '1'){
					 $result = array(
						'employee_id_fk'=>$emp_id,
						'class_execution_date'=>$date,
						'topic_coverd'=>$class_execution_yes_no,
						'topic_coverd_desc'=>$class_execution_yes,
						'entry_time'=>date('Y-m-d H:i:s'),
						'entry_ip'=>$this->input->ip_address(),
						'active_status'=>'1',
						'status_code_fk'=>'5',
						'college_id_fk'=>$this->session->userdata('stake_details_id_fk'),
						'remarks'=>$remarks,
						'routine_details_id_fk'=>$rouitne_id_exe,
						'college_id_fk'=>$college_id,
						'period_no_fk'=>$periodnoexe,
						'total_no_studnets_registerd'=>$registerd_class,
						'total_no_of_students_attends'=>$attended_class


					 );
				}
				if($class_execution_yes_no == '0'){
					 $result = array(
						'employee_id_fk'=>$emp_id,
						'class_execution_date'=>$date,
						'topic_coverd'=>$class_execution_yes_no,
						'topic_coverd_desc_no'=>$class_execution_no,
						'entry_time'=>date('Y-m-d H:i:s'),
						'entry_ip'=>$this->input->ip_address(),
						'active_status'=>'1',
						'status_code_fk'=>'5',
						'college_id_fk'=>$this->session->userdata('stake_details_id_fk'),
						'routine_details_id_fk'=>$rouitne_id_exe,
						'college_id_fk'=>$college_id,
						'period_no_fk'=>$periodnoexe
						
					);
				}
			   
				
				$data= $this->Employee_routine_model->updateClassexecution($result);
				
				 if($data){
					 $output = array('msg'=>'Class Executed Successfully');
				}
			}
		//}
        
        echo json_encode($output);
        
    }

    public function viewAllroutine($routine_manage_id_pk){
        $data['routine'] = $this->Employee_routine_model->get_all_routine_list_using_id_all($routine_manage_id_pk);
        $data['practical_sub'] = $this->Employee_routine_model->getPracsubusingid($routine_manage_id_pk);
        $this->load->view($this->config->item('theme').'routine_management_v/employee_routine/employee_routine_all_view',$data);   

    }

    public function searchRiutine(){
        $days_name = $this->input->post('days_name');
        $discipline_type = $this->input->post('discipline_type');
        $stud_year = $this->input->post('stud_year');
        $semester = $this->input->post('semester');
        $period_no = $this->input->post('period_no');
        $date = $this->input->post('date');

        $emp_id = $this->session->userdata('stake_details_id_fk');
        $data['all_days'] = $this->Employee_routine_model->getAlldays();
        $data['period_no'] = $this->Employee_routine_model->getAllperiodno();
        $data['period_type'] = $this->Employee_routine_model->getAllperiodtype();
        $data['year'] = $this->Employee_routine_model->getAllyear();
        $data['semester'] = $this->Employee_routine_model->getAllsemester();
        $data['discipline'] = $this->Employee_routine_model->get_all_course();
        $data['subject'] = $this->Employee_routine_model->getAllsubject();
        //$data['all_emp'] = $this->Employee_routine_model->get_allemp($college_id);
            
        $data['emp_details'] = $this->College_emp_basic_model->get_employee_details_by_id($emp_id);

        $this->form_validation->set_rules('days_name','Date','required');
        $this->form_validation->set_rules('discipline_type','Discipline Type','required');
        $this->form_validation->set_rules('stud_year','Year','required');
        $this->form_validation->set_rules('semester','Semester','required');
        $this->form_validation->set_rules('period_no','Period No','required');
        $this->form_validation->set_rules('date','Date','required');

        if($this->form_validation->run() != FALSE){
            $this->load->view($this->config->item('theme').'routine_management_v/employee_routine/employee_routine_list_view',$data);   

        }else{
            $data['subject'] = $this->Employee_routine_model->get_all_routine_list_search($date,$days_name,$discipline_type,$stud_year,$semester,$period_no);
        }

    }

    public function executionListmodal()
    {   
        $rouitneid = $this->input->get('rouitneid');
        $periodno = $this->input->get('periodno');
        $output  = array('rouitneid' =>$rouitneid,'periodno'=>$periodno );
        echo json_encode($output);
    }

public function classExecutionroutinelist(){
        $data['all_academic_year'] = $this->Employee_routine_model->get_allacademicyear();
        $data['semester'] = $this->Employee_routine_model->getAllsemester();
        $data['year'] = $this->Employee_routine_model->getAllyear();
        $data['all_reason'] = $this->Employee_routine_model->getAllreason();
		$emp_id = $this->session->userdata('stake_details_id_fk');
		$college_ids = $this->Employee_routine_model->getCollegenewid($emp_id);
		$college_id = array_column($college_ids,'college_id_fk');
		$data['college_name'] = $this->Employee_routine_model->fetchCollegenames($college_id);
		$data['all_course'] = $this->Employee_routine_model->getEmployeewisecoursename();
		
        if($this->input->post()){
            $academic_year = $this->input->post('academic_year');
            $stud_year = $this->input->post('stud_year');
            $semester = $this->input->post('semester');
			$discipline_id = $this->input->post('discipline_id');
			$polytechnic_name = $this->input->post('polytechnic_name');

            $this->form_validation->set_rules('academic_year','Academic Year','required');
            $this->form_validation->set_rules('stud_year','Year','required');
            $this->form_validation->set_rules('semester','Semester','required');
			$this->form_validation->set_rules('discipline_id','Discipline','required');
			$this->form_validation->set_rules('polytechnic_name','Polytechnic','required');

            if($this->form_validation->run() == FALSE){
                $data['all_academic_year'] = $this->Employee_routine_model->get_allacademicyear();
                $data['semester'] = $this->Employee_routine_model->getAllsemester();
                $data['year'] = $this->Employee_routine_model->getAllyear();
                $data['all_reason'] = $this->Employee_routine_model->getAllreason();
				$emp_id = $this->session->userdata('stake_details_id_fk');
				$college_id = $this->Employee_routine_model->getCollegenewid($emp_id);
				
				$data['all_course'] = $this->Employee_routine_model->getEmployeewisecoursename();
            }else{
        $data['result'] = $this->Employee_routine_model->getExecutiondetailslistview($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id,$emp_id);
        $data['period_time'] = $this->Employee_routine_model->getPeriodtime($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id);
        $data['mondays'] = $this->Employee_routine_model->getMondayroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id,$emp_id);
        $data['tuesdays'] = $this->Employee_routine_model->getTuesdayroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id);
        $data['wednesdays'] = $this->Employee_routine_model->getWednesdayroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id);
        $data['thrusdays'] = $this->Employee_routine_model->getThrusdatroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id);
        $data['fridays'] = $this->Employee_routine_model->getFridayroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id);
        $data['saturdays'] = $this->Employee_routine_model->getSataurdayroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id);
		
		
            }

        }

        $this->load->view($this->config->item('theme').'routine_management_v/employee_routine/employee_routine_exe_all_list_view',$data);
    }


	public function testData(){
		$data['college_id_routine'] = $this->Employee_routine_model->getEmployeewisecoursename();
		print_r($data);
		die;
		$emp_id = $this->session->userdata('stake_details_id_fk');
		$college_id_routine = $this->Employee_routine_model->getCollegenewid($emp_id);
		$college_id_own = $this->Employee_routine_model->getCollegeid($emp_id);
		$college_id = [];
		if($college_id_routine == $college_id_own){
			 array_push($college_id,$college_id_routine);
		}else{
			 array_push($college_id,$college_id_routine,$college_id_own);
		}
		print_r($college_id);
	}

	public function employeeWeeklysubmission()  
    {
        $emp_id = $this->session->userdata('stake_details_id_fk');
		$college_ids = $this->Employee_routine_model->getCollegenewid($emp_id);
		$college_id = array_column($college_ids,'college_id_fk');
		$data['college_name'] = $this->Employee_routine_model->fetchCollegenames($college_id);
		$data['section_data'] = $this->Employee_routine_model->fetchSectiondata();
        if ($this->input->post()) {
            $this->form_validation->set_rules('academic_year', '<b>Academic Year</b>', 'required');
            $this->form_validation->set_rules('stud_year', '<b>Year</b>', 'required');
            $this->form_validation->set_rules('semester', '<b>Semester</b>', 'required');
            $this->form_validation->set_rules('discipline_id', '<b>Discipline</b>', 'required');
			$this->form_validation->set_rules('college_name', '<b>Polytechnic</b>', 'required');
			$this->form_validation->set_rules('section_name', '<b>Section</b>', 'required');
            if ($this->form_validation->run() == FALSE) {
            } else {
                $academic_year = $this->input->post('academic_year');
                $stud_year = $this->input->post('stud_year');
                $semester = $this->input->post('semester');
                $discipline_id = $this->input->post('discipline_id');
				$college_name = $this->input->post('college_name');
				$section_id = $this->input->post('section_name');
                $data['employee_id'] = $emp_id;
				
                //$data['period_time'] = $this->Employee_routine_model->getPeriodtimetimesnew($college_name, $academic_year, $discipline_id, $stud_year, $semester);
                
				$data['period_time'] = $this->Employee_routine_model->getPeriodtimetimesnew($college_name);
				$data['monday']     = $this->Employee_routine_model->getAllroutinesdetails_new($college_name, $academic_year, $discipline_id, $stud_year, $semester, 1,$section_id);
                $data['tuesday']    = $this->Employee_routine_model->getAllroutinesdetails_new($college_name, $academic_year, $discipline_id, $stud_year, $semester, 2,$section_id);
                $data['wednesday']  = $this->Employee_routine_model->getAllroutinesdetails_new($college_name, $academic_year, $discipline_id, $stud_year, $semester, 3,$section_id);
                $data['thrusday']   = $this->Employee_routine_model->getAllroutinesdetails_new($college_name, $academic_year, $discipline_id, $stud_year, $semester, 4,$section_id);
                $data['friday']     = $this->Employee_routine_model->getAllroutinesdetails_new($college_name, $academic_year, $discipline_id, $stud_year, $semester, 5,$section_id);
                $data['saturday']   = $this->Employee_routine_model->getAllroutinesdetails_new($college_name, $academic_year, $discipline_id, $stud_year, $semester, 6,$section_id);
                $data['countresult'] = $this->Employee_routine_model->countStatus_routine($college_name, $academic_year, $discipline_id, $stud_year, $semester);

                $data['forwardlist'] = $this->input->post();
				
            } 
        }
        $data['all_academic_year'] = $this->Employee_routine_model->get_allacademicyear();
        $data['semester'] = $this->Employee_routine_model->getAllsemester();
        $data['year'] = $this->Employee_routine_model->getAllyear();
        $data['all_course'] = $this->Employee_routine_model->getEmployeewisecoursename();
        $this->load->view($this->config->item('theme') . 'routine_management_v/employee_routine/employee_routine_class_execution_view', $data);
    }

    public function ajax_result_revart_back($routine_id = NULL)
    {
		
        $this->load->helper('string');
        if ($routine_id == NULL || strlen($routine_id) != 32) {
            echo '<div class="alert alert-danger">Something went wrong. Please try again</div>';
        } else {
            $data['routine_details_data'] = $this->Employee_routine_model->fetchRoutineperiodno($routine_id)[0];
			
			
            $data['routine_id'] = $routine_id;
            $data['all_reason'] = $this->Employee_routine_model->getAllreason();
            $this->load->view($this->config->item('theme') . 'routine_management_v/employee_routine/ajax/employee_class_execution_ajax_view', $data);
        }
    }

    public function confirm_result_revart($civil_part_id_pk = NULL)
    {
        
		
        $emp_id = $this->session->userdata('stake_details_id_fk');
        $routine_id = $this->input->POST('routine_hash');
		$period_no = $this->input->post('period_no');
		$execution_date = $this->input->post('execution_date');
		$routine_id_fk = $this->input->post('routine_id_fk');
        $college_id = $this->Employee_routine_model->getCollegenewid($emp_id);
        $data['routine_details_data'] = $this->Employee_routine_model->fetchRoutineperiodno($routine_id)[0];
        
		$data['routine_id'] =$this->input->POST('routine_id');
		$period_type = $data['routine_details_data']['period_type_fk'];
		
        $this->load->library('form_validation');
        
         
         $this->form_validation->set_rules('class_execution_cnfrm','<b>Class Execution</b>','required');


        if($this->input->post('class_execution_cnfrm') == 1){
            $this->form_validation->set_rules('execution_date','<b>Execution Date</b>','required');
            $this->form_validation->set_rules('revert_remarks','<b>Topic Coverd</b>','required|trim|max_length[255]');
            $this->form_validation->set_rules('registerd_class','<b>Register Class</b>','required|trim|max_length[3]|numeric');
            $this->form_validation->set_rules('attended_class','<b>Attend Class</b>','required|trim|max_length[3]|numeric');
        }else{
            $this->form_validation->set_rules('class_execution_reason','<b>Class Execution Reason</b>','required');
        }
        if ($this->form_validation->run() == FALSE) {
             $this->load->view($this->config->item('theme') . 'routine_management_v/employee_routine/ajax/employee_class_execution_ajax_view', $data);
        } else {
                
                if($this->input->post('class_execution_cnfrm')== 1){
                    $update_array = array(
                        'routine_details_id_fk'     => $this->input->post('routine_id_fk'),
                        'employee_id_fk'            => $emp_id,
                        'college_id_fk'             => $this->input->post('college_id_fk_exe'),
                        'class_execution_date'      => $this->input->post('execution_date'),
                        'topic_coverd'              => $this->input->post('class_execution_cnfrm'),
                        'topic_coverd_desc'         => $this->input->post('revert_remarks'),
                        'period_no_fk'              => $this->input->post('period_no'),
                        'remarks'                   => $this->input->post('remarks'),
                        'active_status'             => '1',
                        'status_code_fk'            => '5',
                        'entry_time'                => date('Y-m-d H:i:s'),
                        'entry_ip'                  => $this->input->ip_address(),
                    );
                }else{
                     $update_array = array(
                        'routine_details_id_fk'     => $this->input->post('routine_id_fk'),
                        'employee_id_fk'            => $emp_id,
                        'college_id_fk'             => $this->input->post('college_id_fk_exe'),
                        'class_execution_date'      => $this->input->post('execution_date'),
                        'topic_coverd'              => $this->input->post('class_execution_cnfrm'),
                        'topic_coverd_desc_no'      => $this->input->post('class_execution_reason'),
                        'period_no_fk'              => $this->input->post('period_no'),
                        'remarks'                   => $this->input->post('remarks'),
                        'active_status'             => '1',
                        'status_code_fk'            => '5',
                        'entry_time'                => date('Y-m-d H:i:s'),
                        'entry_ip'                  => $this->input->ip_address(),
                    );
                }
				
				//$period_type
				// if pratical class and select more than one teacher 
				if($period_type == '2'){
					$checkingExecutionavaila = $this->Employee_routine_model->checkingClassexecutionPractical($period_no,$execution_date,$routine_id_fk,$emp_id);
					//echo"practical";
				}else{
					$checkingExecutionavaila = $this->Employee_routine_model->checkingClassexecution($period_no,$execution_date,$routine_id_fk);
					//echo"theryo";
				}
				
				//print_r($checkingExecutionavaila);
				//die();
				
                if($checkingExecutionavaila == 0){
                    $result = $this->Employee_routine_model->insertClassexecutiondata($update_array);
                    if ($result) {
                        $data['code'] = 1;
                        $data['msg'] = "Class Execution Submitted Successfully...";
                    }
                }else{
                        $data['code'] = 0;
                        $data['msg'] = "Class Execution Already Submitted,Please Select Another Date For Execution";
                }
             $this->load->view($this->config->item('theme') . 'routine_management_v/employee_routine/ajax/employee_class_execution_ajax_view', $data);
        }
    }
    
}