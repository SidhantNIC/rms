<?php
defined('BASEPATH') OR exit('No direct script access allowed' );
class Director_routine_model extends CI_Model {

    public function getCollgewiseroutinelistnew($limit = NULL, $offset = NULL){
        $sql = $this->db->select('count(routine_manage_id_pk)')
                        ->select('college_id_fk')
                        ->where('active_status','1')
                        ->group_by('college_id_fk')
                        ->limit($limit, $offset)
                        ->get('routine_management_system_details');
        return $sql->result_array();
        
    }
	public function getCollgewiseroutinelist($limit = NULL, $offset = NULL){
        $sql = $this->db->select('count(a.routine_manage_id_pk),b.college_name,college_id_fk')
						->from('routine_management_system_details as a')
						->JOIN('poly_college as b','a.college_id_fk=b.college_id_pk','LEFT')
						->group_by('college_id_fk,b.college_name')
						->order_by('b.college_name')
						->where('a.active_status',1)
                        ->limit($limit, $offset)
						->get();
                        
        return $sql->result_array();
        
    }
	
    public function getCollgewiserout(){
        $sql = $this->db->select('count(*)')
                        ->select('college_id_fk')
                        ->where('active_status','1')
                        ->group_by('college_id_fk')
                        ->get('routine_management_system_details');
        return $sql->result_array();
        
    }

    //Count for pagination
    public function getCountroutinelistdrilldown($college_id_fk){
        $query = $this->db->select('count(*)')
                          ->where(
                            array(
                                    'MD5(CAST(college_id_fk AS character varying))=' =>$college_id_fk
                                )
                            )
                          ->where('active_status','1')
                          ->get('routine_management_system_details');
        return $query->result_array(); 
      }
      //fetch all routine list
      public function get_all_routine_list($college_id = NULL){
            $sql = $this->db->select('routine_manage_id_pk,routine_unique_id,days_id_fk,period_no,period_start_time,period_end_time,room_no,period_type_fk,status_code,college_id_fk')
                            ->where(
                                array(
                                        'MD5(CAST(college_id_fk AS character varying))=' =>$college_id
                                    )
                                )
                            //->limit($limit, $offset)
                            ->where('active_status','1')
                            ->get('routine_management_system_details');
        return $sql->result_array();
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
      
}