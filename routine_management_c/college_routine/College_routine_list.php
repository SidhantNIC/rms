<?php
defined('BASEPATH') OR exit('No direct script access allowed' );

class College_routine_list extends NIC_Controller
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
				1 =>$this->config->item('theme_uri').'college_routine/js/college_routine_approve_revert.js',
		);
	}

    public function index($offset = NULL){	
       	$stake_id = $this->session->userdata('stake_id_fk');
        $stake_login_id = $this->session->userdata('stake_holder_login_id_pk');
        $college_id = $this->session->userdata('stake_details_id_fk');

        $this->load->library('pagination');
        $this->load->library('form_validation');
        $config['base_url']         = 'routine_management_c/college_routine/College_routine_list/index';
        $config['total_rows']       = $this->College_routine_model->get_count_routine_list()[0]['count'];
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
		
        $data['academic_year_data'] = $this->College_routine_model->get_allacademicyear();
        $data['all_days'] = $this->College_routine_model->getAlldays();
        $data['period_no'] = $this->College_routine_model->getAllperiodno();
        $data['period_type'] = $this->College_routine_model->getAllperiodtype();
        $data['year'] = $this->College_routine_model->getAllyear();
        $data['semester'] = $this->College_routine_model->getAllsemester();
        $data['discipline'] = $this->College_routine_model->get_all_course();
        $data['subject'] = $this->College_routine_model->getAllsubject();
        $data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
		$data['all_working_emp'] = $this->College_routine_model->get_workingarrangeemployee($college_id);
		$final_emp_list = array_merge($data['all_emp'],$data['all_working_emp']); 
		$final_emp_list_final = array_map("unserialize",array_unique(array_map("serialize",$final_emp_list)));
		$data['final_emp_list_data'] = $final_emp_list_final;
		$data['section_data'] = $this->College_routine_model->fetchSectiondata();
		
		$academic_session = $this->input->post('academic_session');
		
        $days_name = $this->input->post('days_name');
        $discipline_type = $this->input->post('discipline_type');
        $stud_year = $this->input->post('stud_year');
        $semester = $this->input->post('semester');
        $period_no = $this->input->post('period_no');
        $date = $this->input->post('date');
        $emp_id = $this->input->post('emp_id');
        $section_name = $this->input->post('section_name_s');
        
            if($this->input->post()){
                    $data['all_emp_list'] = $this->College_routine_model->get_all_routine_list($academic_session,$college_id,$days_name,$discipline_type,$stud_year,$semester,$period_no,$emp_id,$section_name);
                    $data['page_links'] = "";
                $this->load->view($this->config->item('theme').'routine_management_v/college_routine/routine_list_view',$data);
            }else{
                $data['all_emp_list'] = $this->College_routine_model->get_all_routine_list_all($college_id,$config['per_page'],$offset);
                $data['page_links'] = $this->pagination->create_links();
                $this->load->view($this->config->item('theme').'routine_management_v/college_routine/routine_list_view',$data);
            }
    }

    public function viewRoutinedetails($routine_manage_id_pk){
  
         $routine_id = $routine_manage_id_pk;
         $data['routine']= $this->College_routine_model->get_all_routine_list_using_id($routine_id);
         $data['practical_sub']= $this->College_routine_model->get_all_practical_sub($routine_id); 
         //$data['employee']= $this->College_routine_model->get_all_employee_lists($routine_id);
         $this->load->view($this->config->item('theme').'routine_management_v/college_routine/college_routine_all_view',$data);
        
     }

    public function approveRoutine(){
        $routine_id = $this->input->post('forwardid');
		
        if($routine_id !=''){
        $data= $this->College_routine_model->approveforwardRoutine($routine_id);
        
        if($data){
            $this->session->set_flashdata('success','All Routine has been successfully approved');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
            else{
                $this->session->set_flashdata('error','Something Went Wrong,Please Try Again');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
        }else{
            $this->session->set_flashdata('error','No Routine Found for Forward');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
        }
    }

    public function finalApprove(){
        $routine_id = $this->input->get('routine_id');
        $data= $this->College_routine_model->fionalapproveRoutine($routine_id);
        if($data){
            $this->session->set_flashdata('success','Routine has been approved');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
            else{
                $this->session->set_flashdata('error','Something Went Wrong,Please Try Again');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
    }

    public function finalReject(){
        $routine_id = $this->input->get('routine_id');
        $data= $this->College_routine_model->fionalrejectRoutine($routine_id);
        if($data){
            $this->session->set_flashdata('success','Routine has been rejected');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
            else{
                $this->session->set_flashdata('error','Something Went Wrong,Please Try Again');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
    }
    //class execution approved
    public function classExecutionapprove(){
        $excecution_id_pk = $this->input->get('excecution_id_pk');
        echo $excecution_id_pk;
    exit;
        $data= $this->College_routine_model->executionApprove($excecution_id_pk);
        if($data){
            $this->session->set_flashdata('success','Execution Routine has been approved');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
            else{
                $this->session->set_flashdata('error','Something Went Wrong,Please Try Again');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
    }
    // class execution reject   
    public function classExecutionreject(){
        $excecution_id_pk = $this->input->get('excecution_id_pk');
        $data= $this->College_routine_model->executionReject($excecution_id_pk);
        if($data){
            $this->session->set_flashdata('success','Execution Routine has been rejected');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
            else{
                $this->session->set_flashdata('error','Something Went Wrong,Please Try Again');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
    }

      


    public function confirm_result_revart1($routine_manage_id=NULL)
    {
        $revertRemarks = $this->input->POST('approve_revirt_dec');
        $revertId = $this->input->POST('clg_hash');
        $data= $this->College_routine_model->revertRoutine($revertId,$revertRemarks);
         $data['revert_data']= $this->College_routine_model->get_all_routine_list_using_id_revert($this->input->post('routine_hash'));
        if($data){
           $data['code'] = 1;
           $data['msg'] = "Routine has been reveted to operator";
        }else{
              $data['code'] = 0;
              $data['msg'] = "Something went wrong, Please Try again";
        }
         $this->load->view($this->config->item('theme').'routine_management_v/college_routine/ajax/ajax_routine_approval_view',$data);
    }


    public function ajax_result_revart_back($routine_manage_id = NULL)
    {   
        $routine_id = $routine_manage_id;
        $this->load->helper('string');
        if($routine_id == NULL || strlen($routine_id) != 32)
        {
          echo '<div class="alert alert-danger">Something went wrong. Please try again</div>';
        } 
        else 
        {
          $data['revert_data']= $this->College_routine_model->get_all_routine_list_using_id_revert($routine_id);
         
          $data['routine_manage_id_hash']= $routine_manage_id;
          $this->load->view($this->config->item('theme').'routine_management_v/college_routine/ajax/ajax_routine_approval_view',$data);
        }
        
    }

  public function confirm_result_revart($routine_manage_id_hash=NULL)
  {
   
    $routine_manage_id_hash = $this->input->POST('routine_manage_id_hash');
    $data['revert_data']= $this->College_routine_model->get_all_routine_list_using_id_revert($routine_manage_id_hash);
    $data['routine_manage_id_hash']= $routine_manage_id_hash;
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    $config = array(
                array(
                  'field' => 'approve_revirt_dec',
                  'label' => '<b>Revert Reason</b>',
                  'rules' => 'trim|required',
                  'errors'=> array(
                    'regex_match' => 'The %s field is invalid'
                  )
                )
            );
    $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE)
        {
           $this->load->view($this->config->item('theme').'routine_management_v/college_routine/ajax/ajax_routine_approval_view',$data);
        }
      else
      {
        $update_array = array(
            'status_code'                   => '3',
            'routine_revart_time'           => date('Y-m-d H:i:s'),
            'routine_revart_ip'             => $this->input->ip_address(),
            'routine_revart_by'             => $this->session->userdata('stake_holder_login_id_pk'),
            'revert_reason'                 => $this->input->post('approve_revirt_dec')
          );
       
          $result = $this->College_routine_model->revertRoutine($routine_manage_id_hash,$update_array);
          

        if($result)
        {
          $data['code'] = 1;
          $data['msg'] = "Routine Reverted Successfully...";
        }
        $this->load->view($this->config->item('theme').'routine_management_v/college_routine/ajax/ajax_routine_approval_view',$data);
    }
  
    
  }

  // Start Revart back of result by Admin Added by Waseem on 31-12-2019


// approve all routine using check box
  public function checkBoxsubmit(){
    $routine_id = $this->input->post('routine_id');
  
    if($routine_id == ''){
       $this->session->set_flashdata('error','No Routine Selected OR Routine Already Approved');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
    }else{
    $data = $this->College_routine_model->approveAllroutinedata($routine_id);
    if($data){
            $this->session->set_flashdata('success','Routine has been approved');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
            else{
                $this->session->set_flashdata('error','Something Went Wrong,Please Try Again');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
    }


  }

  public function forwardList(){

    $this->load->library('form_validation');
     $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
     $data['year'] = $this->College_routine_model->getAllyear();
     $data['semester'] = $this->College_routine_model->getAllsemester();
     $data['discipline'] = $this->College_routine_model->get_all_course();
    

     if($this->input->post()){
        $academic_year = $this->input->post('academic_year');
        $discipline_type = $this->input->post('discipline_type');
        $stud_year = $this->input->post('stud_year');
        $semester = $this->input->post('semester');
		$college_id = $this->session->userdata('stake_details_id_fk');
        $data['forwardlist'] = $this->input->post();

        $this->form_validation->set_rules('academic_year','Academic Session','required');
        $this->form_validation->set_rules('discipline_type','Discipline Type','required');
        $this->form_validation->set_rules('stud_year','Year','required');
        $this->form_validation->set_rules('semester','Semester','required');
        

     if($this->form_validation->run()!= FALSE){
		 $data['fridays'] = $this->College_routine_model->getFridayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);
		
        $data['result'] = $this->College_routine_model->get_allforwarddata($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['period_time'] = $this->College_routine_model->getPeriodtime($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['mondays'] = $this->College_routine_model->getMondayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['tuesdays'] = $this->College_routine_model->getTuesdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['wednesdays'] = $this->College_routine_model->getWednesdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['thrusdays'] = $this->College_routine_model->getThrusdatroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);
		
        
        $data['saturdays'] = $this->College_routine_model->getSataurdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);
		
		
        }else{
            $data['forwardlist'] = $this->input->post();
            $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
            $data['year'] = $this->College_routine_model->getAllyear();
            $data['semester'] = $this->College_routine_model->getAllsemester();
            $data['discipline'] = $this->College_routine_model->get_all_course();
            }
     }
     $this->load->view($this->config->item('theme').'routine_management_v/college_routine/college_routine_all_forward_list',$data);
  }

//routine list bulk approve
public function approveallfRoutine(){
$routine_id = $this->input->post('forwardid');
if($routine_id !=''){
$data= $this->College_routine_model->approveforwardRoutine($routine_id);

if($data){
    $this->session->set_flashdata('success','All Routine has been approved');
        redirect('admin/routine_management_c/college_routine/College_routine_list');
    }
    else{
        $this->session->set_flashdata('error','Something Went Wrong,Please Try Again');
        redirect('admin/routine_management_c/college_routine/College_routine_list');
    }
}else{
    $this->session->set_flashdata('error','No Routine Found for Approved');
        redirect('admin/routine_management_c/college_routine/College_routine_list');
}
}
    
    public function checkOverlaping(){
    $college_id = $this->session->userdata('stake_details_id_fk');
    $data['result'] = $this->College_routine_model->overlapingCheking($college_id);
    $this->load->view($this->config->item('theme').'routine_management_v/college_routine/college_routine_overlapping_checking',$data);
    }
	
	//.........Edit Mode On College Login ...........//
	public function editRoutine($routine_manage_id_pk){
		//die();
            $this->load->library('form_validation');
            $this->load->library('session');
            $routine_id = $routine_manage_id_pk;
            $stake_id = $this->session->userdata('stake_id_fk');
            $stake_login_id = $this->session->userdata('stake_holder_login_id_pk');
            $college_id = $this->session->userdata('stake_details_id_fk');
            //$operator_id = $this->session->userdata('stake_holder_login_id_pk');

            //All Post Value
            
            $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
            $data['all_days']  = $this->College_routine_model->getAlldays();
            $data['period_no'] = $this->College_routine_model->getAllperiodno();
            $data['period_type'] = $this->College_routine_model->getAllperiodtype();
            $data['year'] = $this->College_routine_model->getAllyear();
            $data['semester'] = $this->College_routine_model->getAllsemester();
            $data['discipline'] = $this->College_routine_model->get_all_course();
            
            //$data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
			$data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
			$data['all_working_emp'] = $this->College_routine_model->get_workingarrangeemployee($college_id);
			$final_emp_list = array_merge($data['all_emp'],$data['all_working_emp']); 
			$final_emp_list_final = array_map("unserialize",array_unique(array_map("serialize",$final_emp_list)));
			$data['final_emp_list_data'] = $final_emp_list_final;
			
            $data['all_details'] = $this->College_routine_model->get_all_routine_list_using_id($routine_id);
             
        
            $course_id_pk = $data['all_details'][0]['course_id_pk'];
            $semester_id = $data['all_details'][0]['sem_id'];
			$operator_id = $data['all_details'][0]['operator_id_fk'];
			
            
            $data['subject'] = $this->College_routine_model->getAlleditsubject($course_id_pk,$semester_id);
            $data['prac_subject'] = $this->College_routine_model->getAllpracsubjectedit($course_id_pk,$semester_id);
            $data['employee_details_ids'] = $this->College_routine_model->getEmployeeids($routine_id);
            $data['subject_details_ids'] = $this->College_routine_model->getSubjectsids($routine_id);
            $data['routine_id'] = $routine_manage_id_pk;

            $routine_id_fk = $this->input->post('routine_id_fk');
            $routine_unique_id = $this->input->post('routine_unique_id');
            $academic_year = $this->input->post('academic_year');
            $stud_year = $this->input->post('stud_year');
            $semester = $this->input->post('semester');
            $discipline_type = $this->input->post('discipline_type');
            $days_name = $this->input->post('days_name');
            $period_no = $this->input->post('period_no');
            $period_start_time = $this->input->post('period_start_time');
            $period_end_time = $this->input->post('period_end_time');
            $period_type = $this->input->post('period_type');
            $room_no = $this->input->post('room_no');
            $subj_name = $this->input->post('subj_name');
            $prac_subj_name = $this->input->post('prac_subj_name');
            $emp_id = $this->input->post('emp_id');
            $status_code = $this->input->post('status_code');


            if($period_type == '3' ||$period_type == '4' ){
            $this->form_validation->set_rules('academic_year','Academic Year','required');
            $this->form_validation->set_rules('stud_year','Student Year','required');
            $this->form_validation->set_rules('semester','Semester','required');
            $this->form_validation->set_rules('discipline_type','Discipline Type','required');  
            $this->form_validation->set_rules('days_name','Days','required');
            $this->form_validation->set_rules('period_no','Period Number','required');
            $this->form_validation->set_rules('period_start_time','Period Start Time','required');
            $this->form_validation->set_rules('period_end_time','Period End Time','required');
            $this->form_validation->set_rules('period_type','Period Type','required');
            if($this->form_validation->run()!=FALSE){
                 $data = array(
                            'routine_unique_id'=>$routine_unique_id,
                            'college_id_fk'=>$college_id,
                            'operator_id_fk'=>$operator_id,
                            'academic_year_fk'=>$academic_year,
                            'stud_year'=>$stud_year,
                            'semester'=>$semester, 
                            'discipline_id_fk'=>$discipline_type,
                            'days_id_fk'=>$days_name,
                            'period_no'=>$period_no,
                            'period_start_time'=>$period_start_time,
                            'period_end_time'=>$period_end_time,
                            'period_type_fk'=>$period_type,
                            'status_code'=>$status_code,
                            'active_status'=>1,
                            'updated_time'=>date('Y-m-d H:i:s'),
                            'updated_ip'=>$this->input->ip_address()
                        );

                $result = $this->College_routine_model->UpdatebasicRoutinelist($data,$routine_id_fk);
                    if($result){
                        $this->session->set_flashdata('success','Routine has been successfully updated ');
                        redirect('admin/routine_management_c/college_routine/College_routine_list');
                 }      
            }
            else{
                $this->session->set_flashdata('error','Something Went Wrong, Please Try Again');
            }
        }

        //Second Part Start from here
        if($period_type == '1'){
            $this->form_validation->set_rules('academic_year','Academic Year','required');
            $this->form_validation->set_rules('stud_year','Student Year','required');
            $this->form_validation->set_rules('semester','Semester','required');
            $this->form_validation->set_rules('discipline_type','Discipline Type','required');  
            $this->form_validation->set_rules('days_name','Days','required');
            $this->form_validation->set_rules('period_no','Period Number','required');
            $this->form_validation->set_rules('period_start_time','Period Start Time','required');
            $this->form_validation->set_rules('period_end_time','Period End Time','required');
            $this->form_validation->set_rules('period_type','Period Type','required');
            $this->form_validation->set_rules('room_no','Room No','required');
            $this->form_validation->set_rules('subj_name','Theory Subject','required');
            $this->form_validation->set_rules('emp_id[]','Employee Name','required');

            if($this->form_validation->run()!=FALSE){
                $data = array(
                    'college_id_fk'=>$college_id,
                    'operator_id_fk'=>$operator_id,
                    'academic_year_fk'=>$academic_year,
                    'year_id_fk'=>$stud_year,
                    'semester_id_fk'=>$semester,
                    'discipline_id_fk'=>$discipline_type,
                    'days_id_fk'=>$days_name,
                    'period_no'=>$period_no,
                    'period_start_time'=>$period_start_time,
                    'period_end_time'=>$period_end_time,
                    'period_type_fk'=>$period_type,
                    'room_no'=>$room_no,
                    'subject_id_fk'=>$subj_name,
                    'status_code'=>$status_code,
                    'updated_time'=>date('Y-m-d H:i:s'),
                    'updated_ip'=>$this->input->ip_address(),
                    'status_code'=>$status_code,
                    'active_status'=>1,
					'section_id_fk' =>3,
                    'routine_unique_id'=>$routine_unique_id
                );
                $theoryType = $this->College_routine_model->updateRoutinelist($routine_id_fk);
                if($theoryType == '1'){
                     $ins_id = $this->College_routine_model->insertRoutinelist($data);
               
                    foreach($emp_id as $value){
                      $ins = array();
                      $ins['routine_details_fk']=$ins_id;
                      $ins['employee_id']=$value;
                      $ins['entry_time']=date('Y-m-d H:i:s');
                      $ins['entry_ip']=$this->input->ip_address();
                      $ins['active_status']='1';
                      $this->College_routine_model->insertEmployeedatalist($ins);
                    }
                     $this->session->set_flashdata('success','Routine Updated Successfully');
                     redirect('admin/routine_management_c/college_routine/College_routine_list');
                }
               
                       
           }
            else{
               // $this->load->view($this->config->item('theme').'routine/routine_add_view',$data);
            }
        }

        if($period_type == '2'){
            $this->form_validation->set_rules('academic_year','Academic Year','required');
            $this->form_validation->set_rules('stud_year','Student Year','required');
            $this->form_validation->set_rules('semester','Semester','required');
            $this->form_validation->set_rules('discipline_type','Discipline Type','required');  
            $this->form_validation->set_rules('days_name','Days','required');
            $this->form_validation->set_rules('period_no','Period Number','required');
            $this->form_validation->set_rules('period_start_time','Period Start Time','required');
            $this->form_validation->set_rules('period_end_time','Period End Time','required');
            $this->form_validation->set_rules('period_type','Period Type','required');
            $this->form_validation->set_rules('room_no','Room No','required');
            $this->form_validation->set_rules('prac_subj_name[]','Practical Subject','required');
            $this->form_validation->set_rules('emp_id[]','Employee Name','required');
            if($this->form_validation->run()!=FALSE){
                $data = array(
                    'college_id_fk'=>$college_id,
                    'operator_id_fk'=>$operator_id,
                    'academic_year_fk'=>$academic_year,
                    'year_id_fk'=>$stud_year,
                    'semester_id_fk'=>$semester,
                    'discipline_id_fk'=>$discipline_type,
                    'days_id_fk'=>$days_name,
                    'period_no'=>$period_no,
                    'period_start_time'=>$period_start_time,
                    'period_end_time'=>$period_end_time,
                    'period_type_fk'=>$period_type,
                    'room_no'=>$room_no,
                    'status_code'=>$status_code,
                    'entry_time'=>date('Y-m-d H:i:s'),
                    'updated_time'=>date('Y-m-d H:i:s'),
                    'updated_ip'=>$this->input->ip_address(),
                    'active_status'=>1,
					'section_id_fk' =>3,
                    'routine_unique_id'=>$routine_unique_id
                );

                   $practicalType = $this->College_routine_model->updateRoutinelist($routine_id_fk);
                   if($practicalType == '1'){
                     $ins_id = $this->College_routine_model->insertRoutinelist($data);
                         foreach($emp_id as $value){
                              $ins = array();
                              $ins['routine_details_fk']=$ins_id;
                              $ins['employee_id']=$value;
                              $ins['entry_time']=date('Y-m-d H:i:s');
                              $ins['entry_ip']=$this->input->ip_address();
                              $ins['active_status']='1';
                              $this->College_routine_model->insertEmployeedatalist($ins);
                            }
                        foreach($prac_subj_name as $practical_sub){

                              $ins_prac = array();
                              $ins_prac['routine_details_fk']=$ins_id;
                              $ins_prac['subject_id']=$practical_sub;
                              $ins_prac['entry_time']=date('Y-m-d H:i:s');
                              $ins_prac['entry_ip']=$this->input->ip_address();
                              $ins_prac['active_status']='1';
                              $this->College_routine_model->insertSubjectdetails($ins_prac);
                            }
                        $this->session->set_flashdata('success','Routine Updated Successfully');
                        redirect('admin/routine_management_c/college_routine/College_routine_list');
                   }
                    
            }
        }

            $this->load->view($this->config->item('theme').'routine_management_v/college_routine/routine_edit_view',$data);
     }
        public function getPeriodtypedata(){
        $period_type = $this->input->get('period_type');
        $discipline_type = $this->input->get('discipline_type');
        $semester = $this->input->get('semester');
        $result = $this->College_routine_model->getPeriodlist($period_type,$discipline_type,$semester);
        ?>
        <option value="">--Please Select Subject --</option>
        <?php 
                foreach($result as $result){
                ?>
        <option value="<?php echo $result['subject_code']; ?>"><?php echo $result['subject_description']; ?></option>
        <?php
        }

    }
	
	   public function getSemesterdata(){
        $semestedid = $this->input->get('semestedid');
        $result = $this->College_routine_model->getsemesterlist($semestedid);
        ?>
        <option value="">--Please Select Semester --</option>
        <?php 
            foreach($result as $result){
            ?>
        <option value="<?php echo $result['id']; ?>"><?php echo $result['description']; ?></option>
        <?php
            }
        }

        public function getPeriodtimedata(){
        $college_id = $this->session->userdata('stake_details_id_fk');
        $operator_id = $this->session->userdata('stake_holder_login_id_pk');
        $period_no = $this->input->get('period_no');
        $result = $this->College_routine_model->fetchPeriodtime($period_no,$college_id,$operator_id);
       // $output  = array('period_start_time'=>$result['period_start_time'],'period_end_time'=>$result['period_end_time']);
        echo json_encode($result);
    }
	
	 public function approveRoutinelists($routine_manage_id_pk =NULL){
       
        $data= $this->College_routine_model->approveRoutineusingid($routine_manage_id_pk);
        if($data){
            $this->session->set_flashdata('success','Routine has been approved');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
            else{
                $this->session->set_flashdata('error','Something Went Wrong,Please Try Again');
                redirect('admin/routine_management_c/college_routine/College_routine_list');
            }
        
    }
	
	//..............New Chnange For Routine Display And Download.....On 20-12-2021
	public function forwardList_new()
    {

        $this->load->library('form_validation');
        $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
        $data['year'] = $this->College_routine_model->getAllyear();
        $data['semester'] = $this->College_routine_model->getAllsemester();
        $data['discipline'] = $this->College_routine_model->get_all_course();
		$data['section_data'] = $this->College_routine_model->fetchSectiondata();


        if ($this->input->post()) {
			
            $academic_year = $this->input->post('academic_year');
            $discipline_type = $this->input->post('discipline_type');
            $stud_year = $this->input->post('stud_year');
            $semester = $this->input->post('semester');
			$section_name = $this->input->post('section_name_s');
            $status_code = $this->input->post('routine_mode');
            $college_id = $this->session->userdata('stake_details_id_fk');
            $data['forwardlist'] = $this->input->post();

            $this->form_validation->set_rules('academic_year', '<b>Academic Session</b>', 'required');
            $this->form_validation->set_rules('discipline_type', '<b>Discipline Type</b>', 'required');
            $this->form_validation->set_rules('stud_year', '<b>Year</b>', 'required');
            $this->form_validation->set_rules('semester', '<b>Semester</b>', 'required');
            $this->form_validation->set_rules('routine_mode', '<b>Routine Mode</b>', 'required');


            if ($this->form_validation->run() != FALSE) {

                $data['period_time'] = $this->College_routine_model->getPeriodtime($college_id, $discipline_type, $academic_year, $semester,$stud_year);
                $data['monday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 1,$section_name);
                $data['tuesday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 2,$section_name);
                $data['wednesday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 3,$section_name);
                $data['thrusday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 4,$section_name);
                $data['friday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 5,$section_name);
                $data['saturday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 6,$section_name);
                $data['countresult'] = $this->College_routine_model->countStatus($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year);
				
				
				
                $data['forwardlist'] = $this->input->post();
				
            } else {

                $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
                $data['year'] = $this->College_routine_model->getAllyear();
                $data['semester'] = $this->College_routine_model->getAllsemester();
                $data['discipline'] = $this->College_routine_model->get_all_course();
            }
        }
        $this->load->view($this->config->item('theme') . 'routine_management_v/college_routine/college_routine_all_forward_list_new', $data);
    }
	
	public function downloadRoutineCollege_new()
    {
        $academic_year = $this->input->post('academic_year');
        $discipline_type = $this->input->post('discipline_type');
        $stud_year = $this->input->post('stud_year');
        $semester = $this->input->post('semester');
        $status_code = $this->input->post('routine_mode');
		$section_name = $this->input->post('section_name_s');
        $college_id = $this->session->userdata('stake_details_id_fk');
        $data['forwardlist'] = $this->input->post();
		
        $data['period_time'] = $this->College_routine_model->getPeriodtime($college_id, $discipline_type, $academic_year, $semester,$stud_year);
        $data['monday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 1,$section_name);
		$data['tuesday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 2,$section_name);
		$data['wednesday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 3,$section_name);
		$data['thrusday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 4,$section_name);
		$data['friday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 5,$section_name);
		$data['saturday'] = $this->College_routine_model->getAllroutinesdetailssim($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year, 6,$section_name);
        $data['countresult'] = $this->College_routine_model->countStatus($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year);
		
        $html = $this->load->view($this->config->item('theme') . 'routine_management_v/college_routine/college_routine_online_offline_pdf_download_view_new', $data, true);
		
        $pdfFilePath = "Routine.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->AddPage('L');
        $this->m_pdf->pdf->WriteHTML($html, 2);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
}
?>