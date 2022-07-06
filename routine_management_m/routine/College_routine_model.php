<?php
defined('BASEPATH') OR exit('No direct script access allowed' );

class College_routine_model extends CI_Model {

	   //fetch all academic year
    public function get_allacademicyear($college_id = NULL){
      $query = $this->db->select('academic_year_id_pk,academic_year_description')
                            ->from('routine_academic_session_year_master')
                            ->where(
                                array('active_status' =>'1')
                                )
                            ->get();
            return $query->result_array();

    }

    //fetch all employee
   public function get_allemp($college_id = NULL){
      $query = $this->db->select('emp_basic_id_pk,first_name,midle_name,last_name')
                            ->from('poly_college_emp_basic')
                            ->where(
                                array('college_id_fk' => $college_id)
                                )
                            ->where(
                                array('process_id_fk' =>'104')
                                )
							->order_by('first_name')
                            ->get();
            return $query->result_array();

    }
	
	//fetch all working arrangement employee
    public function get_workingarrangeemployee($college_id = NULL){
		$query = $this->db->query("Select a.emp_basic_id_pk,a.first_name,a.midle_name,a.last_name,a.college_id_fk from poly_college_emp_basic as a
LEFT JOIN poly_college_emp_posting_history as b 
ON a.emp_basic_id_pk = b.emp_basic_id_fk
where 
b.emp_posting_history_id_pk in
( select min(emp_posting_history_id_pk) from poly_college_emp_posting_history group by emp_basic_id_fk ) AND 

 (b.first_working_arrangenent_poly_name  = '".$college_id."' OR b.second_working_arrangenent_poly_name  = '".$college_id."' OR b.third_working_arrangenent_poly_name  = '".$college_id."') AND a.process_id_fk ='104' AND b.working_arrangement = '1' 
AND  
(b.first_working_arrangenent_from_date is not null OR b.first_working_arrangenent_end_date is null) 
AND 
(b.second_working_arrangenent_from_date is not null OR b.second_working_arrangenent_end_date is null)
AND 
(b.third_working_arrangenent_from_date is not null OR b.third_working_arrangenent_end_date is null)
");
/*echo $this->db->last_query();
die;*/
            return $query->result_array();

    }
    // fetch all days
   public function getAlldays(){
       $query = $this->db->select('id,description')
                            ->from('poly_days_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->get();
            return $query->result_array();
    }
    // fetch all period no
    public function getAllperiodno(){
       $query = $this->db->select('id,description')
                            ->from('poly_period_no_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->order_by('id')
                            ->get();
            return $query->result_array();
    }
    // fetch all period type
     public function getAllperiodtype(){
       $query = $this->db->select('id,description')
                            ->from('poly_period_type_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->get();
            return $query->result_array();
    }
   // fecth year
    public function getAllyear(){
       $query = $this->db->select('id,description')
                            ->from('poly_year_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->get();
            return $query->result_array();
    }
    // fetch all semester
    public function getAllsemester(){
       $query = $this->db->select('id,description')
                            ->from('poly_semester_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
							 ->order_by('id') 
                            ->get();
            return $query->result_array();
    }
    // get all discipline
  public function get_all_course()
  {
    $college_id = $this->session->userdata('stake_details_id_fk');
    $query = $this->db->select('
                  a.course_id_pk,
                  a.course_name                 
                  ')
            ->from('poly_course_master as a')
            ->join('poly_college_course as b','b.course_id_fk = a.course_id_pk  ','LEFT')
            ->where(
                    array('a.active_status' =>'1')
                    )
             ->where(
                    array('b.college_id_fk' =>$college_id)
                    )
			->where('b.process_id_fk','7')
            ->order_by('course_id_pk','ASC')  
            ->get();
    return $query->result_array();    
  }
    // fetch all theory subjects
    public function getAllsubject(){
       $query = $this->db->select('subject_code')
                         ->select('subject_description')
                            ->from('discipline_wise_code_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->where(
                                    array('subject_type_fk' =>'1')
                                )
                            ->group_by('subject_description')
                            ->group_by('subject_code')
                            ->get();
            return $query->result_array();
    }

    // fetch all theory subjects for edit
    public function getAlleditsubject($course_id_pk,$semester_id){
       $query = $this->db->select('subject_code')
                         ->select('subject_description')
                            ->from('discipline_wise_code_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->where(
                                    array('subject_type_fk' =>'1')
                                )
                            ->where(
                                    array('branch_code_fk' =>$course_id_pk)
                                )
                            ->where(
                                    array('semester_code_fk' =>$semester_id)
                                )
                            // ->group_by('subject_description')
                            // ->group_by('subject_code')
                            ->get();
            return $query->result_array();
    }
    
    // fetch all practical subjects
    public function getAllpracsubject(){
       $query = $this->db->select('subject_code')
                         ->select('subject_description')
                            ->from('discipline_wise_code_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->where(
                                    array('subject_type_fk' =>'2')
                                )
                            ->group_by('subject_description')
                            ->group_by('subject_code')
                            ->get();
            return $query->result_array();
    }

    // fetch all practical subjects for edit
    public function getAllpracsubjectedit($course_id_pk,$semester_id){
       $query = $this->db->select('subject_code')
                         ->select('subject_description')
                            ->from('discipline_wise_code_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->where(
                                    array('subject_type_fk' =>'2')
                                )
                            ->where(
                                    array('branch_code_fk' =>$course_id_pk)
                                )
                            ->where(
                                    array('semester_code_fk' =>$semester_id)
                                )
                            ->group_by('subject_description')
                            ->group_by('subject_code')
                            ->get();
            return $query->result_array();
    }

  //Routine Check
    public function routineCheck($academic_year,$period_no,$college_id,$operator_id,$days_name,$semester,$discipline_type,$section_name){
       $data = $this->db->select('routine_manage_id_pk')
                      //->where('operator_id_fk',$operator_id)
                      ->where('college_id_fk',$college_id)
                      ->where('period_no',$period_no)
                      ->where('days_id_fk',$days_name)
                      ->where('semester_id_fk',$semester)
                      ->where('discipline_id_fk',$discipline_type )
                      ->where('section_id_fk',$$section_name )
                      ->where('active_status','1')
					  ->where('academic_year_fk',$academic_year)
                      ->get('routine_management_system_details');
      return $data->num_rows();
	  
    }
  // insert the routine data
   public function insertRoutinelist($data){
    $this->db->insert('routine_management_system_details',$data);
    $insert_id = $this->db->insert_id();
    return $insert_id;     
  }

  // insert the routine mapping data
   public function insertEmployeedatalist($ins){
    return $this->db->insert('routine_management_maping_details',$ins);
  }
  //Insert only practical subject details
    public function insertSubjectdetails($ins_prac){
     return $this->db->insert('poly_subject_mapping_master',$ins_prac);
    }
    //Insert only some basic routine details
    public function insertbasicRoutinelist($data){
     return $this->db->insert('routine_management_system_details', $data);
    }

    

    //count count_routine_list for pagination
    public function count_routine_list(){
        $college_id = $this->session->userdata('stake_details_id_fk');
        $operator_id = $this->session->userdata('stake_holder_login_id_pk');
        $query = $this->db->select('count(*)')
                         ->where('college_id_fk',$college_id)
                         ->where('operator_id_fk',$operator_id)
                         ->where('active_status','1')
                         ->get('routine_management_system_details');
        return $query->result_array(); 

    }
    public function count_routine_revert_list(){
        $college_id = $this->session->userdata('stake_details_id_fk');
        $operator_id = $this->session->userdata('stake_holder_login_id_pk');
        $query = $this->db->select('count(*)')
                         ->where('college_id_fk',$college_id)
                         ->where('operator_id_fk',$operator_id)
                         ->where('active_status','1')
                         ->where('status_code','3')
                         ->get('routine_management_system_details');
        return $query->result_array(); 

    }
    // fetch the routine list
    public function get_all_routine_list($college_id, $operator_id, $days_name, $discipline_type, $stud_year, $semester, $period_no, $emp_id, $routine_unique_id, $section_name)
  {

    $query = $this->db->select('routine.routine_manage_id_pk,routine.routine_online_status')
      ->select('days.description as days_desc')
      ->select('course.course_name as course_name')
      ->select('year.description as year_desc')
      ->select('routine.routine_unique_id')
      ->select('routine.room_no')
      ->select('routine.period_start_time')
      ->select('routine.period_end_time')
      ->select('routine.period_no')
      ->select('routine.section_id_fk')
      ->select('section.section_name sectiondata')
      ->select('semester.description as sem_desc')
      ->select('period_no.description as period_no_desc')
      ->select('routine.status_code')
      ->select('process_master.process_description')


      ->from('routine_management_system_details as routine')
      ->join('routine_management_maping_details as routine_map', 'routine_map.routine_details_fk = routine.routine_manage_id_pk', 'LEFT')
      ->join('poly_days_master as days', 'days.id = routine.days_id_fk', 'LEFT')

      ->join('poly_course_master as course', 'course.course_id_pk = routine.discipline_id_fk', 'LEFT')

      ->join('poly_year_master as year', 'year.id = routine.year_id_fk', 'LEFT')

      ->join('poly_semester_master as semester', 'semester.id = routine.semester_id_fk', 'LEFT')

      ->join('poly_period_no_master as period_no', 'period_no.id = routine.period_no', 'LEFT')

      ->join('routine_process_master as process_master', 'process_master.process_id_pk = routine.status_code', 'LEFT')
      ->join('routine_section_master as section', 'routine.section_id_fk = section.section_id_pk', 'LEFT')

      ->join('poly_college_emp_basic as emp_details', 'emp_details.emp_basic_id_pk = routine_map.employee_id', 'LEFT')

      ->group_by('days_desc')
      ->group_by('period_no_desc')
      ->group_by('course_name')
      ->group_by('year_desc')
      ->group_by('course_name')
      ->group_by('sem_desc')
      ->group_by('process_description')
      ->group_by('routine.routine_manage_id_pk')
      ->group_by('sectiondata')
      // ->group_by('routine_map.employee_id')
      ->order_by('course.course_name')

      ->where('routine.college_id_fk', $college_id)
      ->where('routine.operator_id_fk', $operator_id)
      ->where('routine.active_status', '1');

    if ($days_name) {
      $query = $query->where('routine.days_id_fk', $days_name);
    }
    if ($discipline_type) {
      $query = $query->where('routine.discipline_id_fk', $discipline_type);
    }
    if ($stud_year) {
      $query = $query->where('routine.year_id_fk', $stud_year);
    }
    if ($semester) {
      $query = $query->where('routine.semester_id_fk', $semester);
    }
    if ($period_no) {
      $query = $query->where('routine.period_no', $period_no);
    }
    if ($emp_id) {
      $query = $query->where('routine_map.employee_id', $emp_id);
    }
    if ($routine_unique_id) {
      $query = $query->where('routine.routine_unique_id', $routine_unique_id);
    }
	if ($section_name) {
      $query = $query->where('routine.section_id_fk', $section_name);
    }

    $query = $query->get();

    return $query->result_array();
  }

    public function get_all_routine_Revert_list($college_id = NULL,$operator_id = NULL, $limit = NULL, $offset = NULL){
        $query = $this->db->select('routine.routine_manage_id_pk')
                      ->select('routine.routine_unique_id')
                       ->select('routine.academic_year_fk')
                       ->select('routine.period_no')
                       ->select('routine.room_no')
                       ->select('routine.period_type_fk')
                        ->select('days.description as days_desc')
                        ->select('period_no.description as period_no_desc')
                        ->select('routine.period_start_time')
                        ->select('routine.period_end_time')
                        ->select('period_type.description as period_type_desc')
                        ->select('routine.status_code')
                        ->select('process_master.process_description')
                        ->from('routine_management_system_details as routine')
                        ->join('routine_management_maping_details as routine_map','routine_map.routine_details_fk = routine.routine_manage_id_pk','LEFT')
                       ->join('poly_days_master as days','days.id = routine.days_id_fk','LEFT')

                       ->join('poly_period_type_master as period_type','period_type.id = routine.period_type_fk','LEFT')

                       ->join('poly_period_no_master as period_no','period_no.id = routine.period_no','LEFT')

                       ->join('routine_process_master as process_master','process_master.process_id_pk = routine.status_code','LEFT')
                       ->group_by('days_desc')
                       ->group_by('period_no_desc')
                       ->group_by('period_type_desc')
                       ->group_by('process_description')
                       ->group_by('routine.routine_manage_id_pk')
                       ->where('routine.college_id_fk',$college_id)
                       ->where('routine.operator_id_fk',$operator_id)
                       ->where('routine.active_status','1')
                       ->where('routine.status_code','3')
                       ->limit($limit, $offset)
                       ->order_by('routine.routine_manage_id_pk')
                       ->order_by('routine.period_no')
                       ->get();
        return $query->result_array();    	 	
        }

    public function updateRoutineforward($routine_id = NULL){
      return $this->db->set('status_code','2')
                      ->where(
                                array(
                                        'MD5(CAST(routine_manage_id_pk AS character varying))=' =>$routine_id
                                    )
                                )
                      ->update('routine_management_system_details');
    }

    public function get_all_routine_list_using_id($routine_id){
      $query = $this->db->select('routine.routine_manage_id_pk')
                        ->select('routine.college_id_fk')
                        ->select('routine.routine_unique_id')
                        ->select('routine.operator_id_fk')
                        ->select('routine_map.employee_id')
                        ->select('days.description as days_desc')
                        ->select('days.id as days_id')
                        ->select('academic_year.academic_year_description')
                        ->select('academic_year.academic_year_id_pk')
                        ->select('period_no.id as period_no_id')
                        ->select('period_no.description as period_no_desc')
                        ->select('routine.period_start_time')
                        ->select('routine.period_end_time')
                        ->select('routine.period_type_fk')
                        ->select('period_type.description as period_type_desc')
                        ->select('year.description as year_desc')
                        ->select('period_type.id as period_type_id')
                        ->select('routine.room_no')
                        ->select('course.course_id_pk')
                        ->select('course.course_name')
                        ->select('routine.year_id_fk')
                        ->select('semester.id as sem_id')
                        ->select('semester.description as sem_desc')
                        ->select('routine.subject_id_fk')
                        ->select('subject.subject_description as subject_desc')
                        ->select('emp_details.first_name')
                        ->select('emp_details.midle_name')
                        ->select('emp_details.last_name')
                        ->select('routine.status_code')
                        ->select('process_master.process_description')
                        ->select('routine.revert_reason')
                        ->select('routine.entry_time')
						->select('routine.section_id_fk')
						->select('section.section_name')
                        ->from('routine_management_system_details as routine')

                        ->join('routine_management_maping_details as routine_map','routine_map.routine_details_fk = routine.routine_manage_id_pk','LEFT')

                        ->join('poly_college_emp_basic as emp_details','emp_details.emp_basic_id_pk = routine_map.employee_id','LEFT')

                       ->join('poly_days_master as days','days.id = routine.days_id_fk','LEFT')

                       ->join('routine_academic_session_year_master as academic_year','academic_year.academic_year_id_pk = routine.academic_year_fk','LEFT')

                       ->join('poly_year_master as year','year.id = routine.year_id_fk','LEFT')

                       ->join('poly_semester_master as semester','semester.id = routine.semester_id_fk','LEFT')

                       ->join('poly_period_type_master as period_type','period_type.id = routine.period_type_fk','LEFT')

                       ->join('discipline_wise_code_master as subject','subject.subject_code = routine.subject_id_fk','LEFT')

                       ->join('poly_period_no_master as period_no','period_no.id = routine.period_no','LEFT')

                       ->join('poly_course_master as course','course.course_id_pk = routine.discipline_id_fk','LEFT')
					   
                       ->join('routine_section_master as section','section.section_id_pk = routine.section_id_fk','LEFT')

                       ->join('routine_process_master as process_master','process_master.process_id_pk = routine.status_code','LEFT')
                       ->where(
                                array(
                                        'MD5(CAST(routine.routine_manage_id_pk AS character varying))=' =>$routine_id
                                    )
                                )
                       ->where('routine.active_status','1')
                       ->get();
        return $query->result_array();      
    }

    public function UpdatebasicRoutinelist($data,$routine_id_fk){
            $this->db->set('active_status','0')
					->where('routine_details_fk',$routine_id_fk)
					->where('active_status','1')
					->update('routine_management_maping_details');
					
		    $this->db->set('active_status','0')
					->where('routine_details_fk',$routine_id_fk)
					->where('active_status','1')
					->update('poly_subject_mapping_master');
		   
          return $this->db->set('college_id_fk',$data['college_id_fk'])
                          ->set('routine_unique_id',$data['routine_unique_id'])
                          ->set('operator_id_fk',$data['operator_id_fk'])
                          ->set('academic_year_fk',$data['academic_year_fk'])
                          ->set('year_id_fk',$data['stud_year'])
                          ->set('semester_id_fk',$data['semester'])
                          ->set('discipline_id_fk',$data['discipline_id_fk'])
                          ->set('days_id_fk',$data['days_id_fk'])
                          ->set('period_no',$data['period_no'])
                          ->set('period_start_time',$data['period_start_time'])
                          ->set('period_end_time',$data['period_end_time'])
                          ->set('period_type_fk',$data['period_type_fk'])
                          ->set('updated_time',$data['updated_time'])
                          ->set('updated_ip',$data['updated_ip'])
                          ->set('active_status','1')
						  ->set('section_id_fk',$data['section_id_fk'])
                          ->where('routine_manage_id_pk',$routine_id_fk)
                          ->update('routine_management_system_details');
    }

    public function updateRoutinelist($routine_id_fk){
        $this->db->set('active_status','0')
                 ->where('routine_manage_id_pk',$routine_id_fk)
                 ->update('routine_management_system_details');

        return $this->db->set('active_status','0')
                 ->where('routine_details_fk',$routine_id_fk)
                 ->update('routine_management_maping_details');

    }

    public function updatepracRoutinelist($routine_id_fk){
        $this->db->set('active_status','0')
                 ->where('routine_manage_id_pk',$routine_id_fk)
                 ->update('routine_management_system_details');

        $this->db->set('active_status','0')
                 ->where('routine_details_fk',$routine_id_fk)
                 ->update('routine_management_maping_details');

        return $this->db->set('active_status','0')
                 ->where('routine_details_fk',$routine_id_fk)
                 ->update('poly_subject_mapping_master');

    }

  public function getPeriodlist($period_type,$discipline_type,$semester){
      $query = $this->db->select('subject_code')
                        ->select('subject_description')
                        ->where('branch_code_fk',$discipline_type)
                        ->where('subject_type_fk',$period_type)
                        ->where('semester_code_fk ',$semester)
						->where('active_status',1)
                        ->get('discipline_wise_code_master');
      return $query->result_array();
  }

  public function getsemesterlist($semestedid){
      $query = $this->db->select('id')
                        ->select('description')
                        ->where('semester_id',$semestedid)
						->where('active_status','1')
                        ->get('poly_semester_master');
      return $query->result_array();
  }

  public function getEmployeeids($routine_id){
    $data = $this->db->select('employee_id')
                    ->where(
                          array(
                                  'MD5(CAST(routine_details_fk AS character varying))=' =>$routine_id
                              )
                          )
                    ->where('active_status','1')
                  ->get('routine_management_maping_details');
      return array_column($data->result_array(),'employee_id');


  }

  public function getSubjectsids($routine_id){
    $data = $this->db->select('subject_id')
                    ->where(
                          array(
                                  'MD5(CAST(routine_details_fk AS character varying))=' =>$routine_id
                              )
                          )
                    ->where('active_status','1')
                  ->get('poly_subject_mapping_master');
      return array_column($data->result_array(),'subject_id');


  }


    //insert 1st period time
    public function insert1stPeriodtime($data){
        $form_endtime_value = (explode(':',$data['period_start_time']));
        $form_endtime_value_1 =  $form_endtime_value['0'];
        $form_endtime_value_2 =  $form_endtime_value['1'];
        $form_start_total_time = ($form_endtime_value_1 * 3600)+ ($form_endtime_value_2 * 60);

        $form_endtime_end_value = (explode(':',$data['period_end_time']));
        $form_endtime_end_value_1 =  $form_endtime_end_value['0'];
        $form_endtime_end_value_2 =  $form_endtime_end_value['1'];
        $form_start_end_total_time = ($form_endtime_end_value_1 * 3600)+ ($form_endtime_end_value_2 * 60);
        
        if($form_start_total_time > $form_start_end_total_time ){
            return false;
        }else{
           return $this->db->insert('poly_period_time_master',$data); 
        }
       
    }

    //Check for other period
    public function checkPeriodid($college_id,$operator_id){
      $data = $this->db->select('period_time_id_pk')
                       ->where('college_id_fk',$college_id)
                       ->where('operator_id_fk',$operator_id)
                       ->where('active_status','1')
                       ->get('poly_period_time_master');
       return $data->num_rows();
    }

    public function check1stPeriodid($period_no,$college_id,$operator_id){
      $data = $this->db->select('period_time_id_pk')
                       ->where('college_id_fk',$college_id)
                       ->where('operator_id_fk',$operator_id)
                       ->where('period_no_fk',$period_no)
                       ->where('active_status','1')
                       ->get('poly_period_time_master');
       return $data->num_rows();
    }
    public function insertPeriodtime($data){
     $college_id = $this->session->userdata('stake_details_id_fk');
     $operator_id = $this->session->userdata('stake_holder_login_id_pk');
     $last = $this->db->order_by('period_time_id_pk',"desc")
                      ->limit(1)
                      ->where('active_status','1')
                      ->where('college_id_fk',$college_id)
                      ->where('operator_id_fk',$operator_id)
                      ->get('poly_period_time_master')
                      ->result_array();


     //............Database End Time ...............//
     $endtime = $last[0]['period_end_time'];
     $endtime_value = (explode(':',$endtime));
      
     $database_endtime_value_1 =  $endtime_value['0'];
     $database_endtime_value_2 =  $endtime_value['1'];
     $database_end_total_time = ($database_endtime_value_1 * 3600)+ ($database_endtime_value_2 * 60);
    //............Form End Time ...............//
    $form_endtime_value = (explode(':',$data['period_start_time']));
    $form_endtime_value_1 =  $form_endtime_value['0'];
    $form_endtime_value_2 =  $form_endtime_value['1'];
    $form_start_total_time = ($form_endtime_value_1 * 3600)+ ($form_endtime_value_2 * 60);

    $form_end_time_value = (explode(':',$data['period_end_time']));
    $form_end_time_value_1 =  $form_end_time_value['0'];
    $form_end_time_value_2 =  $form_end_time_value['1'];
    $form_end_total_time = ($form_end_time_value_1 * 3600)+ ($form_end_time_value_2 * 60);

   // echo $form_start_total_time;
     //echo 'end'.$form_end_total_time;
     //exit(); 
   

     $checkperiodno = $data['period_no_fk'] - $last[0]['period_no_fk'];

       if($form_start_total_time>=$database_end_total_time && $checkperiodno =='1'){
         return $this->db->insert('poly_period_time_master',$data);
       }else{
        return false;
       }
     
    

    }

  public function getAllperiodlist($college_id,$operator_id){
   $data = $this->db->select('*')
                    ->select('period_no.description as period_no_desc')
                    ->where('college_id_fk',$college_id)
                    ->where('operator_id_fk',$operator_id)
                    ->where('a.active_status','1')
                    ->from('poly_period_time_master as a')
                    ->join('poly_period_no_master as period_no','period_no.id = a.period_no_fk','LEFT')
                    ->order_by('a.period_no_fk')
                    ->get();
    // print_r($this->db->last_query());
    // exit;
    return $data->result_array();
  }



  //....................Period Add Time End...............................//

  public function fetchPeriodtime($period_no,$college_id,$operator_id){
      $data = $this->db->select('period_start_time')
                       ->select('period_end_time')
                       ->where('period_no_fk',$period_no)
                       ->where('college_id_fk',$college_id)
                       //->where('operator_id_fk',$operator_id)
                       ->where('active_status','1')
                       ->get('poly_period_time_master');
      return $data->result_array();
  }

  //...............//
  public function get_theory_subject($semester,$discipline_type){

    $query = $this->db->select('subject_code')
                         ->select('subject_description')
                            ->from('discipline_wise_code_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->where(
                                    array('subject_type_fk' =>'1')
                                )
                            ->where(
                                    array('branch_code_fk' =>$discipline_type)
                                )
                            ->where(
                                    array('semester_code_fk' =>$semester)
                                )
                            // ->group_by('subject_description')
                            // ->group_by('subject_code')
                            ->get();
                           // echo  $this->db->last_query();
                           //  exit;
            return $query->result_array();
  }

  //...............//
  public function get_practical_subject($semester,$discipline_type){
    $query = $this->db->select('subject_code')
                         ->select('subject_description')
                            ->from('discipline_wise_code_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->where(
                                    array('subject_type_fk' =>'2')
                                )
                            ->where(
                                    array('branch_code_fk' =>$discipline_type)
                                )
                            ->where(
                                    array('semester_code_fk' =>$semester)
                                )
                            // ->group_by('subject_description')
                            // ->group_by('subject_code')
                            ->get();
            return $query->result_array();
  }
  //Delete Period Routine Time
      public function deletePeriodtime($period_time_id_pk){
        $this->db->where(
                          array(
                                  'MD5(CAST(period_time_id_pk AS character varying))=' =>$period_time_id_pk
                              )
                        );
        return $this->db->delete('poly_period_time_master');
                     
      }

      public function get_all_practical_sub($routine_id){
        $query = $this->db->select('subject_id')
                          ->where(
                          array(
                                  'MD5(CAST(routine_details_fk AS character varying))=' =>$routine_id
                              )
                        )
                        ->get('poly_subject_mapping_master');
        return $query->result_array();

      }
      public function get_all_employee_lists($routine_id){
        $query = $this->db->select('a.first_name')
                          ->select('a.midle_name')
                          ->select('a.last_name')
						  
                          ->where(
                          array(
                                  'MD5(CAST(b.routine_details_fk AS character varying))=' =>$routine_id
                              )
                        )
						
                        ->from('poly_college_emp_basic as a')
                        ->JOIN('routine_management_maping_details as b','a.emp_basic_id_pk=b.employee_id','LEFT')
                        ->get();
        return $query->result_array();

      }

  public function get_allforwarddata($academic_year,$discipline_type,$stud_year,$semester){
	  $college_id = $this->session->userdata('stake_details_id_fk');
      $operator_id = $this->session->userdata('stake_holder_login_id_pk');
    $query = $this->db->select('routine.period_no')
                      ->select('routine.period_start_time')
                      ->select('routine.period_end_time')
                      ->select('routine.period_type_fk')
                      ->select('routine.room_no')
                      ->select('routine.subject_id_fk')
                      ->select('routine.days_id_fk')
                      ->select('routine.routine_manage_id_pk')
                      ->select('routine.period_type_fk')
                      ->select('routine.status_code')

                      ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('status_code','1')
					  ->where('college_id_fk',$college_id)
					  ->where('operator_id_fk',$operator_id)
                      ->order_by('routine.days_id_fk')
                      ->order_by('routine.period_no')
                      ->from('routine_management_system_details as routine')
                      ->get();
                    
    return $query->result_array();
  }
  public function get_routineid($academic_year,$discipline_type,$stud_year,$semester,$days){
      $query = $this->db->select('routine_manage_id_pk')
                        ->where('academic_year_fk',$academic_year)
                        ->where('discipline_id_fk',$discipline_type)
                        ->where('year_id_fk',$stud_year)
                        ->where('semester_id_fk',$semester)
                        ->where('days_id_fk',$days)
                        ->get('routine_management_system_details');
      return $query->row('routine_manage_id_pk');
  }

  public function get_employeedetails($routineid){
      $query  = $this->db->select('employee_id')
                         ->where('routine_details_fk',$routineid)
                         ->get('routine_management_maping_details');
      return $query->result_array();
  }

  public function get_allforwarddatapdf($academic_year,$discipline_type,$stud_year,$semester,$college_id){
    $query = $this->db->select('routine.period_no')
                      ->select('routine.period_start_time')
                      ->select('routine.period_end_time')
                      ->select('routine.period_type_fk')
                      ->select('routine.room_no')
                      ->select('routine.subject_id_fk')
                      ->select('routine.days_id_fk')
                      ->select('routine.routine_manage_id_pk')
                      ->select('routine.period_type_fk')
                      ->where('routine.active_status','1')
                      ->where('routine.status_code','1')
                      ->where(
                          array(
                                  'MD5(CAST(academic_year_fk AS character varying))=' =>$academic_year
                              )
                        )
                      ->where(
                          array(
                                  'MD5(CAST(discipline_id_fk AS character varying))=' =>$discipline_type
                              )
                        )
                      ->where(
                          array(
                                  'MD5(CAST(year_id_fk AS character varying))=' =>$stud_year
                              )
                        )
                      ->where(
                          array(
                                  'MD5(CAST(semester_id_fk AS character varying))=' =>$semester
                              )
                        )
                      ->where('active_status','1')
					  ->where('college_id_fk',$college_id)
                      ->group_by('routine.period_no')
                      ->group_by('routine.period_start_time')
                      ->group_by('routine.period_end_time')
                      ->group_by('routine.period_type_fk')
                      ->group_by('routine.room_no')
                      ->group_by('routine.days_id_fk')
                      ->group_by('routine.routine_manage_id_pk')
                      ->group_by('routine.period_type_fk')
                      ->order_by('routine.days_id_fk')
                      ->order_by('routine.period_no')
                      ->from('routine_management_system_details as routine')
                      ->get();
                     // echo $this->db->last_query();
                     // exit();
    return $query->result_array();
  }

  public function updateForwardlist($forwarrdid){
        $operator_id = $this->session->userdata('stake_holder_login_id_pk');
        $college_id = $this->session->userdata('stake_details_id_fk');
        $this->db->set('status_code','2'); 
        $this->db->set('forward_time',date('Y-m-d H:i:s')); 
        $this->db->set('forward_ip',$this->input->ip_address()); 
        $this->db->set('forward_by',$operator_id);  
        $this->db->where_in('routine_manage_id_pk',$forwarrdid);
        $this->db->where('college_id_fk', $college_id);
        $this->db->where('operator_id_fk', $operator_id);
		$this->db->where('status_code','1');
        $this->db->update('routine_management_system_details');
        return true;
  }

  public function updaterevertlists($revert_id_list){
    $operator_id = $this->session->userdata('stake_holder_login_id_pk');
    $college_id = $this->session->userdata('stake_details_id_fk');
    $this->db->set('status_code','2');  
    $this->db->where_in('routine_manage_id_pk',$revert_id_list);
	$this->db->where('college_id_fk', $college_id);
    $this->db->where('operator_id_fk', $operator_id);
    $this->db->update('routine_management_system_details');
    return true;
  }

  public function countStatus($academic_year,$discipline_type,$stud_year,$semester){
      $sql = $this->db->select('status_code')
                      ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('status_code','1')
                      ->get('routine_management_system_details');
      return $sql->num_rows();

  }
  //fetch all course for subject master entry....30-12-2020.....By Rakesh Kundu
  public function get_all_course_subject()
  {
    $query = $this->db->select('
                  a.branch_code_fk,
                  b.course_name                 
                  ')
			->from('discipline_wise_code_master as a')
            ->JOIN('poly_course_master as b','a.branch_code_fk=b.course_id_pk')
            ->where(
                    array('a.active_status' =>'1')
                    )
            ->order_by('b.course_name','asc')
			->group_by('a.branch_code_fk,b.course_name')			
            ->get();
			
			//echo $this->db->last_query();die;
			
    return $query->result_array();    
  }


	public function get_all_course_lists()
	{
		$query = $this->db->select('
									course_id_pk,
									course_name									
									')
						->from('poly_course_master')
						->order_by('course_name','ASC')	
						->get();
		return $query->result_array();		
	}

  //fetch routine time.....date 30-12-2020........By Rakesh Kundu
  public function getPeriodtime($academic_year,$discipline_type,$stud_year,$semester,$college_id){
    $sql = $this->db->select('period_start_time,period_end_time')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
					  ->where('active_status','1')
					  ->where('college_id_fk',$college_id)
                      ->group_by('period_start_time')
                      ->group_by('period_end_time')
                      ->order_by('period_start_time')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  } 

  public function getMondayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
	  $operator_id = $this->session->userdata('stake_holder_login_id_pk');
		$sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
					  ->where('college_id_fk',$college_id)
					  ->where('operator_id_fk',$operator_id)
					  ->where('status_code','1')
                      ->where('days_id_fk','1')
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
   public function getTuesdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
	   $operator_id = $this->session->userdata('stake_holder_login_id_pk');
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','2')
					  ->where('college_id_fk',$college_id)
					  ->where('operator_id_fk',$operator_id)
					  ->where('status_code','1')
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  public function getWednesdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
	  $operator_id = $this->session->userdata('stake_holder_login_id_pk');
	  $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','3')
					  ->where('college_id_fk',$college_id)
					  ->where('operator_id_fk',$operator_id)
					  ->where('status_code','1')
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  public function getThrusdatroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
	  $operator_id = $this->session->userdata('stake_holder_login_id_pk');
      $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','4')
					  ->where('college_id_fk',$college_id)
					  ->where('operator_id_fk',$operator_id)
					  ->where('status_code','1')
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  public function getFridayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
	  $operator_id = $this->session->userdata('stake_holder_login_id_pk');
      $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','5')
					  ->where('college_id_fk',$college_id)
					  ->where('operator_id_fk',$operator_id)
					  ->where('status_code','1')
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  public function getSataurdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
	  $operator_id = $this->session->userdata('stake_holder_login_id_pk');
      $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','6')
					  ->where('college_id_fk',$college_id)
					  ->where('operator_id_fk',$operator_id)
					  ->where('status_code','1')
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  //insert subject master data...30-12-2020....By Rakesh Kundu
  public function insertSubjectmasterdata($data){
    return $this->db->insert('discipline_wise_code_master',$data);
  }
  // fetch subject for edit .....08-01-2021.....by Rakesh Kundu

   public function serachsubjectMasterdata($course_name,$semester,$subject_type){
    $sql = $this->db->select('discipline_id_pk,branch_code_fk,semester_code_fk,subject_type_fk,subject_code,subject_description')
                    ->from('discipline_wise_code_master')
                    ->where('branch_code_fk',$course_name)
                    ->where('semester_code_fk',$semester)
                    ->where('subject_type_fk',$subject_type)
                    ->where('active_status','1')
                    ->order_by('subject_description')
                    ->get();
    return $sql->result_array();
   }

   //fetch subject detais for ajax view ..............08-01-2021..........by Rakesh Kundu
   public function getEditsubjectdetails($discipline_id_pk){
   $sql = $this->db->select('discipline_id_pk,branch_code_fk,semester_code_fk,subject_type_fk,subject_code,subject_description')
                    ->from('discipline_wise_code_master')
                     ->where(
                          array(
                                  'MD5(CAST(discipline_id_pk AS character varying))=' =>$discipline_id_pk
                              )
                        )
                    ->where('active_status','1')
                    ->get();
    return $sql->result_array();

   }

   //update subject name using ajax...................08-01-2021.................by Rakesh Kundu
    public function updateSubjectname($discipline_id_pk,$subject_description){
      return $this->db->set('subject_description',$subject_description)
                      ->where(
                          array(
                                  'MD5(CAST(discipline_id_pk AS character varying))=' =>$discipline_id_pk
                              )
                        )
                      ->update('discipline_wise_code_master');
    }
    //fetch only last subject code ..................10-01-2021.......................by Rakesh Kundu
    public function lastSubjectcode(){
      $sql = $this->db->select_max('subject_code')
                      ->get('discipline_wise_code_master');
      return $sql->result_array();
    }
	//...................Delete Routines....................//
    public function fetchAllroutinedetails($routine_manage_id_pk){
      $sql = $this->db->select('*')
              ->where(
                          array(
                                  'MD5(CAST(routine_manage_id_pk AS character varying))=' =>$routine_manage_id_pk
                              )
                    )
              ->where('status_code','1')
              ->where('active_status','1')
              ->get('routine_management_system_details');
      return $sql->result_array();

    }


    public function insertArchiveddetails($routines){
      return $this->db->insert_batch('routine_management_system_details_archived',$routines);
    }

    public function updateDetailsdata($routine_manage_id_pk){
	  $operator_id = $this->session->userdata('stake_holder_login_id_pk');
	  $college_id = $this->session->userdata('stake_details_id_fk');
      return $this->db->set('active_status','0')
                      ->where(
                          array(
                                  'MD5(CAST(routine_manage_id_pk AS character varying))=' =>$routine_manage_id_pk
                              )
                        )
						->where('college_id_fk',$college_id)
						//->where('operator_id_fk',$operator_id)
                      ->update('routine_management_system_details');
    }

    public function updateRoutinemapping($routine_manage_id_pk){
      return $this->db->set('active_status','0')
              ->where(
                          array(
                                  'MD5(CAST(routine_details_fk AS character varying))=' =>$routine_manage_id_pk
                              )
              )
              ->update('routine_management_maping_details');
    }


	//..........Tutorila Subjects.....//
  public function get_tutorial_subject($semester,$discipline_type){

    $query = $this->db->select('subject_code')
                         ->select('subject_description')
                            ->from('discipline_wise_code_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->where(
                                    array('subject_type_fk' =>'5')
                                )
                            ->where(
                                    array('branch_code_fk' =>$discipline_type)
                                )
                            ->where(
                                    array('semester_code_fk' =>$semester)
                                )
                            // ->group_by('subject_description')
                            // ->group_by('subject_code')
                            ->get();
                            // echo  $this->db->last_query();
                           //  exit;
            return $query->result_array();
  }
  
  public function getAlledittutorialsubject($course_id_pk,$semester_id){
      $query = $this->db->select('subject_code')
                        ->select('subject_description')
                           ->from('discipline_wise_code_master')
                           ->where(
                                   array('active_status' =>'1')
                               )
                           ->where(
                                   array('subject_type_fk' =>'5')
                               )
                           ->where(
                                   array('branch_code_fk' =>$course_id_pk)
                               )
                           ->where(
                                   array('semester_code_fk' =>$semester_id)
                               )
                           // ->group_by('subject_description')
                           // ->group_by('subject_code')
                           ->get();
           return $query->result_array();
   }
   
    // fetch all tutorual subjects
    public function getAlltutorialsubject(){
       $query = $this->db->select('subject_code')
                         ->select('subject_description')
                            ->from('discipline_wise_code_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->where(
                                    array('subject_type_fk' =>'5')
                                )
                            ->group_by('subject_description')
                            ->group_by('subject_code')
                            ->get();
            return $query->result_array();
    }


  //...............//
  public function routineDisplatfortest(){
	  $sql = $this->db->select('days_id_fk,period_no')
					->where('college_id_fk','15')
					//->where('days_id_fk','2')
					//->where('period_no','3')
					->where('active_status','1')
					->order_by('days_id_fk')
					->get('routine_management_system_details');
		return $sql->result_array();
  }
  
	public function subejctDeleted($discipline_id_pk){
      return $this->db->set('active_status','0')
					  ->set('delete_ip',$this->input->ip_address())
					  ->set('deleted_by',$this->session->userdata('stake_holder_login_id_pk'))
					  ->set('deleted_time',date('Y-m-d H:i:s'))
              ->where(
                          array(
                                  'MD5(CAST(discipline_id_pk AS character varying))=' =>$discipline_id_pk
                              )
              )
              ->update('discipline_wise_code_master');
    }
	
	 //fetch routine time.....date 30-12-2020........By Rakesh Kundu
  public function getPeriodtime_new($college_id)
  {
    $sql = $this->db->select('period_start_time,period_end_time')
      ->where('active_status', '1')
      ->where('college_id_fk', $college_id)
	  ->limit(7)
      ->group_by('period_start_time')
      ->group_by('period_end_time')
      ->order_by('period_start_time')
      ->get('poly_period_time_master');
	  
    return $sql->result_array();
  }
  
  //......................Fetch Routine Forward Detais.............................//


  public function getAllroutinesdetails_new($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,$days_id,$routine_mode,$section_name)
  {
	  
    $sql = $this->db->select('a.routine_manage_id_pk,a.subject_id_fk,a.room_no,a.period_type_fk,a.days_id_fk,a.period_no,period_type.description as periodtype,a.routine_online_status,a.routine_unique_id')
      ->from('routine_management_system_details as a')
      //->JOIN('discipline_wise_code_master  as b', 'a.subject_id_fk = b.subject_code', 'LEFT')
      ->JOIN('poly_period_type_master  as period_type', 'a.period_type_fk = period_type.id', 'LEFT')
      ->where('a.college_id_fk', $college_id)
	  ->where('a.operator_id_fk', $operator_id)
      ->where('a.discipline_id_fk ', $discipline_type)
      ->where('a.academic_year_fk', $academic_year)
      ->where('a.semester_id_fk', $semester)
      ->where('a.year_id_fk', $stud_year)
	  ->where('a.days_id_fk', $days_id)
      ->where('a.active_status', '1')
      ->where('a.status_code', $routine_mode)
      ->where('a.section_id_fk',$section_name)
      ->order_by('a.days_id_fk')
      ->order_by('a.period_no')
      ->group_by('a.routine_manage_id_pk,a.subject_id_fk,a.room_no,a.period_type_fk,periodtype,a.routine_unique_id')
      ->get()->result_array();
		
    foreach ($sql as $key => $value) {


      $sql[$key]['teacher'] = $this->db->select('employee_id,emp.first_name,emp.midle_name,emp.last_name')
        ->from('routine_management_maping_details as a')
        ->join('poly_college_emp_basic as emp', 'a.employee_id = emp.emp_basic_id_pk', 'LEFT')
        ->where('a.routine_details_fk', $value['routine_manage_id_pk'])
        ->where('a.active_status', '1')
        ->group_by('employee_id,emp.first_name,emp.midle_name,emp.last_name')
        ->get()->result_array();

     $sql[$key]['subject'] = $this->db->select('b.subject_id,dwcm.subject_description')
        ->from('poly_subject_mapping_master as b')
        ->JOIN('discipline_wise_code_master as dwcm', 'dwcm.subject_code = b.subject_id', 'LEFT')
        ->where('b.routine_details_fk', $value['routine_manage_id_pk'])
        ->where('dwcm.branch_code_fk', $discipline_type)
        ->where('dwcm.semester_code_fk', $semester)
        ->where('b.active_status', '1')
        ->group_by('b.subject_id,dwcm.subject_description')
        ->get()->result_array();
      # code...
    }
    return $sql;
  }


	public function getAllroutinesdetailsid($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester){
	   return $this->db->select('a.routine_manage_id_pk')
      ->from('routine_management_system_details as a')
      ->where('a.college_id_fk', $college_id)
	  ->where('a.operator_id_fk', $operator_id)
      ->where('a.discipline_id_fk ', $discipline_type)
      ->where('a.academic_year_fk', $academic_year)
      ->where('a.semester_id_fk', $semester)
      ->where('a.year_id_fk', $stud_year)
      ->where('a.active_status', '1')
      ->where('a.status_code', '1')
      ->get()
	  ->result_array();
	  

	}
	
	 // fetch the routine list
  public function get_all_routine_list_all($college_id = NULL, $operator_id = NULL, $limit = NULL, $offset = NULL)
  {
    $query = $this->db->select('routine.routine_manage_id_pk')
      ->select('routine.routine_unique_id')
      ->select('routine.academic_year_fk')
      ->select('routine.period_no')
      ->select('routine.room_no')
      ->select('routine.period_type_fk')
      ->select('days.description as days_desc')
      ->select('period_no.description as period_no_desc')
      ->select('routine.period_start_time')
      ->select('routine.period_end_time')
      ->select('period_type.description as period_type_desc')
      ->select('routine.section_id_fk')
      ->select('section.section_name as sectiondata')
      ->select('routine.status_code')
      ->select('process_master.process_description')
      ->from('routine_management_system_details as routine')
      ->join('routine_management_maping_details as routine_map', 'routine_map.routine_details_fk = routine.routine_manage_id_pk', 'LEFT')
      ->join('poly_days_master as days', 'days.id = routine.days_id_fk', 'LEFT')

      ->join('poly_period_type_master as period_type', 'period_type.id = routine.period_type_fk', 'LEFT')

      ->join('poly_period_no_master as period_no', 'period_no.id = routine.period_no', 'LEFT')
      ->join('routine_section_master as section', 'routine.section_id_fk= section.section_id_pk', 'LEFT')

      ->join('routine_process_master as process_master', 'process_master.process_id_pk = routine.status_code', 'LEFT')
      ->group_by('days_desc')
      ->group_by('period_no_desc')
      ->group_by('period_type_desc')
      ->group_by('process_description')
      ->group_by('sectiondata')
      ->group_by('routine.routine_manage_id_pk')
      ->where('routine.college_id_fk', $college_id)
      ->where('routine.operator_id_fk', $operator_id)
      ->where('routine.active_status', '1')
      ->limit($limit, $offset)
      //->order_by('routine.routine_manage_id_pk')
      //->order_by('routine.period_no')
      ->order_by('routine.days_id_fk')
      ->get();

    return $query->result_array();
  }
  
  public function countStatus_routine($college_id, $operator_id,$academic_year, $discipline_type, $stud_year, $semester,$routine_mode,$section_name)
  {
    $sql = $this->db->select('status_code,routine_manage_id_pk')
      ->where('academic_year_fk', $academic_year)
      ->where('discipline_id_fk', $discipline_type)
      ->where('year_id_fk', $stud_year)
      ->where('semester_id_fk', $semester)
      ->where('active_status', '1')
      ->where('status_code', $routine_mode)
      ->where('college_id_fk', $college_id)
	  ->where('operator_id_fk', $operator_id)
	  ->where('status_code', $routine_mode)
	  ->where('section_id_fk', $section_name)
      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  
  public function fetchSectiondata()
  {
    return  $this->db->select('section_id_pk,section_name')
      ->where('active_status', '1')
	  ->order_by('section_name')
      ->get('routine_section_master')->result_array();
  }
}
?>