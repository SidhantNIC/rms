<?php
defined('BASEPATH') OR exit('No direct script access allowed' );

class Routine_add extends NIC_Controller
{
    public function __construct()
    {
		parent::__construct();
		parent::check_privilege(159);
		$this->load->library('user_agent');
        //$this->load->library('pagination');
		$this->load->helper('url');
        $this->load->helper('routine_management_helper');
		$this->load->model('routine_management_m/routine/College_routine_model');
        //get_instance()->load->helper('routine_management_helper');
        //\Mpdf\Mpdf::__construct([array $config = []]);
		//$this->output->enable_profiler(TRUE);
		
        
	}

	public function index(){
  
        $stake_id = $this->session->userdata('stake_id_fk');
        $stake_login_id = $this->session->userdata('stake_holder_login_id_pk');
        $college_id = $this->session->userdata('stake_details_id_fk');
        $operator_id = $this->session->userdata('stake_holder_login_id_pk');

        $data['routine_unique_id'] = 'R'.mt_rand(100000,999999);
        $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
        $data['all_days'] = $this->College_routine_model->getAlldays();
        $data['period_no'] = $this->College_routine_model->getAllperiodno();
        $data['period_type'] = $this->College_routine_model->getAllperiodtype();
        $data['year'] = $this->College_routine_model->getAllyear();
        $data['semester'] = $this->College_routine_model->getAllsemester();
        $data['discipline'] = $this->College_routine_model->get_all_course();
        $data['subject'] = $this->College_routine_model->getAllsubject();
		$data['tutorial_subject'] = $this->College_routine_model->getAlltutorialsubject();
        $data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
		$data['all_working_emp'] = $this->College_routine_model->get_workingarrangeemployee($college_id);
		$data['section_data'] = $this->College_routine_model->fetchSectiondata();
		$final_emp_list = array_merge($data['all_emp'],$data['all_working_emp']); 
		$final_emp_list_final = array_map("unserialize",array_unique(array_map("serialize",$final_emp_list)));
		$data['final_emp_list_data'] = $final_emp_list_final;

        $this->load->library('form_validation');
        $this->load->library('session');
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
		$tutoraial_subj_name = $this->input->post('tutoraial_subj_name');
        $prac_subj_name = $this->input->post('prac_subj_name');
        $emp_id = $this->input->post('emp_id');
		$section_name = $this->input->post('section_name');
        
        //............Theory.....//
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
			$this->form_validation->set_rules('section_name', 'Section', 'required');



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
                    'status_code'=>'1',
                    'entry_time'=>date('Y-m-d H:i:s'),
                    'entry_ip'=>$this->input->ip_address(),
                    'active_status'=>'1',
                    'routine_unique_id'=>'R'.rand(8,1000000),
					'section_id_fk' => $section_name
                );

                //.........Checking here, same routine inserted or not?
                $checkRoutine = $this->College_routine_model->routineCheck($academic_year,$period_no,$college_id,$operator_id,$days_name,$semester,$discipline_type, $section_name);
                
				if($checkRoutine >0){
                        $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
                        $data['all_days'] = $this->College_routine_model->getAlldays();
                        $data['period_no'] = $this->College_routine_model->getAllperiodno();
                        $data['period_type'] = $this->College_routine_model->getAllperiodtype();
                        $data['year'] = $this->College_routine_model->getAllyear();
                        $data['semester'] = $this->College_routine_model->getAllsemester();
                        $data['discipline'] = $this->College_routine_model->get_all_course();
                        $data['subject'] = $this->College_routine_model->getAllsubject();
                        $data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
                        $data['postData'] = $this->input->post();
                        $data['tehory_subject'] = $this->College_routine_model->get_theory_subject($semester,$discipline_type);
						$data['section_data'] = $this->College_routine_model->fetchSectiondata();
						$this->session->set_flashdata('error','Routine has been already created');
                }else{
                    $ins_id = $this->College_routine_model->insertRoutinelist($data);
               
                    //foreach($emp_id as $value){
						
                      $ins = array();
                      $ins['routine_details_fk']=$ins_id;
                      //$ins['employee_id']=$value;
					  $ins['employee_id']=$emp_id;
                      $ins['entry_time']=date('Y-m-d H:i:s');
                      $ins['entry_ip']=$this->input->ip_address();
                      $ins['active_status']='1';
                      $this->College_routine_model->insertEmployeedatalist($ins);
					  
                    //}
                        $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
                        $data['all_days'] = $this->College_routine_model->getAlldays();
                        $data['period_no'] = $this->College_routine_model->getAllperiodno();
                        $data['period_type'] = $this->College_routine_model->getAllperiodtype();
                        $data['year'] = $this->College_routine_model->getAllyear();
                        $data['semester'] = $this->College_routine_model->getAllsemester();
                        $data['discipline'] = $this->College_routine_model->get_all_course();
                        $data['subject'] = $this->College_routine_model->getAllsubject();
                        //$data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
						$data['final_emp_list_data'] = $final_emp_list_final;
                        $data['postData'] = $this->input->post();
                        $data['tehory_subject'] = $this->College_routine_model->get_theory_subject($semester,$discipline_type);
                        // print_r($data['tehory_subject']);
                        // exit();
						$msg = 'Routine Created Successfully'. $data['routine_unique_id'];
                        $this->session->set_flashdata('success',$msg);
                }
                
           }
            else{
               $data['tehory_subject'] = $this->College_routine_model->get_theory_subject($semester,$discipline_type);
            }
        }
		//.............Tutorial Subject................//
        if($period_type == '5'){

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
            $this->form_validation->set_rules('tutoraial_subj_name','Tutorial Subject','required');
            $this->form_validation->set_rules('emp_id[]','Employee Name','required');
			$this->form_validation->set_rules('section_name', 'Section', 'required');


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
                    'subject_id_fk'=>$tutoraial_subj_name,
                    'status_code'=>'1',
                    'entry_time'=>date('Y-m-d H:i:s'),
                    'entry_ip'=>$this->input->ip_address(),
                    'active_status'=>'1',
                    'routine_unique_id'=>'R'.rand(8,1000000),
					'section_id_fk' => $section_name
                );

                //.........Checking here, same routine inserted or not?
                $checkRoutine = $this->College_routine_model->routineCheck($period_no,$college_id,$operator_id,$days_name,$semester,$discipline_type,$section_name);
                if($checkRoutine >0){
                        $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
                        $data['all_days'] = $this->College_routine_model->getAlldays();
                        $data['period_no'] = $this->College_routine_model->getAllperiodno();
                        $data['period_type'] = $this->College_routine_model->getAllperiodtype();
                        $data['year'] = $this->College_routine_model->getAllyear();
                        $data['semester'] = $this->College_routine_model->getAllsemester();
                        $data['discipline'] = $this->College_routine_model->get_all_course();
                        $data['subject'] = $this->College_routine_model->getAllsubject();
                        $data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
                        $data['postData'] = $this->input->post();
                        $data['tutorial_subject'] = $this->College_routine_model->get_tutorial_subject($semester,$discipline_type);
						$data['section_data'] = $this->College_routine_model->fetchSectiondata();
                    $this->session->set_flashdata('error','Routine has been already created');
                }else{
                    $ins_id = $this->College_routine_model->insertRoutinelist($data);
               
                    //foreach($emp_id as $value){
						
                      $ins = array();
                      $ins['routine_details_fk']=$ins_id;
                      //$ins['employee_id']=$value;
					  $ins['employee_id']=$emp_id;
                      $ins['entry_time']=date('Y-m-d H:i:s');
                      $ins['entry_ip']=$this->input->ip_address();
                      $ins['active_status']='1';
                      $this->College_routine_model->insertEmployeedatalist($ins);
					  
                    //}
                        $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
                        $data['all_days'] = $this->College_routine_model->getAlldays();
                        $data['period_no'] = $this->College_routine_model->getAllperiodno();
                        $data['period_type'] = $this->College_routine_model->getAllperiodtype();
                        $data['year'] = $this->College_routine_model->getAllyear();
                        $data['semester'] = $this->College_routine_model->getAllsemester();
                        $data['discipline'] = $this->College_routine_model->get_all_course();
                        $data['subject'] = $this->College_routine_model->getAllsubject();
                        //$data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
						$data['final_emp_list_data'] = $final_emp_list_final;
                        
                        $data['tutorial_subject'] = $this->College_routine_model->get_tutorial_subject($semester,$discipline_type);
						$data['section_data'] = $this->College_routine_model->fetchSectiondata();
						$data['postData'] = $this->input->post();
                        // print_r($data['tehory_subject']);
                        // exit();

                        $msg = 'Routine Created Successfully'. $data['routine_unique_id'];
                        $this->session->set_flashdata('success',$msg);
                }
                
           }
            else{
              $data['tutorial_subject'] = $this->College_routine_model->get_tutorial_subject($semester,$discipline_type);
            }
        }
        //.....................Tutorial Subject End........................//
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
			$this->form_validation->set_rules('section_name', 'Section', 'required');
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
                    'status_code'=>'1',
                    'entry_time'=>date('Y-m-d H:i:s'),
                    'entry_ip'=>$this->input->ip_address(),
                    'active_status'=>'1',
                    'routine_unique_id'=>'R'.rand(8,1000000),
					'section_id_fk' => $section_name
                );

                $checkRoutine = $this->College_routine_model->routineCheck($period_no,$college_id,$operator_id,$days_name,$semester,$discipline_type);
                if($checkRoutine >0){
                     $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
                        $data['all_days'] = $this->College_routine_model->getAlldays();
                        $data['period_no'] = $this->College_routine_model->getAllperiodno();
                        $data['period_type'] = $this->College_routine_model->getAllperiodtype();
                        $data['year'] = $this->College_routine_model->getAllyear();
                        $data['semester'] = $this->College_routine_model->getAllsemester();
                        $data['discipline'] = $this->College_routine_model->get_all_course();
                        $data['subject'] = $this->College_routine_model->getAllsubject();
                        //$data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
						$data['final_emp_list_data'] = $final_emp_list_final;
                        $data['postData'] = $this->input->post();
                       $data['prac_subject'] = $this->College_routine_model->get_practical_subject($semester,$discipline_type);
					   $data['section_data'] = $this->College_routine_model->fetchSectiondata();
                    $this->session->set_flashdata('error','Routine has been already created');
                }else{
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
                    $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
                    $data['all_days'] = $this->College_routine_model->getAlldays();
                    $data['period_no'] = $this->College_routine_model->getAllperiodno();
                    $data['period_type'] = $this->College_routine_model->getAllperiodtype();
                    $data['year'] = $this->College_routine_model->getAllyear();
                    $data['semester'] = $this->College_routine_model->getAllsemester();
                    $data['discipline'] = $this->College_routine_model->get_all_course();
                    $data['subject'] = $this->College_routine_model->getAllsubject();
                    //$data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
					$data['final_emp_list_data'] = $final_emp_list_final;
                    $data['postData'] = $this->input->post();
                    $data['prac_subject'] = $this->College_routine_model->get_practical_subject($semester,$discipline_type);
					$data['section_data'] = $this->College_routine_model->fetchSectiondata();
                    $msg = 'Routine Created Successfully'. $data['routine_unique_id'];
                    $this->session->set_flashdata('success',$msg);
                }
                   
            }else{
                $data['prac_subject'] = $this->College_routine_model->get_practical_subject($semester,$discipline_type);
            }

            

        }
        if($period_type == '3' || $period_type == '4'){
            $this->form_validation->set_rules('academic_year','Academic Year','required');
            $this->form_validation->set_rules('stud_year','Student Year','required');
            $this->form_validation->set_rules('semester','Semester','required');
            $this->form_validation->set_rules('discipline_type','Discipline Type','required');  
            $this->form_validation->set_rules('days_name','Days','required');
            $this->form_validation->set_rules('period_no','Period Number','required');
            $this->form_validation->set_rules('period_start_time','Period Start Time','required');
            $this->form_validation->set_rules('period_end_time','Period End Time','required');
            $this->form_validation->set_rules('period_type','Period Type','required');
			$this->form_validation->set_rules('section_name', 'Section', 'required');
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
                    'status_code'=>'1',
                    'entry_time'=>date('Y-m-d H:i:s'),
                    'entry_ip'=>$this->input->ip_address(),
                    'active_status'=>'1',
                    'routine_unique_id'=>'R'.rand(8,1000000),
					'section_id_fk' => $section_name
                );
                $checkRoutine = $this->College_routine_model->routineCheck($period_no,$college_id,$operator_id,$days_name,$semester,$discipline_type);
                if($checkRoutine >0){
                     $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
                        $data['all_days'] = $this->College_routine_model->getAlldays();
                        $data['period_no'] = $this->College_routine_model->getAllperiodno();
                        $data['period_type'] = $this->College_routine_model->getAllperiodtype();
                        $data['year'] = $this->College_routine_model->getAllyear();
                        $data['semester'] = $this->College_routine_model->getAllsemester();
                        $data['discipline'] = $this->College_routine_model->get_all_course();
                        $data['subject'] = $this->College_routine_model->getAllsubject();
						$data['section_data'] = $this->College_routine_model->fetchSectiondata();
                       // $data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
					   $data['final_emp_list_data'] = $final_emp_list_final;
                        $data['postData'] = $this->input->post();
                       //$data['prac_subject'] = $this->College_routine_model->get_practical_subject($semester,$discipline_type);
                    $this->session->set_flashdata('error','Routine has been already created');
                }else{
                 $result = $this->College_routine_model->insertbasicRoutinelist($data);
                 if($result){
                    $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
                    $data['all_days'] = $this->College_routine_model->getAlldays();
                    $data['period_no'] = $this->College_routine_model->getAllperiodno();
                    $data['period_type'] = $this->College_routine_model->getAllperiodtype();
                    $data['year'] = $this->College_routine_model->getAllyear();
                    $data['semester'] = $this->College_routine_model->getAllsemester();
                    $data['discipline'] = $this->College_routine_model->get_all_course();
                    $data['subject'] = $this->College_routine_model->getAllsubject();
					$data['section_data'] = $this->College_routine_model->fetchSectiondata();
                    //$data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
					$data['final_emp_list_data'] = $final_emp_list_final;
                    $data['postData'] = $this->input->post();
                    $msg = 'Routine Created Successfully'. $data['routine_unique_id'];
                    $this->session->set_flashdata('success',$msg);
                 }
                }  

                  
            }
            else{
                //$this->load->view($this->config->item('theme').'routine/routine_add_view',$data);
            }
        }
    //..............//

        $this->load->view($this->config->item('theme').'routine_management_v/routine/routine_add_view',$data);

}
    public function routine_list($offset=0){
		
        $college_id = $this->session->userdata('stake_details_id_fk');
        $operator_id = $this->session->userdata('stake_holder_login_id_pk');

        $data['offset']         = $offset;
        $this->load->library('pagination');
        $config['base_url']         = 'routine_management_c/routine/Routine_add/routine_list';
        $config['total_rows']       = $this->College_routine_model->count_routine_list()[0]['count'];
        $config['per_page']         = 25;
        $config['num_links']        = 2;
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

        $data['all_days'] = $this->College_routine_model->getAlldays();
        $data['period_no'] = $this->College_routine_model->getAllperiodno();
        $data['period_type'] = $this->College_routine_model->getAllperiodtype();
        $data['year'] = $this->College_routine_model->getAllyear();
        $data['semester'] = $this->College_routine_model->getAllsemester();
        $data['discipline'] = $this->College_routine_model->get_all_course();
        $data['subject'] = $this->College_routine_model->getAllsubject();
        $data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
		$data['section_data'] = $this->College_routine_model->fetchSectiondata();

        $days_name = $this->input->post('days_name');
        $discipline_type = $this->input->post('discipline_type');
        $stud_year = $this->input->post('stud_year');
        $semester = $this->input->post('semester');
        $period_no = $this->input->post('period_no');
        $date = $this->input->post('date');
        $emp_id = $this->input->post('emp_id');
        $section_name = $this->input->post('section_name_s');
        $routine_unique_id = $this->input->post('routine_unique_id');

        if ($this->input->post()) {
            $data['all_emp_list'] = $this->College_routine_model->get_all_routine_list($college_id, $operator_id, $days_name, $discipline_type, $stud_year, $semester,$period_no, $emp_id, $routine_unique_id,$section_name);
            $data['page_links']     = $this->pagination->create_links();
            $this->load->view($this->config->item('theme') . 'routine_management_v/routine/routine_list_view', $data);
        } else {
            $data['all_emp_list'] = $this->College_routine_model->get_all_routine_list_all($college_id, $operator_id, $config['per_page'], $offset);
            $data['page_links']     = $this->pagination->create_links();
            $this->load->view($this->config->item('theme') . 'routine_management_v/routine/routine_list_view', $data);
        }
    }

    public function forwardRoutine($routine_manage_id_pk){
        $routine_id = $routine_manage_id_pk;
        $data= $this->College_routine_model->updateRoutineforward($routine_id);
        if($data){
            $this->session->set_flashdata('success','Routine has been forwarded to Principal');
                redirect('admin/routine_management_c/routine/Routine_add/routine_list');
            }
            else{
                $this->session->set_flashdata('error','Something Went Wrong,Please Try Again');
                redirect('admin/routine_management_c/routine/Routine_add/routine_list');
            }

    }

    public function viewRoutinedetails($routine_manage_id_pk,$period_type_fk){
        $routine_id = $routine_manage_id_pk;
        $data['routine']= $this->College_routine_model->get_all_routine_list_using_id($routine_id);
        $data['practical_sub']= $this->College_routine_model->get_all_practical_sub($routine_id); 
        //$data['employee']= $this->College_routine_model->get_all_employee_lists($routine_id);
        $this->load->view($this->config->item('theme').'routine_management_v/routine/routine_all_view',$data);
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

		public function editRoutine($routine_manage_id_pk){
			
            $this->load->library('form_validation');
            $this->load->library('session');
            $routine_id = $routine_manage_id_pk;
            $stake_id = $this->session->userdata('stake_id_fk');
            $stake_login_id = $this->session->userdata('stake_holder_login_id_pk');
            $college_id = $this->session->userdata('stake_details_id_fk');
            $operator_id = $this->session->userdata('stake_holder_login_id_pk');

            
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
			$tutoraial_subj_name = $this->input->post('tutoraial_subj_name');
            $prac_subj_name = $this->input->post('prac_subj_name');
            $emp_id = $this->input->post('emp_id');
            $status_code = $this->input->post('status_code');
			$section_name = $this->input->post('section_name');


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
			$this->form_validation->set_rules('section_name', 'Section Name', 'required');
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
			                'active_status'=>'1',
                            'updated_time'=>date('Y-m-d H:i:s'),
                            'updated_ip'=>$this->input->ip_address(),
							'section_id_fk' => $section_name
                        );
				
                $result = $this->College_routine_model->UpdatebasicRoutinelist($data,$routine_id_fk);
                    if($result){
                        $this->session->set_flashdata('success','Routine has been successfully updated ');
                        redirect('admin/routine_management_c/routine/Routine_add/routine_list');
                 }      
            }
            else{
                $this->session->set_flashdata('error','Something Went Wrong, Please Try Again');
            }
        }

        //Second Part Start from here (theroy type)
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
			$this->form_validation->set_rules('section_name', 'Section Name', 'required');

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
                    'active_status'=>'1',
                    'updated_time'=>date('Y-m-d H:i:s'),
                    'updated_ip'=>$this->input->ip_address(),
                    'status_code'=>$status_code,
                    'routine_unique_id'=>$routine_unique_id,
					'section_id_fk' => $section_name
                );
                $theoryType = $this->College_routine_model->updateRoutinelist($routine_id_fk);
                if($theoryType == '1'){
                     $ins_id = $this->College_routine_model->insertRoutinelist($data);
               
                    //foreach($emp_id as $value){
                    
					$ins = array();
                      $ins['routine_details_fk']=$ins_id;
                      //$ins['employee_id']=$value;
					  $ins['employee_id']=$emp_id;
                      $ins['entry_time']=date('Y-m-d H:i:s');
                      $ins['entry_ip']=$this->input->ip_address();
                      $ins['active_status']='1';
                      $this->College_routine_model->insertEmployeedatalist($ins);
                    
					//}
                     $this->session->set_flashdata('success','Routine Updated Successfully');
                     redirect('admin/routine_management_c/routine/Routine_add/routine_list');
                }
               
                       
           }
            else{
               // $this->load->view($this->config->item('theme').'routine/routine_add_view',$data);
            }
        }
		
		//.............Tutorial Subject Add.....................//
        if($period_type == '5'){
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
            $this->form_validation->set_rules('tutoraial_subj_name','Tutorial Subject','required');
            $this->form_validation->set_rules('emp_id[]','Employee Name','required');
			$this->form_validation->set_rules('section_name', 'Section Name', 'required');

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
                    'subject_id_fk'=>$tutoraial_subj_name,
                    'status_code'=>$status_code,
                    'active_status'=>'1',
                    'updated_time'=>date('Y-m-d H:i:s'),
                    'updated_ip'=>$this->input->ip_address(),
                    'status_code'=>$status_code,
                    'routine_unique_id'=>$routine_unique_id,
					'section_id_fk' => $section_name
                );
                $theoryType = $this->College_routine_model->updateRoutinelist($routine_id_fk);
                if($theoryType == '1'){
                     $ins_id = $this->College_routine_model->insertRoutinelist($data);
               
                    //foreach($emp_id as $value){
                      $ins = array();
                      $ins['routine_details_fk']=$ins_id;
                      //$ins['employee_id']=$value;
					  $ins['employee_id']=$emp_id;
                      $ins['entry_time']=date('Y-m-d H:i:s');
                      $ins['entry_ip']=$this->input->ip_address();
                      $ins['active_status']='1';
                      $this->College_routine_model->insertEmployeedatalist($ins);
                    //}
                     $this->session->set_flashdata('success','Routine Updated Successfully');
                     redirect('admin/routine_management_c/routine/Routine_add/routine_list');
                }
               
                       
           }
            else{
               
               // $this->load->view($this->config->item('theme').'routine/routine_add_view',$data);
            }
        }

        //..................Tutorial Subject End...................//

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
			$this->form_validation->set_rules('section_name', 'Section Name', 'required');
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
		            'active_status'=>'1',
                    'updated_time'=>date('Y-m-d H:i:s'),
                    'updated_ip'=>$this->input->ip_address(),
                    'status_code'=>$status_code,
                    'routine_unique_id'=>$routine_unique_id,
					'section_id_fk' => $section_name
                );
                
                   $practicalType = $this->College_routine_model->updatepracRoutinelist($routine_id_fk);
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
                        redirect('admin/routine_management_c/routine/Routine_add/routine_list');
                   }
                    
            }
        }
  
			//All Post Value
            
            $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
            $data['all_days']  = $this->College_routine_model->getAlldays();
            $data['period_no'] = $this->College_routine_model->getAllperiodno();
            $data['period_type'] = $this->College_routine_model->getAllperiodtype();
            $data['year'] = $this->College_routine_model->getAllyear();
            $data['semester'] = $this->College_routine_model->getAllsemester();
            $data['discipline'] = $this->College_routine_model->get_all_course();
            
            $data['all_emp'] = $this->College_routine_model->get_allemp($college_id);
			$data['all_working_emp'] = $this->College_routine_model->get_workingarrangeemployee($college_id);
			$final_emp_list = array_merge($data['all_emp'],$data['all_working_emp']); 
			$final_emp_list_final = array_map("unserialize",array_unique(array_map("serialize",$final_emp_list)));
			$data['final_emp_list_data'] = $final_emp_list_final;
            $data['all_details'] = $this->College_routine_model->get_all_routine_list_using_id($routine_id);
        
            $course_id_pk = $data['all_details'][0]['course_id_pk'];
            $semester_id = $data['all_details'][0]['sem_id'];
            
            $data['subject'] = $this->College_routine_model->getAlleditsubject($course_id_pk,$semester_id);
            $data['prac_subject'] = $this->College_routine_model->getAllpracsubjectedit($course_id_pk,$semester_id);
            $data['employee_details_ids'] = $this->College_routine_model->getEmployeeids($routine_id);
            $data['subject_details_ids'] = $this->College_routine_model->getSubjectsids($routine_id);
			$data['totiroal_subjects'] = $this->College_routine_model->getAlledittutorialsubject($course_id_pk,$semester_id);
            $data['routine_id'] = $routine_manage_id_pk;
			$data['section_data'] = $this->College_routine_model->fetchSectiondata();
            $this->load->view($this->config->item('theme').'routine_management_v/routine/routine_edit_view',$data);
            
           
        
    }

    public function getPeriodtimedata(){
        $college_id = $this->session->userdata('stake_details_id_fk');
        $operator_id = $this->session->userdata('stake_holder_login_id_pk');
        $period_no = $this->input->get('period_no');
        $result = $this->College_routine_model->fetchPeriodtime($period_no,$college_id,$operator_id);
       // $output  = array('period_start_time'=>$result['period_start_time'],'period_end_time'=>$result['period_end_time']);
        echo json_encode($result);
    }
//.........................Semester Details.............................//
    public function getallSemester(){
        $semsterId = $this->input->get('semsterId');
        $result = $this->College_routine_model->getPeriodlist($period_type);
        ?>
        <option value="">--Please Select Semester --</option>
        <?php 
                foreach($result as $result){
                ?>
        <option value="<?php echo $result['id']; ?>"><?php echo $result['description']; ?></option>
        <?php
                }

            } 


    public function routineForwardlist(){
     $this->load->library('form_validation');
     $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
     $data['year'] = $this->College_routine_model->getAllyear();
     $data['semester'] = $this->College_routine_model->getAllsemester();
     $data['discipline'] = $this->College_routine_model->get_all_course();
     $data['all_days'] = $this->College_routine_model->getAlldays();
	 $college_id = $this->session->userdata('stake_details_id_fk');
    

     if($this->input->post()){
        $academic_year = $this->input->post('academic_year');
        $discipline_type = $this->input->post('discipline_type');
        $stud_year = $this->input->post('stud_year');
        $semester = $this->input->post('semester');
        $data['forwardlist'] = $this->input->post();
       
        $this->form_validation->set_rules('academic_year','Academic Session','required');
        $this->form_validation->set_rules('discipline_type','Discipline Type','required');
        $this->form_validation->set_rules('stud_year','Year','required');
        $this->form_validation->set_rules('semester','Semester','required');
        

     if($this->form_validation->run()!= FALSE){
        $data['result'] = $this->College_routine_model->get_allforwarddata($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['period_time'] = $this->College_routine_model->getPeriodtime($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['mondays'] = $this->College_routine_model->getMondayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['tuesdays'] = $this->College_routine_model->getTuesdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['wednesdays'] = $this->College_routine_model->getWednesdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['thrusdays'] = $this->College_routine_model->getThrusdatroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['fridays'] = $this->College_routine_model->getFridayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);
        $data['saturdays'] = $this->College_routine_model->getSataurdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id);

        $data['countresult'] = $this->College_routine_model->countStatus($academic_year,$discipline_type,$stud_year,$semester,$college_id);
		
		
     }else{
             $data['forwardlist'] = $this->input->post();
             $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
             $data['year'] = $this->College_routine_model->getAllyear();
             $data['semester'] = $this->College_routine_model->getAllsemester();
             $data['discipline'] = $this->College_routine_model->get_all_course();
            
        }
     }
     $this->load->view($this->config->item('theme').'routine_management_v/routine/routine_forward_list',$data);
    }

    
    public function getRoutinefor(){
        $forwarrdid = $this->input->post('forwardid');
		
        if($forwarrdid != ''){
             $result = $this->College_routine_model->updateForwardlist($forwarrdid);
            if($result){
             $this->session->set_flashdata('success','All Routine has been forwarded to the principal successfully...');
             redirect('admin/routine_management_c/routine/Routine_add/routine_list');
            }else{
             $this->session->set_flashdata('error','Something Went Wrong');
             redirect('admin/routine_management_c/routine/Routine_add/routine_list');
            }
        }else{
            $this->session->set_flashdata('error','No Routine Found For Forward');
             redirect('admin/routine_management_c/routine/Routine_add/routine_list');
        }
    }


    public function revertRoutinelist($offset=NULL){
        $college_id = $this->session->userdata('stake_details_id_fk');
        $operator_id = $this->session->userdata('stake_holder_login_id_pk');
		$college_id = $this->session->userdata('stake_details_id_fk');
        $this->load->library('pagination');
        $config['base_url']         = 'routine_management_c/routine/Routine_add/revertRoutinelist';
        $config['total_rows']       = $this->College_routine_model->count_routine_revert_list()[0]['count'];
        
        $config['per_page']         = 10;
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
       
        $data['all_emp_list'] = $this->College_routine_model->get_all_routine_Revert_list($college_id,$operator_id,$config['per_page'],$offset);
        $data['page_links']     = $this->pagination->create_links();
        $data['offset']         = $offset;
        $this->load->view($this->config->item('theme').'routine_management_v/routine/routine_revert_list_view',$data);
    }

    public function allApproverevertroutine(){
        $revert_id_list = $this->input->post('revert_id_list');
        if($revert_id_list != ''){
            $result = $this->College_routine_model->updaterevertlists($revert_id_list);
           if($result){
            $this->session->set_flashdata('success','All Routine has been forwarded to the principal successfully...');
            redirect('admin/routine_management_c/routine/Routine_add/revertRoutinelist');
           }else{
            $this->session->set_flashdata('error','Something Went Wrong');
            redirect('admin/routine_management_c/routine/Routine_add/revertRoutinelist');
           }
       }else{
           $this->session->set_flashdata('error','No Routine Found For Forward');
            redirect('admin/routine_management_c/routine/Routine_add/revertRoutinelist');
       }
    }
	
	
	 public function deleteRoutine($routine_manage_id_pk = NULL){
		 
        $data['all_period'] = $this->College_routine_model->fetchAllroutinedetails($routine_manage_id_pk);
        $routines_id =array();
            $routines_id = @array_column($routineid,'routine_manage_id_pk');
            $i=1;
            foreach($data['all_period'] as  $v){
                 $routines[$i]["college_id_fk"]             = $v['college_id_fk'];
                 $routines[$i]["operator_id_fk"]            = $v['operator_id_fk'];
                 $routines[$i]["days_id_fk"]                = $v['days_id_fk'];
                 $routines[$i]["period_no"]                 = $v['period_no'];
                 $routines[$i]["period_start_time"]         = $v['period_start_time'];
                 $routines[$i]["period_end_time"]           = $v['period_end_time'];
                 $routines[$i]["period_type_fk"]            = $v['period_type_fk'];
                 $routines[$i]["room_no"]                   = $v['room_no'];
                 $routines[$i]["discipline_id_fk"]          = $v['discipline_id_fk'];
                 $routines[$i]["year_id_fk"]                = $v['year_id_fk'];
                 $routines[$i]["semester_id_fk"]            = $v['semester_id_fk'];
                 $routines[$i]["status_code"]               = $v['status_code'];
                 $routines[$i]["revert_reason"]             = $v['revert_reason'];
                 $routines[$i]["entry_time"]                = $v['entry_time'];
                 $routines[$i]["updated_time"]              = $v['updated_time'];
                 $routines[$i]["entry_ip"]                  = $v['entry_ip'];
                 $routines[$i]["updated_ip"]                = $v['updated_ip'];
                 $routines[$i]["active_status"]             = $v['active_status'];
                 $routines[$i]["academic_year_fk"]          = $v['academic_year_fk'];
                 $routines[$i]["routine_revart_time"]       = $v['routine_revart_time'];
                 $routines[$i]["routine_revart_ip"]         = $v['routine_revart_ip'];
                 $routines[$i]["routine_revart_by"]         = $v['routine_revart_by'];
                 $routines[$i]["routine_unique_id"]         = $v['routine_unique_id'];
                 $routines[$i]["routine_manage_id_fk"]      = $v['routine_manage_id_pk'];
                 $routines[$i]["acrhived_id_entry_time"]    = date('Y-m-d H:i:s');
                 $routines[$i]["acrhived_id_entry_ip"]      = $this->input->ip_address();
                 $routines[$i]["who_archived"]              = $this->session->userdata('stake_holder_login_id_pk');
                 $i++;
            }
			
			

                $this->db->trans_begin();
                $insertarchived =  $this->College_routine_model->insertArchiveddetails($routines);
                $updatedetailstable  =  $this->College_routine_model->updateDetailsdata($routine_manage_id_pk);
                $updatemapingtable  =  $this->College_routine_model->updateRoutinemapping($routine_manage_id_pk);
                if($this->db->trans_status() === FALSE || !isset($insertarchived) || !isset($updatedetailstable) || !isset($updatemapingtable)){
                   $this->db->trans_rollback();
                   $this->session->set_flashdata('error','Something Went Wrong,Please Try After Sometime');
                   redirect('admin/routine_management_c/routine/Routine_add/routine_list');
                }else{
                   $this->db->trans_commit();
                   $this->session->set_flashdata('success','Routines has benn successfully deleted');
                   redirect('admin/routine_management_c/routine/Routine_add/routine_list');
                }
    }
	
	
	public function fetchRoutineFortest(){
		echo "<pre>";
		print_r($_POST);
		die;
	}

	public function routineForwardlist_new()
    {
		
        $data['result'] = array();
        $this->load->library('form_validation');
        $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
        $data['year'] = $this->College_routine_model->getAllyear();
        $data['semester'] = $this->College_routine_model->getAllsemester();
        $data['discipline'] = $this->College_routine_model->get_all_course();
        $data['all_days'] = $this->College_routine_model->getAlldays();
		$data['section_data'] = $this->College_routine_model->fetchSectiondata();
        $college_id = $this->session->userdata('stake_details_id_fk');
		$operator_id = $this->session->userdata('stake_holder_login_id_pk');


        if ($this->input->post()) {
			
            $academic_year = $this->input->post('academic_year');
            $discipline_type = $this->input->post('discipline_type');
            $stud_year = $this->input->post('stud_year');
            $semester = $this->input->post('semester');
			$routine_mode = $this->input->post('routine_mode');
			$section_name = $this->input->post('section_name_s');
            $data['forwardlist'] = $this->input->post();

            $this->form_validation->set_rules('academic_year', 'Academic Session', 'required');
            $this->form_validation->set_rules('discipline_type', 'Discipline Type', 'required');
            $this->form_validation->set_rules('stud_year', 'Year', 'required');
            $this->form_validation->set_rules('semester', 'Semester', 'required');
			$this->form_validation->set_rules('routine_mode', 'Routine Mode', 'required');
			$this->form_validation->set_rules('section_name_s', 'Section', 'required');


            if ($this->form_validation->run() != FALSE) {
                $data['period_time'] = $this->College_routine_model->getPeriodtime_new($college_id);
				
				//$data['routine_details'] = $this->College_routine_model->getAllroutinesdetailsid($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester);
				
                $data['monday']     = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,1,$routine_mode,$section_name);
				$data['tuesday']    = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,2,$routine_mode,$section_name);
				$data['wednesday']  = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,3,$routine_mode,$section_name);
				$data['thrusday']   = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,4,$routine_mode,$section_name);
				$data['friday']     = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,5,$routine_mode,$section_name);
				$data['saturday']   = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,6,$routine_mode,$section_name);
				$data['countresult'] = $this->College_routine_model->countStatus_routine($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,$routine_mode,$section_name);
				
				$data['forwardlist'] = $this->input->post();
				
				
				
            } else {
                $data['forwardlist'] = $this->input->post();
                $data['all_academic_year'] = $this->College_routine_model->get_allacademicyear();
                $data['year'] = $this->College_routine_model->getAllyear();
                $data['semester'] = $this->College_routine_model->getAllsemester();
                $data['discipline'] = $this->College_routine_model->get_all_course();
            }
        }
        $this->load->view($this->config->item('theme') . 'routine_management_v/routine/routine_forward_list_new', $data);
    }
	
	 public function downlaodRoutinepdf()
    {
        $college_id = $this->session->userdata('stake_details_id_fk');
		$operator_id = $this->session->userdata('stake_holder_login_id_pk');
		
		
        $academic_year = $this->input->post('academic_year');
		$discipline_type = $this->input->post('discipline_type');
		$stud_year = $this->input->post('stud_year');
		$semester = $this->input->post('semester');
		$routine_mode = $this->input->post('routine_mode');
		$section_name = $this->input->post('section_name_s');
		
		
		$data['forwardlist'] = $this->input->post();
		$data['period_time'] = $this->College_routine_model->getPeriodtime_new($college_id);
        $data['monday']     = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,1,$routine_mode,$section_name);
		$data['tuesday']    = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,2,$routine_mode,$section_name);
		$data['wednesday']  = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,3,$routine_mode,$section_name);
		$data['thrusday']   = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,4,$routine_mode,$section_name);
		$data['friday']     = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,5,$routine_mode,$section_name);
		$data['saturday']   = $this->College_routine_model->getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,6,$routine_mode,$section_name);
		
		
        $html = $this->load->view($this->config->item('theme') . 'routine_management_v/routine/routine_forward_list_pdf', $data, true);

        $pdfFilePath = "Routine.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->AddPage('L');
        $this->m_pdf->pdf->WriteHTML($html, 2);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
      
}
?>