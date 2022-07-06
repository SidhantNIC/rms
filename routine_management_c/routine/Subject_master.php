<?php
defined('BASEPATH') OR exit('No direct script access allowed' );

class Subject_master extends NIC_Controller
{
    public function __construct()
    {
		parent::__construct();
		parent::check_privilege(178);
		$this->load->library('user_agent');
        //$this->load->library('pagination');
        $this->load->library('form_validation');
		$this->load->helper('url');
        $this->load->helper('routine_management_helper');
		$this->load->model('routine_management_m/routine/College_routine_model');
		//$this->output->enable_profiler(TRUE); 
		  $this->css_head = array(
            1 => $this->config->item('theme_uri') . 'bower_components/select2/dist/css/select2.min.css',
			);
        $this->js_foot = array(
                1 =>$this->config->item('theme_uri').'college_routine/js/subject_master_name_edit.js',
				2 => $this->config->item('theme_uri') . 'bower_components/select2/dist/js/select2.full.min.js',
			);    
	}

	public function index(){
		$data['semester'] = $this->College_routine_model->getAllsemester();
        //$data['discipline'] = $this->College_routine_model->get_all_course_subject();
		$data['discipline'] = $this->College_routine_model->get_all_course_lists();
		
		
        $data['last_subject_code'] = $this->College_routine_model->lastSubjectcode();
        if($this->input->post()){
        	$course_name = $this->input->post('course_name');
        	$semester = $this->input->post('semester');
        	$subject_type = $this->input->post('subject_type');
        	$subject_code = $this->input->post('subject_code');
        	$subject_name = $this->input->post('subject_name');

        	$this->form_validation->set_rules('course_name','Course Name','required');
        	$this->form_validation->set_rules('semester','Semester','required');
        	$this->form_validation->set_rules('subject_type','Subject Type','required');
        	$this->form_validation->set_rules('subject_code','Subject Code','required|trim|numeric');
        	$this->form_validation->set_rules('subject_name','Subject Name','required|trim');

        	if($this->form_validation->run() ==FALSE){
        		$data['semester'] = $this->College_routine_model->getAllsemester();
        		$data['discipline'] = $this->College_routine_model->get_all_course_lists();
        	}else{

        		$data=array(
        			'branch_code_fk'=>$course_name,
        			'semester_code_fk'=>$semester,
        			'subject_type_fk'=>$subject_type,
        			'subject_code'=>$subject_code,
        			'subject_description'=>$subject_name,
        			'active_status'=>'1',
        			'entry_ip'=>$this->input->ip_address(),
					'entry_time' =>date('Y-m-d H:i:s')
				);

        		 $result= $this->College_routine_model->insertSubjectmasterdata($data);
        		 $data['semester'] = $this->College_routine_model->getAllsemester();
        		$data['discipline'] = $this->College_routine_model->get_all_course_lists();
				 $data['last_subject_code'] = $this->College_routine_model->lastSubjectcode();
        		 if($result){
        		 	$this->session->set_flashdata('success','New Subject Inserted Successfully...');
        		 }else{
        		 	$this->session->set_flashdata('error','Something Went Wrong,Please Try After Sometime');
        		 }
        	}


        }
         $this->load->view($this->config->item('theme').'routine_management_v/routine/subject_master_add_view',$data);
        }
		

    public function Subject_list(){
        $data['semester'] = $this->College_routine_model->getAllsemester();
        //$data['discipline'] = $this->College_routine_model->get_all_course_subject();

		$data['discipline'] = $this->College_routine_model->get_all_course_lists();

        if($this->input->post()){
            $course_name = $this->input->post('course_name');
            $semester = $this->input->post('semester');
            $subject_type = $this->input->post('subject_type');

            $this->form_validation->set_rules('course_name','Course Name','required');
            $this->form_validation->set_rules('semester','Semester','required');
            $this->form_validation->set_rules('subject_type','Subject Type','required');

           if($this->form_validation->run() ==FALSE){
                $data['semester'] = $this->College_routine_model->getAllsemester();
                $data['discipline'] = $this->College_routine_model->get_all_course_subject();
            }else{
                $data['subject_details']= $this->College_routine_model->serachsubjectMasterdata($course_name,$semester,$subject_type);
            }
        }
        $this->load->view($this->config->item('theme').'routine_management_v/routine/subject_master_list_view',$data);
    }

    public function ajax_editviewSubjectdetails($discipline_id_pk){

        $this->load->helper('string');
        if($discipline_id_pk == NULL || strlen($discipline_id_pk) != 32)
        {
          echo '<div class="alert alert-danger">Something went wrong. Please try again</div>';
        } 
        else 
        {
          $data['revert_data']= $this->College_routine_model->getEditsubjectdetails($discipline_id_pk);
          $data['discipline_id_pk']= $discipline_id_pk;
          $this->load->view($this->config->item('theme').'routine_management_v/routine/ajax/ajax_subject_name_change_view',$data);
        }
    }

    public function ajax_subject_name_update()
	{
    $discipline_id_pk = $this->input->POST('discipline_id_pk');
    $subject_description = $this->input->POST('subject_description');
    $data['revert_data']= $this->College_routine_model->getEditsubjectdetails($discipline_id_pk);
    $data['discipline_id_pk']= $discipline_id_pk;
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    $config = array(
                array(
                  'field' => 'subject_description',
                  'label' => '<b>Subject Name</b>',
                  'rules' => 'trim|required'
                )
            );
    $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE)
        {
           $this->load->view($this->config->item('theme').'routine_management_v/routine/ajax/ajax_subject_name_change_view',$data);
        }
      else{
        $result = $this->College_routine_model->updateSubjectname($discipline_id_pk,$subject_description);
        if($result)
        {
          $data['code'] = 1;
          $data['msg'] = "Subject Name Is Successfully Updated.......";
        }
        $this->load->view($this->config->item('theme').'routine_management_v/routine/ajax/ajax_subject_name_change_view',$data);
		}
	}
	
	// Delete Subject
	public function deleteSubject($discipline_id_pk = NULL){
		$result = $this->College_routine_model->subejctDeleted($discipline_id_pk);
		if($result){
			$this->session->set_flashdata('success','Subject Will Be Deleted Successfully');
			redirect('admin/routine_management_c/routine/Subject_master/Subject_list');
		}else{
			$this->session->set_flashdata('success','Subject Will Be Deleted Successfully');
			redirect('admin/routine_management_c/routine/Subject_master/Subject_list');
		}
	}

}