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
    // fetch all subjects
    public function getAllsubject(){
       $query = $this->db->select('*')
                            ->from('subject_code_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->get();
            return $query->result_array();
    }
    //Count for pagination
    public function get_count_routine_list(){
      $college_id = $this->session->userdata('stake_details_id_fk');
      $query = $this->db->select('count(*)')
                        ->where('college_id_fk',$college_id)
                        ->where('active_status','1')
                        ->get('routine_management_system_details');
      return $query->result_array(); 


    }
    //employee Name
    public function get_all_employee_lists($routine_id){
      $query = $this->db->select('a.first_name')
                        ->select('a.midle_name')
                        ->select('a.last_name')
                        ->where(
                        array(
                                'MD5(CAST(b.routine_details_fk AS character varying))=' =>$routine_id
                            )
                      )
					  ->where(
                                array('process_id_fk' =>'104')
                                )
                      ->from('poly_college_emp_basic as a')
                      ->JOIN('routine_management_maping_details as b','a.emp_basic_id_pk=b.employee_id','LEFT')
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
 b.first_working_arrangenent_poly_name  = '".$college_id."' AND a.process_id_fk ='104' AND b.working_arrangement = '1' 
AND  
(b.first_working_arrangenent_from_date is not null OR b.first_working_arrangenent_end_date is null) 
AND 
(b.second_working_arrangenent_from_date is not null OR b.second_working_arrangenent_end_date is null)
AND 
(b.third_working_arrangenent_from_date is not null OR b.third_working_arrangenent_end_date is null)
");
            return $query->result_array();

    }
    //Prac
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
    
    public function get_all_routine_list_all($college_id = NULL,$limit = NULL, $offset = NULL){
      $query = $this->db->select('routine.routine_manage_id_pk')
                        ->select('days.description as days_desc')
                        ->select('course.course_name as course_name')
                        ->select('year.description as year_desc')
                        ->select('routine.routine_unique_id') 
                        ->select('semester.description as sem_desc')
                        ->select('period_no.description as period_no_desc')
                        ->select('routine.status_code')
                        ->select('routine.section_id_fk')
                        ->select('section.section_name as sectiondata')
                        ->select('process_master.process_description')
                        
                        
                        ->from('routine_management_system_details as routine')
                        ->join('routine_management_maping_details as routine_map','routine_map.routine_details_fk = routine.routine_manage_id_pk','LEFT')
                       ->join('poly_days_master as days','days.id = routine.days_id_fk','LEFT')

                       ->join('poly_course_master as course','course.course_id_pk = routine.discipline_id_fk','LEFT')

                       ->join('poly_year_master as year','year.id = routine.year_id_fk','LEFT')

                       ->join('poly_semester_master as semester','semester.id = routine.semester_id_fk','LEFT')

                       ->join('poly_period_no_master as period_no','period_no.id = routine.period_no','LEFT')

                       ->join('routine_process_master as process_master','process_master.process_id_pk = routine.status_code','LEFT')

                       ->join('poly_college_emp_basic as emp_details','emp_details.emp_basic_id_pk = routine_map.employee_id','LEFT')
					   
                       ->join('routine_section_master as section','section.section_id_pk = routine.section_id_fk','LEFT')

                       ->group_by('days_desc')
                       ->group_by('period_no_desc')
                       ->group_by('course_name')
                       ->group_by('year_desc')
                       ->group_by('course_name')
                       ->group_by('sem_desc')
                       ->group_by('process_description')
                       ->group_by('routine.routine_manage_id_pk')
                       ->group_by('sectiondata')
                       //->group_by('routine_map.employee_id')
                       ->limit($limit, $offset)
                       ->where('routine.college_id_fk',$college_id)
                       ->where('routine.active_status','1');
                     
                    
                       $query = $query->get();
                       return $query->result_array();  
    }
    public function get_all_routine_list($academic_session=NULL,$college_id=NULL,$days_name=NULL,$discipline_type=NULL,$stud_year=NULL,$semester =NULL,$period_no =NULL,$emp_id = NULL,$section_name = NULL){
      
      $query = $this->db->select('routine.routine_manage_id_pk')
                        ->select('days.description as days_desc')
                        ->select('course.course_name as course_name')
                        ->select('year.description as year_desc')
                        ->select('routine.routine_unique_id') 
                        ->select('semester.description as sem_desc')
                        ->select('period_no.description as period_no_desc')
                        ->select('routine.status_code')
                        ->select('routine.section_id_fk')
                        ->select('section.section_name as sectiondata')
                        ->select('process_master.process_description')
                        
                        
                        ->from('routine_management_system_details as routine')
                        ->join('routine_management_maping_details as routine_map','routine_map.routine_details_fk = routine.routine_manage_id_pk','LEFT')
                       ->join('poly_days_master as days','days.id = routine.days_id_fk','LEFT')

                       ->join('poly_course_master as course','course.course_id_pk = routine.discipline_id_fk','LEFT')

                       ->join('poly_year_master as year','year.id = routine.year_id_fk','LEFT')

                       ->join('poly_semester_master as semester','semester.id = routine.semester_id_fk','LEFT')

                       ->join('poly_period_no_master as period_no','period_no.id = routine.period_no','LEFT')

                       ->join('routine_process_master as process_master','process_master.process_id_pk = routine.status_code','LEFT')

                       ->join('poly_college_emp_basic as emp_details','emp_details.emp_basic_id_pk = routine_map.employee_id','LEFT')
					   
                       ->join('routine_section_master as section','section.section_id_pk = routine.section_id_fk','LEFT')

                       ->group_by('days_desc')
                       ->group_by('period_no_desc')
                       ->group_by('course_name')
                       ->group_by('year_desc')
                       ->group_by('course_name')
                       ->group_by('sem_desc')
                       ->group_by('process_description')
                       ->group_by('sectiondata')
                       ->group_by('routine.routine_manage_id_pk')
                       // ->group_by('routine_map.employee_id')
                       ->order_by('course.course_name')
                       
                       ->where('routine.college_id_fk',$college_id)
                       ->where('routine.active_status','1');
						if($academic_session){
                          $query = $query->where('routine.academic_year_fk',$academic_session);
                        }
                        if($days_name){
                          $query = $query->where('routine.days_id_fk',$days_name);
                        }
                        if($discipline_type){
                          $query = $query->where('routine.discipline_id_fk',$discipline_type);
                        }
                        if($stud_year){
                          $query = $query->where('routine.year_id_fk',$stud_year);
                        }
                        if($semester){
                          $query = $query->where('routine.semester_id_fk',$semester);
                        }
                        if($period_no){
                          $query = $query->where('routine.period_no',$period_no);
                        }
                        if($emp_id){
                          $query = $query->where('routine_map.employee_id',$emp_id);
                        }
						if($section_name){
                          $query = $query->where('routine.section_id_fk',$section_name);
                        }
                      
                       $query = $query->get();
                      
                       return $query->result_array();  
    }

   public function get_all_routine_list_using_id($routine_id){
      $query = $this->db->select('routine.routine_manage_id_pk,
									routine.college_id_fk,
									routine.routine_unique_id,
									routine.operator_id_fk,
									routine_map.employee_id,
									days.description as days_desc,
									days.id as days_id,
									academic_year.academic_year_description,
									academic_year.academic_year_id_pk,
									period_no.id as period_no_id,
									period_no.description as period_no_desc,
									routine.period_start_time,
									routine.period_end_time,
									routine.period_type_fk,
									period_type.description as period_type_desc,
									year.description as year_desc,
									period_type.id as period_type_id,
									routine.room_no,
									course.course_id_pk,
									course.course_name,
									routine.year_id_fk,
									semester.id as sem_id,
									semester.description as sem_desc,
									routine.subject_id_fk,
									subject.subject_description as subject_desc,
									emp_details.first_name,
									emp_details.midle_name,
									emp_details.last_name,
									routine.status_code,
									process_master.process_description,
									routine.revert_reason,
									routine.entry_time,
									routine.section_id_fk,
									section.section_name
	  
							')
                       
                        
                        
                        
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
    public function revertRoutine($routine_manage_id_hash,$update_array){
	  $college_id = $this->session->userdata('stake_details_id_fk');
      return $this->db->set('status_code','3')
                      ->set('routine_revart_time',$update_array['routine_revart_time'])
                      ->set('routine_revart_ip',$update_array['routine_revart_ip'])
                      ->set('routine_revart_by',$update_array['routine_revart_by'])
                      ->set('revert_reason',$update_array['revert_reason'])
					  ->set('active_status','1')
                      ->where(
                                array(
                                        'MD5(CAST(routine_manage_id_pk AS character varying))=' =>$routine_manage_id_hash
                                    )
                                )
					  ->where('college_id_fk',$college_id)
                      ->update('routine_management_system_details');

      
    }
    //approve using indivisual id
    public function approveRoutineusingid($routine_manage_id_pk = NULL){
        $college_id = $this->session->userdata('stake_details_id_fk');
        return $this->db->set('status_code','4')
                        ->set('approved_by',$college_id)
                        ->set('routine_approved_time',date('Y-m-d H:i:s'))
                        ->set('routine_approved_ip',$this->input->ip_address())
                        ->where(
                          array(
                                  'MD5(CAST(routine_manage_id_pk AS character varying))=' =>$routine_manage_id_pk
                              )
                          )
						 ->where('college_id_fk',$college_id)
                        ->update('routine_management_system_details');
    }

   
    public function fionalapproveRoutine($routine_id = NULL){
      return $this->db->set('status_code','4')
                      ->where('routine_details_fk',$routine_id)
                      ->update('routine_management_maping_details');
    }

    public function fionalrejectRoutine($routine_id = NULL){
      $data =  $this->db->set('status_code','6')
                      ->where('routine_details_fk',$routine_id)
                      ->update('routine_management_maping_details');
      if($data){
        return $this->db->set('status_code','6')
                      ->where('routine_manage_id_pk',$routine_id)
                      ->update('routine_management_system_details');
      }
    }    

     // fetch class execution
    public function getClassexecutiondata($emp_id){
       $query = $this->db->select('a.excecution_id_pk')
                        ->select('a.class_execution_date')
                        ->select('a.topic_coverd')
                        ->select('a.topic_coverd_desc')
                        ->select('a.status_code_fk')
                        ->select('b.process_description')
                        ->select('c.reason_master_description')
            ->from('routine_class_execution_maping as a')
            ->join('routine_process_master as b','a.status_code_fk= b.process_id_pk','LEFT')
            ->join('routine_class_execution_reason_master as c','a.topic_coverd_desc_no= c.reason_master_id_pk','LEFT')
            ->where(
                    array(
                          'MD5(CAST(employee_id_fk AS character varying))=' =>$emp_id
                        )
                  )
            ->get();
      return $query->result_array();
    }

    // execution approve
    public function executionApprove($excecution_id_pk = NULL){
      return $this->db->set('status_code_fk','4')
					  ->set('execution_approve_time',date('Y-m-d H:i:s'))
					  ->set('execution_approve_ip',$this->input->ip_address())
					  ->set('execution_approve_by',$this->session->userdata('stake_details_id_fk'))
                      ->where(
                    array(
                          'MD5(CAST(excecution_id_pk AS character varying))=' =>$excecution_id_pk
                        )
                  )
                      ->update('routine_class_execution_maping');
    }
    // execution reject
    public function executionReject($excecution_id_pk = NULL){
      return $this->db->set('status_code_fk','6')
                      ->where(
                    array(
                          'MD5(CAST(excecution_id_pk AS character varying))=' =>$excecution_id_pk
                        )
                  )
                      ->update('routine_class_execution_maping');
    }

     public function get_all_routine_list_using_id_revert($routine_id = NULL){
      $query = $this->db->select('routine.routine_manage_id_pk')
                        ->select('days.description as days_desc')
                        ->select('academic_year.academic_year_description')
                        ->from('routine_management_system_details as routine')
                         ->join('poly_days_master as days','days.id = routine.days_id_fk','LEFT')
                         ->join('routine_academic_session_year_master as academic_year','academic_year.academic_year_id_pk = routine.academic_year_fk','LEFT')

                       ->where(
                                array(
                                        'MD5(CAST(routine_manage_id_pk AS character varying))=' =>$routine_id
                                    )
                                )
                       ->get();
        return $query->result_array();      
    }
    //get count for pagination
    public function getcountexecution(){
      $college_id = $this->session->userdata('stake_details_id_fk');
       $query = $this->db->select('count(*)')
                        ->where('college_id_fk',$college_id)
                        ->where('active_status','1')
                        ->get('routine_class_execution_maping');
        return $query->result_array();
    }
    public function getAllexecution_all($college_id = NULL,$limit = NULL, $offset = NULL){
            $query = $this->db->select('execution.excecution_id_pk')
                        ->select('execution.employee_id_fk')
                        ->select('emp_details.first_name')
                        ->select('emp_details.midle_name')
                        ->select('emp_details.last_name')
                        ->select('process_master.process_description')
                        ->select('execution.class_execution_date')
                        ->select('execution.topic_coverd')
                        ->select('execution.topic_coverd_desc')
                        ->select('execution.topic_coverd_desc_no')
                        ->select('execution.status_code_fk')
                        ->select('execution.remarks')
                        ->select('routine.semester_id_fk')
                        ->select('routine.period_start_time')
                        ->select('routine.period_end_time')
                        ->select('routine.discipline_id_fk')
                        ->from('routine_class_execution_maping as execution')
                        ->join('poly_college_emp_basic as emp_details','emp_details.emp_basic_id_pk = execution.employee_id_fk','LEFT')
                        ->join('routine_process_master as process_master','process_master.process_id_pk = execution.status_code_fk','LEFT')
                        ->join('routine_management_system_details as routine','routine"."routine_manage_id_pk = execution"."routine_details_id_fk','LEFT')
                        ->where('execution.college_id_fk',$college_id)
                        ->where('execution.active_status','1')
                        ->limit($limit, $offset)
                        ->get();
                        return $query->result_array();
    }
    public function getAllexecution($college_id,$date =NULL,$to_date=NULL,$emp_id =NULL,$type=NULL){
			
			
            $query = $this->db->select('execution.excecution_id_pk')
                        ->select('execution.employee_id_fk')
                        ->select('emp_details.first_name')
                        ->select('emp_details.midle_name')
                        ->select('emp_details.last_name')
                        ->select('process_master.process_description')
                        ->select('execution.class_execution_date')
                        ->select('execution.topic_coverd')
                        ->select('execution.status_code_fk')
                        ->select('execution.topic_coverd_desc')
                        ->select('execution.topic_coverd_desc_no')
                        ->select('execution.status_code_fk')
                         ->select('execution.remarks')
                        ->select('routine.semester_id_fk')
                        ->select('routine.period_start_time')
                        ->select('routine.period_end_time')
                        ->select('routine.discipline_id_fk')
                        ->from('routine_class_execution_maping as execution')
                        ->join('poly_college_emp_basic as emp_details','emp_details.emp_basic_id_pk = execution.employee_id_fk','LEFT')
                        ->join('routine_process_master as process_master','process_master.process_id_pk = execution.status_code_fk','LEFT')
                        ->join('routine_management_system_details as routine','routine"."routine_manage_id_pk = execution"."routine_details_id_fk','LEFT')
                        ->where('execution.active_status','1')
                        ->where('execution.college_id_fk',$college_id);
                        if($emp_id){
                          $query = $query->where('execution.employee_id_fk', $emp_id);
                        }
                        if($type){
                          $query = $query->where('execution.status_code_fk',$type);
                        }
                        if($date){
                          $query = $query->where('execution.class_execution_date>=', $date );
                        }
                        if($date && $to_date){
							
                          //$query = $query->where('execution.class_execution_date>=',$date.'"and"'.'execution.class_execution_date<=',$to_date );
							
							$query = $query->where("execution.class_execution_date BETWEEN '$date' AND '$to_date'");
							//->where("quali.data_of_initial_joining BETWEEN '$start_date' AND '$end_date'")
						}
                        $query = $query->get();
                        return $query->result_array();
    }

    public function approveAllexecutiondata($class_execution_id){
       return $this->db->set('status_code_fk','4')
                      ->where_in('excecution_id_pk',$class_execution_id)
                      ->update('routine_class_execution_maping');
    }

     public function approveforwardRoutine($routine_id){
		 
       $college_id = $this->session->userdata('stake_details_id_fk');
       return $this->db->set('status_code','4')
                        ->set('approved_by',$college_id)
                        ->set('routine_approved_time',date('Y-m-d H:i:s'))
                        ->set('routine_approved_ip',$this->input->ip_address())
						->where_in('routine_manage_id_pk',$routine_id)
						->where('college_id_fk',$college_id)
						->update('routine_management_system_details');
    }

    public function get_allforwarddata($academic_year,$discipline_type,$stud_year,$semester,$college_id){
      $query = $this->db->select('routine.period_no')
                        ->select('routine.period_start_time')
                        ->select('routine.period_end_time')
                        ->select('routine.period_type_fk')
                        ->select('routine.room_no')
                        ->select('routine.subject_id_fk')
                        ->select('routine.days_id_fk')
                        ->select('routine.routine_manage_id_pk')
                        ->select('routine.period_type_fk')
                        ->where('academic_year_fk',$academic_year)
                        ->where('discipline_id_fk',$discipline_type)
                        ->where('year_id_fk',$stud_year)
                        ->where('semester_id_fk',$semester)
                        ->where('active_status','1')
                        ->where('status_code','2')
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
                      
      return $query->result_array();
    }

  public function overlapingCheking($college_id){
    $query =$this->db->query("select k.days_id_fk, k.period_no,k.room_no,k.employee_id,k.period_start_time,k.period_end_time,k.period_type_fk,k.discipline_id_fk,
    k.routine_unique_id,k.semester_id_fk,k.year_id_fk from 
    (select c.days_id_fk, c.period_no,c.room_no,c.period_start_time,c.period_end_time,c.period_type_fk,c.discipline_id_fk,c.routine_unique_id, c.year_id_fk,
     COUNT(c.routine_manage_id_pk) as t,s.employee_id ,c.semester_id_fk from routine_management_system_details as c
    INNER JOIN routine_management_system_details as a on 
        c.days_id_fk = a.days_id_fk
        AND c.period_no = a.period_no
        AND c.room_no = a.room_no
       AND c.active_status =1
       AND c.college_id_fk = 13
     left JOIN routine_management_maping_details as s on c.routine_manage_id_pk=s.routine_details_fk
      where c.active_status=1 
    GROUP BY c.days_id_fk, c.period_no,c.room_no,c.routine_manage_id_pk,employee_id) as k
     where t>1 
    ORDER BY k.days_id_fk, k.period_no,k.room_no,routine_unique_id
    
    
    
    ");
    return $query->result_array();
  }

  public function getAllnroomno(){
    $college_id = $this->session->userdata('stake_details_id_fk');
    $query = $this->db->select('room_no')
                      ->where('college_id_fk',$college_id)
                      ->where('active_status','1')
                      ->group_by('room_no')
                      ->get('routine_management_system_details');
    return $query->result_array();
  }

  //.....................Execution Reject with remarks......................//

  public function getRejectdetails($routine_hash){

      $query = $this->db->select('*')
                        ->where('active_status','1')
                        ->where(
                                array(
                                        'MD5(CAST(excecution_id_pk AS character varying))=' =>$routine_hash
                                    )
                              )
                        ->get('routine_class_execution_maping');
        return $query->result_array();


  }

    public function rejectRemarks($routine_hash,$update_array){
      return $this->db->set('reject_remarks',$update_array['reject_remarks'])   
                        ->set('reject_remarks_time',$update_array['reject_remarks_time'])
                        ->set('remarks_reject_by',$update_array['remarks_reject_by'])
                        ->set('remaks_rejecet_by_ip',$update_array['remaks_rejecet_by_ip'])
                        ->set('status_code_fk',$update_array['status_code_fk'])
                        ->where(
                                array(
                                        'MD5(CAST(excecution_id_pk AS character varying))=' =>$routine_hash
                                    )
                              )
                        ->update('routine_class_execution_maping');


    }

    public function approveAllroutinedata($routine_id){
	  $college_id = $this->session->userdata('stake_details_id_fk');
		return $this->db->set('status_code','4')
						->set('approved_by',$college_id)
						->set('routine_approved_time',date('Y-m-d H:i:s'))
						->set('routine_approved_ip',$this->input->ip_address())
						->where_in('routine_manage_id_pk',$routine_id)
						->where('college_id_fk',$college_id)
						->update('routine_management_system_details');
    }

    public function getCoverddetails($topic_id){
     return $this->db->select('topic_coverd_desc,total_no_studnets_registerd,total_no_of_students_attends')
                      ->where('excecution_id_pk',$topic_id)
                      ->get('routine_class_execution_maping')->result_array();
					  
     
    }

     //fetch routine time.....date 30-12-2020........By Rakesh Kundu
  public function getPeriodtime($college_id, $discipline_type, $academic_year, $semester,$stud_year){
    $sql = $this->db->select('period_start_time,period_end_time')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
					  ->where('college_id_fk',$college_id)
                      ->group_by('period_start_time')
                      ->group_by('period_end_time')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }

  public function getMondayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','1')
					  ->where('status_code','2')
					  ->where('college_id_fk',$college_id)
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
   public function getTuesdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','2')
					   ->where('status_code','2')
					  ->where('college_id_fk',$college_id)
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  public function getWednesdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','3')
					   ->where('status_code','2')
					  ->where('college_id_fk',$college_id)
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  public function getThrusdatroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
					  ->where('college_id_fk',$college_id)
                      ->where('days_id_fk','4')
					   ->where('status_code','2')
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  public function getFridayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','5')
					   ->where('status_code','2')
					  ->where('college_id_fk',$college_id)
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  public function getSataurdayroutinelist($academic_year,$discipline_type,$stud_year,$semester,$college_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk')
                     ->where('academic_year_fk',$academic_year)
                      ->where('discipline_id_fk',$discipline_type)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','6')
					   ->where('status_code','2')
					  ->where('college_id_fk',$college_id)
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  } 
  
   // fetch all theory subjects for edit.........08-01-2021.......By Rakesh Kundu
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

    // fetch all practical subjects for edit........08-01-2021..........by Rakesh Kundu
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

    //fetech only employee ids...............08-01-2021...........by Rakesh Kundu
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
  //fetch only subject ids...........08-01-2021...........by rakesh kundu
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

  //update routine list by college..........08-01-2021............by Rakesh Kundu
  public function updateRoutinelist($routine_id_fk){
        $this->db->set('active_status','0')
                 ->where('routine_manage_id_pk',$routine_id_fk)
                 ->update('routine_management_system_details');

        return $this->db->set('active_status','0')
                 ->where('routine_details_fk',$routine_id_fk)
                 ->update('routine_management_maping_details');

    }
    //insert routine..........08-01-2021.................by rakehs kundu

   public function insertRoutinelist($data){
    $this->db->insert('routine_management_system_details',$data);
    $insert_id = $this->db->insert_id();
    return $insert_id;     
  }

   // insert the routine mapping data..........08-01-2021...........by rakesh kundu
   public function insertEmployeedatalist($ins){
    return $this->db->insert('routine_management_maping_details',$ins);
  }

    //Insert only practical subject details........08-01-2021............by rakesh kundu
    public function insertSubjectdetails($ins_prac){
     return $this->db->insert('poly_subject_mapping_master',$ins_prac);
    }
  
     public function UpdatebasicRoutinelist($data,$routine_id_fk){
           
          return $this->db->set('college_id_fk',$data['college_id_fk'])
                          ->set('routine_unique_id',$data['routine_unique_id'])
                          //->set('operator_id_fk',$data['operator_id_fk'])
                          ->set('academic_year_fk',$data['academic_year_fk'])
                          ->set('year_id_fk',$data['stud_year'])
                          ->set('semester_id_fk',$data['semester'])
                          ->set('discipline_id_fk',$data['discipline_id_fk'])
                          ->set('days_id_fk',$data['days_id_fk'])
                          ->set('period_no',$data['period_no'])
						  ->set('section_id_fk','3')
                          ->set('period_start_time',$data['period_start_time'])
                          ->set('period_end_time',$data['period_end_time'])
                          ->set('period_type_fk',$data['period_type_fk'])
                          ->set('updated_time',$data['updated_time'])
                          ->set('updated_ip',$data['updated_ip'])
                          ->set('active_status','1')
                          ->where('routine_manage_id_pk',$routine_id_fk)
                          ->update('routine_management_system_details');
    }

      public function getPeriodlist($period_type,$discipline_type,$semester){
      $query = $this->db->select('subject_code')
                        ->select('subject_description')
                        ->where('branch_code_fk',$discipline_type)
                        ->where('subject_type_fk',$period_type)
                        ->where('semester_code_fk ',$semester)
                        ->get('discipline_wise_code_master');
      return $query->result_array();
  }
  
  //...........New Function for Routine Approve and Download........On 20-12-2021
  public function getAllroutinesdetailssim($college_id_fk, $discipline_name, $academic_session, $semester, $status_code, $stud_year, $days_id,$section_name)
  {

    $sql = $this->db->select('a.routine_manage_id_pk,a.subject_id_fk,a.room_no,a.period_type_fk,a.days_id_fk,a.period_no,period_type.description as periodtype,a.routine_online_status,a.college_id_fk,a.discipline_id_fk,a.academic_year_fk,a.semester_id_fk,a.routine_unique_id,a.period_start_time')
      ->from('routine_management_system_details as a')
      ->JOIN('poly_period_type_master  as period_type', 'a.period_type_fk = period_type.id', 'LEFT')
      ->where('a.semester_id_fk', $semester)
      ->where('a.days_id_fk', $days_id)
      ->where('a.college_id_fk', $college_id_fk)
      ->where('a.discipline_id_fk', $discipline_name)
      ->where('a.academic_year_fk', $academic_session)
      ->where('a.days_id_fk', $days_id)
      ->where('a.status_code', $status_code)
      ->where('year_id_fk', $stud_year)
      ->where('section_id_fk', $section_name)
      ->where('a.active_status', '1')
      ->order_by('a.days_id_fk')
      ->order_by('a.period_no')
      ->group_by('a.routine_manage_id_pk,a.subject_id_fk,a.room_no,a.period_type_fk,periodtype,a.routine_unique_id,a.period_start_time')
      ->get()
      ->result_array();
		

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
        ->where('dwcm.branch_code_fk', $discipline_name)
        ->where('dwcm.semester_code_fk', $semester)
        ->where('b.active_status', '1')
        ->group_by('b.subject_id,dwcm.subject_description')
        ->get()->result_array();

      # code...
    }
    return $sql;
  }
  
   public function countStatus($college_id, $discipline_type, $academic_year, $semester, $status_code, $stud_year)
  {
    $sql = $this->db->select('routine_manage_id_pk')
      ->where('academic_year_fk', $academic_year)
      ->where('discipline_id_fk', $discipline_type)
      ->where('year_id_fk', $stud_year)
      ->where('semester_id_fk', $semester)
      ->where('active_status', '1')
      ->where('status_code', $status_code)
      ->where('college_id_fk', $college_id)
      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  
  public function fetchSectiondata()
  {
    return  $this->db->select('section_id_pk,section_name')
      ->where('active_status', '1')
      ->get('routine_section_master')->result_array();
  }
  

    
}
?>