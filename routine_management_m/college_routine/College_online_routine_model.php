<?php
defined('BASEPATH') or exit('No direct script access allowed');

class College_online_routine_model extends CI_Model
{
  //fetch all academic year
  public function get_allacademicyear($college_id = NULL)
  {
    $query = $this->db->select('*')
      ->from('routine_academic_session_year_master')
      ->where(
        array('active_status' => '1')
      )
      ->get();
    return $query->result_array();
  }

  //fetch all employee
  public function get_allemp($college_id = NULL)
  {
    $query = $this->db->select('*')
      ->from('poly_college_emp_basic')
      ->where(
        array('college_id_fk' => $college_id)
      )
      ->where(
        array('process_id_fk' => '104')
      )
      ->order_by('first_name')
      ->get();
    return $query->result_array();
  }
  // fetch all days
  public function getAlldays()
  {
    $query = $this->db->select('*')
      ->from('poly_days_master')
      ->where(
        array('active_status' => '1')
      )
      ->get();
    return $query->result_array();
  }
  // fetch all period no
  public function getAllperiodno()
  {
    $query = $this->db->select('*')
      ->from('poly_period_no_master')
      ->where(
        array('active_status' => '1')
      )
      ->order_by('id')
      ->get();
    return $query->result_array();
  }
  // fetch all period type
  public function getAllperiodtype()
  {
    $query = $this->db->select('*')
      ->from('poly_period_type_master')
      ->where(
        array('active_status' => '1')
      )
      ->get();
    return $query->result_array();
  }
  // fecth year
  public function getAllyear()
  {
    $query = $this->db->select('*')
      ->from('poly_year_master')
      ->where(
        array('active_status' => '1')
      )
      ->get();
    return $query->result_array();
  }
  // fetch all semester
  public function getAllsemester()
  {
    $query = $this->db->select('*')
      ->from('poly_semester_master')
      ->where(
        array('active_status' => '1')
      )
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
      ->join('poly_college_course as b', 'b.course_id_fk = a.course_id_pk  ', 'LEFT')
      ->where(
        array('a.active_status' => '1')
      )
      ->where(
        array('b.college_id_fk' => $college_id)
      )
      ->order_by('course_id_pk', 'ASC')
      ->get();
    return $query->result_array();
  }
  // fetch all subjects
  public function getAllsubject()
  {
    $query = $this->db->select('*')
      ->from('subject_code_master')
      ->where(
        array('active_status' => '1')
      )
      ->get();
    return $query->result_array();
  }
  //Count for pagination
  public function get_count_routine_list()
  {

    $college_id = $this->session->userdata('stake_details_id_fk');
    $query = $this->db->select('count(routine_manage_id_pk)')
      ->where('college_id_fk', $college_id)
      ->where('active_status', '1')
      ->where('routine_online_status', 1)
      ->get('routine_management_system_details');
    return $query->result_array();
  }
  //employee Name
  public function get_all_employee_lists($routine_id)
  {

    $query = $this->db->select('a.first_name')
      ->select('a.midle_name')
      ->select('a.last_name')      
      ->from('poly_college_emp_basic as a')
      ->JOIN('routine_management_maping_details as b', 'b.employee_id = a.emp_basic_id_pk', 'LEFT')
	  ->where(
        array(
          'MD5(CAST(b.routine_details_fk AS character varying))=' => $routine_id
        )
      )
      ->get();
    return $query->result_array();
  }
  //Prac
  public function get_all_practical_sub($routine_id)
  {
    $query = $this->db->select('subject_id')
      ->where(
        array(
          'MD5(CAST(routine_details_fk AS character varying))=' => $routine_id
        )
      )
      ->get('poly_subject_mapping_master');
    return $query->result_array();
  }

  public function get_all_routine_list_all($college_id = NULL, $limit = NULL, $offset = NULL)
  {

    $query = $this->db->select('routine.routine_manage_id_pk,routine.routine_online_status,routine.online_routine_status_current')
      ->select('days.description as days_desc')
      ->select('course.course_name as course_name')
      ->select('year.description as year_desc')
      ->select('routine.routine_unique_id')
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

      ->join('poly_college_emp_basic as emp_details', 'emp_details.emp_basic_id_pk = routine_map.employee_id', 'LEFT')

      ->group_by('days_desc')
      ->group_by('period_no_desc')
      ->group_by('course_name')
      ->group_by('year_desc')
      ->group_by('course_name')
      ->group_by('sem_desc')
      ->group_by('process_description')
      ->group_by('routine.routine_manage_id_pk')
      ->where('routine_online_status', 1)
      ->limit($limit, $offset)
      ->where('routine.college_id_fk', $college_id)
      ->where('routine.active_status', '1');


    $query = $query->get();
    return $query->result_array();
  }
  public function get_all_routine_list($college_id = NULL, $days_name = NULL, $discipline_type = NULL, $stud_year = NULL, $semester = NULL, $period_no = NULL, $emp_id = NULL, $routine_mode = NULL)
  {
    // echo $emp_id;
    // exit;
    $query = $this->db->select('routine.routine_manage_id_pk,routine.routine_online_status,routine.online_routine_status_current')
      ->select('days.description as days_desc')
      ->select('course.course_name as course_name')
      ->select('year.description as year_desc')
      ->select('routine.routine_unique_id')
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

      ->join('poly_college_emp_basic as emp_details', 'emp_details.emp_basic_id_pk = routine_map.employee_id', 'LEFT')

      ->group_by('days_desc')
      ->group_by('period_no_desc')
      ->group_by('course_name')
      ->group_by('year_desc')
      ->group_by('course_name')
      ->group_by('sem_desc')
      ->group_by('process_description')
      ->group_by('routine.routine_manage_id_pk')
      // ->group_by('routine_map.employee_id')
      ->order_by('course.course_name')

      ->where('routine.college_id_fk', $college_id)
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
    if ($routine_mode) {
      $query = $query->where('routine.routine_online_status', $routine_mode);
    }

    $query = $query->get();

    return $query->result_array();
  }

  public function get_all_routine_list_using_id($routine_id)
  {
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

      ->join('routine_management_maping_details as routine_map', 'routine_map.routine_details_fk = routine.routine_manage_id_pk', 'LEFT')

      ->join('poly_college_emp_basic as emp_details', 'emp_details.emp_basic_id_pk = routine_map.employee_id', 'LEFT')

      ->join('poly_days_master as days', 'days.id = routine.days_id_fk', 'LEFT')

      ->join('routine_academic_session_year_master as academic_year', 'academic_year.academic_year_id_pk = routine.academic_year_fk', 'LEFT')

      ->join('poly_year_master as year', 'year.id = routine.year_id_fk', 'LEFT')

      ->join('poly_semester_master as semester', 'semester.id = routine.semester_id_fk', 'LEFT')

      ->join('poly_period_type_master as period_type', 'period_type.id = routine.period_type_fk', 'LEFT')

      ->join('discipline_wise_code_master as subject', 'subject.subject_code = routine.subject_id_fk', 'LEFT')

      ->join('poly_period_no_master as period_no', 'period_no.id = routine.period_no', 'LEFT')

      ->join('poly_course_master as course', 'course.course_id_pk = routine.discipline_id_fk', 'LEFT')

      ->join('routine_process_master as process_master', 'process_master.process_id_pk = routine.status_code', 'LEFT')
      ->where(
        array(
          'MD5(CAST(routine.routine_manage_id_pk AS character varying))=' => $routine_id
        )
      )
      ->where('routine.active_status', '1')
      ->get();
    return $query->result_array();
  }
  public function updateRoutineforonline($routine_id, $college_id)
  {
    return $this->db->set('routine_online_status', '1')
      ->set('routine_online_assign_time', date('Y-m-d H:i:s'))
      ->set('routine_online_assign_by', $college_id)
      ->set('routine_online_assign_ip', $this->input->ip_address())
      ->where_in('routine_manage_id_pk', $routine_id)
      ->where('college_id_fk', $college_id)
      ->where('status_code', '4')
      ->where('active_status', '1')
      ->update('routine_management_system_details');
  }



  public function approveRoutineonlinenotusingid($routine_manage_id_pk, $college_id)
  {

    return $this->db->set('online_routine_approve_time', date('Y-m-d H:i:s'))
      ->set('online_routine_approve_by', $college_id)
      ->set('online_routine_approve_ip', $this->input->ip_address())
      ->set('online_routine_status_current', '8')
      ->where(
        array(
          'MD5(CAST(routine_manage_id_pk AS character varying))=' => $routine_manage_id_pk
        )
      )
      ->update('routine_management_system_details');
  }
}
