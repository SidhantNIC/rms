<?php
defined('BASEPATH') OR exit('No direct script access allowed' );

class Employee_routine_model extends CI_Model {

  //fetch all academic year
    public function get_allacademicyear($college_id = NULL){
      $query = $this->db->select('*')
                            ->from('routine_academic_session_year_master')
                            ->where(
                                array('active_status' =>'1')
                                )
                            ->get();
            return $query->result_array();

    }
	
	public function fetchSectiondata()
	  {
		return  $this->db->select('section_id_pk,section_name')
		  ->where('active_status', '1')
		  ->order_by('section_name')
		  ->get('routine_section_master')->result_array();
	  }
//fetch all employee
    public function get_allemp($college_id = NULL){
    	$query = $this->db->select('*')
                            ->from('poly_college_emp_basic')
                            ->where(
                            		array('college_id_fk' => $college_id)
                                )
                            ->get();
            return $query->result_array();

    }
    // fetch all days
    public function getAlldays(){
       $query = $this->db->select('*')
                            ->from('poly_days_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->get();
            return $query->result_array();
    }
    // fetch all period no
    public function getAllperiodno(){
       $query = $this->db->select('*')
                            ->from('poly_period_no_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->get();
            return $query->result_array();
    }
    // fetch all period type
    public function getAllperiodtype(){
       $query = $this->db->select('*')
                            ->from('poly_period_type_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->get();
            return $query->result_array();
    }
   // fecth year
    public function getAllyear(){
       $query = $this->db->select('*')
                            ->from('poly_year_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->get();
            return $query->result_array();
    }
    // fetch all semester
    public function getAllsemester(){
       $query = $this->db->select('*')
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
    $emp_id = $this->session->userdata('stake_details_id_fk');
    $query = $this->db->select('college_id_fk')
                           ->where('emp_basic_id_pk',$emp_id)
                           ->get('poly_college_emp_basic');
    $data=  $query->result_array();
    $collegeid = $data[0]['college_id_fk'];

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
                    array('b.college_id_fk' =>$collegeid)
                    )
            ->order_by('course_id_pk','ASC')  
            ->get();
    return $query->result_array();    
  }
  
  public function getEmployeewisecoursename(){
	  $emp_id = $this->session->userdata('stake_details_id_fk');
	  $sql = $this->db->select('a.discipline_id_fk,c.course_name,c.course_id_pk')
					  ->from('routine_management_system_details as a')
					  ->JOIN('routine_management_maping_details as b','a.routine_manage_id_pk = b.routine_details_fk','LEFT')
					  ->JOIN('poly_course_master as c','a.discipline_id_fk = c.course_id_pk','LEFT')
					  ->where('b.employee_id',$emp_id)
					  ->group_by('a.discipline_id_fk,c.course_name,c.course_id_pk')
					  ->get();
	  return $sql->result_array();

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

    // get count for pagination
  public function getCountroutinelist(){
     $emp_id = $this->session->userdata('stake_details_id_fk');
        $query = $this->db->select('count(employee_id)')
                         ->where('employee_id',$emp_id)
                         ->where('active_status','1')
                         ->get('routine_management_maping_details');
        return $query->result_array(); 
  }

  public function get_all_routine_list_using_id_all_data($emp_id=NULL,$limit = NULL, $offset = NULL){
  
      $query = $this->db->select('routine.routine_manage_id_pk')
                        ->select('routine.college_id_fk')
                        ->select('routine.routine_unique_id') 
                        ->select('days.description as days_desc')
                        ->select('year.description as year_desc')
                        ->select('course.course_name')
                        ->select('semester.description as sem_desc')
                        ->select('period_type.description as period_type_desc')
                        ->select('routine.status_code')
						->select('process.process_description')
                        ->select('routine.period_start_time')
                        ->select('routine.period_end_time')
                        ->select('routine.period_no')
                        ->select('routine.period_type_fk')
                        ->select('routine_map.employee_id')
						->select('routine.section_id_fk')

                        ->from('routine_management_system_details as routine')

                        ->join('routine_management_maping_details as routine_map','routine_map.routine_details_fk = routine.routine_manage_id_pk','LEFT')

                        ->join('poly_days_master as days','days.id = routine.days_id_fk','LEFT')

                        ->join('poly_year_master as year','year.id = routine.year_id_fk','LEFT')

                        ->join('poly_semester_master as semester','semester.id = routine.semester_id_fk','LEFT')

                        ->join('poly_period_type_master as period_type','period_type.id = routine.period_type_fk','LEFT')

                        ->join('poly_course_master as course','course.course_id_pk = routine.discipline_id_fk','LEFT')
					   
					    ->join('routine_process_master as process','process.process_id_pk = routine.status_code','LEFT')

                       ->where('routine_map.employee_id',$emp_id)
                       ->where('routine.active_status','1')
                       ->where('routine.period_type_fk!=', '3')
                       ->limit($limit, $offset)
                       ->get();
          return $query->result_array();      
    }
   public function get_all_routine_list_using_id($emp_id = NULL,$days_name =NULL,$discipline_type=NULL,$stud_year=NULL,$semester=NULL,$section_id=NULL){
  
      $query = $this->db->select('routine.routine_manage_id_pk')
                        ->select('routine.college_id_fk')
                        ->select('routine.routine_unique_id') 
                        ->select('days.description as days_desc')
                        ->select('year.description as year_desc')
                        ->select('course.course_name')
						->select('process.process_description')
                        ->select('semester.description as sem_desc')
                        ->select('period_type.description as period_type_desc')
                        ->select('routine.status_code')
						->select('routine.section_id_fk')
						

                        ->from('routine_management_system_details as routine')

                        ->join('routine_management_maping_details as routine_map','routine_map.routine_details_fk = routine.routine_manage_id_pk','LEFT')

                        ->join('poly_days_master as days','days.id = routine.days_id_fk','LEFT')

                       ->join('poly_year_master as year','year.id = routine.year_id_fk','LEFT')

                       ->join('poly_semester_master as semester','semester.id = routine.semester_id_fk','LEFT')

                       ->join('poly_period_type_master as period_type','period_type.id = routine.period_type_fk','LEFT')

                       ->join('poly_course_master as course','course.course_id_pk = routine.discipline_id_fk','LEFT')
					   
					    ->join('routine_process_master as process','process.process_id_pk = routine.status_code','LEFT')
					   


                       ->where('routine_map.employee_id',$emp_id)
                       ->where('routine.active_status','1')
                       ->where('routine.period_type_fk!=', '3');
                       
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
						if($section_id){
                          $query = $query->where('routine.section_id_fk',$section_id);
                        }
                        $query = $query->get();
                       return $query->result_array();      
    }

    public function getCollegeid($emp_id){
      $query = $this->db->select('college_id_fk as collegeid')
                        ->where('emp_basic_id_pk',$emp_id)
                        ->get('poly_college_emp_basic');
      return $query->row('collegeid');
    }
	
	public function getCollegenewid($emp_id){
		$sql =  $this->db->select('a.college_id_fk')
						->from('routine_management_system_details as a')
						->JOIN('routine_management_maping_details as b','a.routine_manage_id_pk = b.routine_details_fk','LEFT')
						->where('b.employee_id',$emp_id)
						->group_by('a.college_id_fk')
						->get();
						//->result_array();

		return $sql->result_array();
	}

     public function getRoutineid($emp_id){
      $query = $this->db->select('routine_details_fk as routineid')
                        ->where('employee_id',$emp_id)
                        ->get('routine_management_maping_details');
      return $query->result_array();
    }

    public function updateClassexecution($result){
		return $this->db->insert('routine_class_execution_maping',$result);
    }
    // fetch all days
    public function getAllreason(){
       $query = $this->db->select('*')
                            ->from('routine_class_execution_reason_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->get();
            return $query->result_array();
    }

    //count class_execution_list for pagination
    public function count_employee_execution_list(){
        $emp_id = $this->session->userdata('stake_details_id_fk');
        $query = $this->db->select('count(*)')
                         ->where('employee_id_fk',$emp_id)
                         ->where('active_status','1')
                         ->get('routine_class_execution_maping');
        return $query->result_array(); 

    }
   // fetch class execution
    public function getClassexecutiondata($emp_id,$limit = NULL,$offset = NULL){
       $query = $this->db->select('a.excecution_id_pk')
                        ->select('a.class_execution_date')
                        ->select('a.topic_coverd')
                        ->select('a.routine_details_id_fk')
                        ->select('a.topic_coverd_desc')
                        ->select('a.status_code_fk')
                        ->select('b.process_description')
                        ->select('a.reject_remarks')
                        ->select('a.remarks')
                        ->select('c.reason_master_description')
            ->from('routine_class_execution_maping as a')
            ->join('routine_process_master as b','a.status_code_fk= b.process_id_pk','LEFT')
            ->join('routine_class_execution_reason_master as c','a.topic_coverd_desc_no= c.reason_master_id_pk','LEFT')
            ->where(
                 array('employee_id_fk' =>$emp_id)
                   )
            ->where('a.active_status','1')
            ->limit($limit, $offset)
            ->get();
      return $query->result_array();
    }

    public function get_all_routine_list_using_id_all($routine_manage_id_pk = NULL){
      $query = $this->db->select('routine.routine_manage_id_pk')
                        ->select('routine.college_id_fk')
                        ->select('routine.routine_unique_id') 
                        ->select('routine.operator_id_fk')  
                        ->select('days.description as days_desc')
                        ->select('academic_year.academic_year_description')
                        ->select('academic_year.academic_year_id_pk')
                        ->select('period_no.description as period_no_desc')
                        ->select('routine.period_start_time')
                        ->select('routine.period_end_time')
                        ->select('routine.period_type_fk')
                        ->select('period_type.description as period_type_desc')
                        ->select('routine.room_no')
                        ->select('course.course_name')
                        ->select('year.description as year_desc')
                        ->select('semester.description as sem_desc')
                        ->select('routine.subject_id_fk')
                        ->select('subject.subject_description as subject_desc')
                        ->select('routine.status_code')
                        ->select('process_master.process_description')
                        ->select('routine.revert_reason')
                        ->select('emp_details.first_name')
                        ->select('emp_details.midle_name')
                        ->select('emp_details.last_name')
                        ->select('routine.entry_time')
                        
                        ->from('routine_management_system_details as routine')

                        ->join('routine_management_maping_details as routine_map','routine_map.routine_details_fk = routine.routine_manage_id_pk','LEFT')

                        ->join('routine_academic_session_year_master as academic_year','academic_year.academic_year_id_pk = routine.academic_year_fk','LEFT')

                        ->join('poly_college_emp_basic as emp_details','emp_details.emp_basic_id_pk = routine_map.employee_id','LEFT')

                       ->join('poly_days_master as days','days.id = routine.days_id_fk','LEFT')

                       ->join('poly_year_master as year','year.id = routine.year_id_fk','LEFT')

                       ->join('poly_semester_master as semester','semester.id = routine.semester_id_fk','LEFT')

                       ->join('poly_period_type_master as period_type','period_type.id = routine.period_type_fk','LEFT')

                       ->join('discipline_wise_code_master as subject','subject.subject_code = routine.subject_id_fk','LEFT')

                       ->join('poly_period_no_master as period_no','period_no.id = routine.period_no','LEFT')

                       ->join('poly_course_master as course','course.course_id_pk = routine.discipline_id_fk','LEFT')

                       ->join('routine_process_master as process_master','process_master.process_id_pk = routine.status_code','LEFT')
                       ->where(
                              array(
                                      'MD5(CAST(routine.routine_manage_id_pk AS character varying))=' =>$routine_manage_id_pk
                                  )
                            )
                       ->get();
        return $query->result_array();      
    }

    public function getexecutionDetails($excecution_id_pk){
          $query = $this->db->select('a.semester_id_fk,a.discipline_id_fk,a.period_start_time,a.period_end_time,b.class_execution_date,b.topic_coverd,b.topic_coverd_desc,b.topic_coverd_desc_no,b.excecution_id_pk,b.routine_details_id_fk,b.employee_id_fk,b.college_id_fk,b.remarks')
                            ->from('routine_management_system_details as a')
                            ->JOIN('routine_class_execution_maping as b','a.routine_manage_id_pk = b.routine_details_id_fk','LEFT')
                            ->where(
                              array(
                                      'MD5(CAST(excecution_id_pk AS character varying))=' =>$excecution_id_pk
                                  )
                            )
                            ->get();
          return $query->result_array();
    }
    
    public function updateExecutiondetails($data,$class_execution_id){
            $res = $this->db->set('active_status','0')
                            ->where('excecution_id_pk',$class_execution_id)
                            ->update('routine_class_execution_maping');
            if($res){
              return $this->db->insert('routine_class_execution_maping',$data);
            }
      }

      public function getPracsubusingid($routine_manage_id_pk){
          $sql = $this->db->select('subject_id')
                          ->where('active_status','1')
                          ->where(
                              array(
                                      'MD5(CAST(routine_details_fk AS character varying))=' =>$routine_manage_id_pk
                                  )
                            )
                          ->get('poly_subject_mapping_master');
          return $sql->result_array();
      }

      public function getExecutiondetailslistview($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id,$emp_id){
       
        $query = $this->db->select('a.period_start_time,a.period_end_time,a.period_type_fk,a.room_no,a.subject_id_fk,a.days_id_fk,a.period_no,a.routine_manage_id_pk,a.academic_year_fk,a.year_id_fk,a.semester_id_fk,a.discipline_id_fk')
                          ->where('a.academic_year_fk',$academic_year)
                          ->where('a.year_id_fk',$stud_year)
                          ->where('a.semester_id_fk',$semester)
						  ->where('a.discipline_id_fk',$discipline_id)
                          ->where('a.active_status','1')
						  ->where('b.active_status','1')
						  //->where('a.college_id_fk',$college_id)
						  ->where('b.employee_id',$emp_id)
                          ->order_by('a.days_id_fk')
                          ->order_by('a.period_no')
                          ->from('routine_management_system_details as a')
						  ->JOIN('routine_management_maping_details as b','a.routine_manage_id_pk = b.routine_details_fk','LEFT')
                          ->get();
						  
                 
        return $query->result_array();
        }

  public function getCoverddetails($topic_id){
      $sql = $this->db->select('topic_coverd_desc')
                      ->where('excecution_id_pk',$topic_id)
                      ->get('routine_class_execution_maping');
      return $sql->row('topic_coverd_desc');
    }

     public function checkingExecution($date,$rouitne_id_exe,$periodnoexe,$emp_id){
		  $emp_id = $this->session->userdata('stake_details_id_fk');
          $sql = $this->db->select('routine_details_id_fk')
                          ->where('class_execution_date',$date)
                          ->where('routine_details_id_fk',$rouitne_id_exe)
                          ->where('period_no_fk',$periodnoexe)
						  ->where('employee_id_fk',$emp_id)
						  ->where('active_status','1')
						  ->where('employee_id_fk',$emp_id)
						  
                          ->get('routine_class_execution_maping');
          return $sql->num_rows();

      }
    //fetch routine time.....date 30-12-2020........By Rakesh Kundu
  public function getPeriodtime($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id){
    $sql = $this->db->select('period_start_time,period_end_time')
                     ->where('academic_year_fk',$academic_year)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
					   ->where('discipline_id_fk',$discipline_id)
					  ->where_in('college_id_fk',$polytechnic_name)
                      ->group_by('period_start_time')
					  ->group_by('period_end_time')
                      ->order_by('period_start_time')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }

  public function getMondayroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk,period_no,discipline_id_fk,status_code')
                     ->where('academic_year_fk',$academic_year)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
					   ->where('discipline_id_fk',$discipline_id)
                      ->where('active_status','1')
                      ->where('days_id_fk','1')
					  ->where_in('college_id_fk',$polytechnic_name)
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
					 /* echo $this->db->last_query();
					  die;*/
    return $sql->result_array();
  }
   public function getTuesdayroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk,period_no,status_code')
                     ->where('academic_year_fk',$academic_year)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
					   ->where('discipline_id_fk',$discipline_id)
                      ->where('active_status','1')
                      ->where('days_id_fk','2')
					   ->where_in('college_id_fk',$polytechnic_name)
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  public function getWednesdayroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk,period_no,status_code')
                     ->where('academic_year_fk',$academic_year)
                      ->where('year_id_fk',$stud_year)
					   ->where('discipline_id_fk',$discipline_id)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','3')
					   ->where_in('college_id_fk',$polytechnic_name)
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
					 
    return $sql->result_array();
  }
  public function getThrusdatroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk,period_no,status_code')
                     ->where('academic_year_fk',$academic_year)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
					   ->where('discipline_id_fk',$discipline_id)
                      ->where('active_status','1')
                      ->where('days_id_fk','4')
					  ->where_in('college_id_fk',$polytechnic_name)
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  public function getFridayroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk,period_no,status_code')
                     ->where('academic_year_fk',$academic_year)
                      ->where('year_id_fk',$stud_year)
                      ->where('semester_id_fk',$semester)
					   ->where('discipline_id_fk',$discipline_id)
                      ->where('active_status','1')
                      ->where('days_id_fk','5')
					  ->where_in('college_id_fk',$polytechnic_name)
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
  public function getSataurdayroutinelist($academic_year,$stud_year,$semester,$polytechnic_name,$discipline_id){
    $sql = $this->db->select('routine_manage_id_pk,room_no,subject_id_fk,days_id_fk,period_type_fk,period_no,status_code,routine_unique_id')
                     ->where('academic_year_fk',$academic_year)
                      ->where('year_id_fk',$stud_year)
					   ->where('discipline_id_fk',$discipline_id)
                      ->where('semester_id_fk',$semester)
                      ->where('active_status','1')
                      ->where('days_id_fk','6')
					  ->where_in('college_id_fk',$polytechnic_name)
                      ->order_by('days_id_fk')
                      ->order_by('period_no')
                      ->get('routine_management_system_details');
    return $sql->result_array();
  }
   
   public function fetchCollegenames($college_id){
	   $sql = $this->db->select('college_id_pk,college_name')
						->where_in('college_id_pk',$college_id)
						->get('poly_college');
		return $sql->result_array();
   }
   
   //fetch routine time.....date 30-12-2020........By Rakesh Kundu
  public function getPeriodtimetimesnew__backup($college_name, $academic_year, $discipline_id, $stud_year, $semester)
  {
    $sql = $this->db->select('period_start_time,period_end_time')
      ->where('academic_year_fk', $academic_year)
      ->where('year_id_fk', $stud_year)
      ->where('semester_id_fk', $semester)
      ->where('active_status', '1')
      ->where('discipline_id_fk', $discipline_id)
      ->where('college_id_fk', $college_name)
      ->group_by('period_start_time')
      ->group_by('period_end_time')
      ->order_by('period_start_time')
      ->get('routine_management_system_details');
    return $sql->result_array();
  }



  public function getPeriodtimetimesnew($college_id)
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


  public function getAllroutinesdetails_new($college_id, $academic_year, $discipline_id, $stud_year, $semester, $days_id,$section_id)
  {
    $sql = $this->db->select('a.routine_manage_id_pk,a.subject_id_fk,a.room_no,a.period_type_fk,a.days_id_fk,a.period_no,period_type.description as periodtype,a.routine_online_status,a.routine_unique_id,a.section_id_fk')
      ->from('routine_management_system_details as a')
      //->JOIN('discipline_wise_code_master  as b', 'a.subject_id_fk = b.subject_code', 'LEFT')
      ->JOIN('poly_period_type_master  as period_type', 'a.period_type_fk = period_type.id', 'LEFT')
      ->where('a.college_id_fk', $college_id)
      ->where('a.discipline_id_fk ', $discipline_id)
      ->where('a.academic_year_fk', $academic_year)
      ->where('a.semester_id_fk', $semester)
      ->where('a.year_id_fk', $stud_year)
      ->where('a.days_id_fk', $days_id)
	  ->where('a.section_id_fk', $section_id)
      ->where('a.active_status', '1')
      ->where('a.status_code', 4)
      ->order_by('a.days_id_fk')
      ->order_by('a.period_no')
      ->group_by('a.routine_manage_id_pk,a.subject_id_fk,a.room_no,a.period_type_fk,periodtype,a.routine_unique_id,a.section_id_fk')
      ->get()->result_array();



    foreach ($sql as $key => $value) {


      $sql[$key]['teacher'] = $this->db->select('employee_id,emp.first_name,emp.midle_name,emp.last_name')
        ->from('routine_management_maping_details as a')
        ->join('poly_college_emp_basic as emp', 'a.employee_id = emp.emp_basic_id_pk', 'LEFT')
        ->where('a.routine_details_fk', $value['routine_manage_id_pk'])
        ->where('a.active_status', '1')
        ->group_by('employee_id,emp.first_name,emp.midle_name,emp.last_name')
        ->get()->result_array();

      $sql[$key]['subject'] = $this->db->select('b.subject_id')
        ->from('poly_subject_mapping_master as b')
        ->JOIN('discipline_wise_code_master as dwcm', 'dwcm.subject_code = b.subject_id', 'LEFT')
        ->where('b.routine_details_fk', $value['routine_manage_id_pk'])
        ->where('dwcm.branch_code_fk', $discipline_id)
        ->where('dwcm.semester_code_fk', $semester)
        ->where('b.active_status', '1')
        ->group_by('b.subject_id')
        ->get()->result_array();
      # code...
    }
    return $sql;
  }

  public function countStatus_routine($college_id, $academic_year, $discipline_id, $stud_year, $semester)
  {
    $sql = $this->db->select('status_code')
      ->where('academic_year_fk', $academic_year)
      ->where('discipline_id_fk', $discipline_id)
      ->where('college_id_fk', $college_id)
      ->where('year_id_fk', $stud_year)
      ->where('semester_id_fk', $semester)
      ->where('active_status', '1')
      ->where('status_code', '4')
      ->get('routine_management_system_details');
    return $sql->num_rows();
  }

  public function getPeriodtimetimes($college_id, $academic_year, $discipline_id, $stud_year, $semester)
  {
    $sql = $this->db->select('period_start_time,period_end_time')
      ->where('academic_year_fk', $academic_year)
      ->where('year_id_fk', $stud_year)
      ->where('semester_id_fk', $semester)
      ->where('active_status', '1')
      ->where('discipline_id_fk', $discipline_id)
      ->where('college_id_fk', $college_id)
      ->group_by('period_start_time')
      ->group_by('period_end_time')
      ->order_by('period_start_time')
      ->get('routine_management_system_details');
    return $sql->result_array();
  }

  public function fetchRoutineperiodno($routine_id)
  {
    return $this->db->select('period_no,routine_manage_id_pk,college_id_fk,days_id_fk,period_type_fk,discipline_id_fk')
      ->where(
        array(
          'MD5(CAST(routine_manage_id_pk AS character varying))=' => $routine_id
        )
      )
      ->get('routine_management_system_details')->result_array();
  }

  public function insertClassexecutiondata($update_array){
    return $this->db->insert('routine_class_execution_maping',$update_array);
  }
  public function checkingClassexecution($period_no,$execution_date,$routine_id_fk)
  {
    $sql = $this->db->select('routine_details_id_fk')
                    ->where('period_no_fk',$period_no)  
                    ->where('class_execution_date',$execution_date)
                    ->where('active_status',1)
					->where('routine_details_id_fk',$routine_id_fk)
                    ->get('routine_class_execution_maping');
    return $sql->num_rows();
  }
  
  //munmun 23_02_2022
   public function checkingClassexecutionPractical($period_no,$execution_date,$routine_id_fk,$empid)
  {
    $sql = $this->db->select('routine_details_id_fk')
                    ->where('period_no_fk',$period_no)  
                    ->where('class_execution_date',$execution_date)
                    ->where('active_status',1)
					->where('routine_details_id_fk',$routine_id_fk)
					->where('employee_id_fk',$empid)
                    ->get('routine_class_execution_maping');
    return $sql->num_rows();
  }
   
 }