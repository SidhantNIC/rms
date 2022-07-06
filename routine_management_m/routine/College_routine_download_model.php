<?php
defined('BASEPATH') or exit('No direct script access allowed');

class College_routine_download_model extends CI_Model
{

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

  public function getPeriodtime($college_id_fk)
  {
    $sql = $this->db->select('period_start_time,period_end_time')
      ->where('college_id_fk', $college_id_fk)
      ->group_by('period_start_time')
      ->group_by('period_end_time')
      ->order_by('period_start_time')
      ->get('poly_period_time_master');

    return $sql->result_array();
  }

  public function getAllroutinesdetails($college_id_fk, $discipline_name, $academic_session, $semester, $status_code)
  {
    $sql = $this->db->select('a.routine_manage_id_pk,a.subject_id_fk,b.subject_description,a.room_no,a.period_type_fk,a.days_id_fk,a.period_no,period_type.description as periodtype,a.routine_online_status')
      ->from('routine_management_system_details as a')
      ->JOIN('discipline_wise_code_master  as b', 'a.subject_id_fk = b.subject_code', 'LEFT')
      ->JOIN('poly_period_type_master  as period_type', 'a.period_type_fk = period_type.id', 'LEFT')
      ->where('a.college_id_fk', $college_id_fk)
      ->where('a.discipline_id_fk ', $discipline_name)
      ->where('a.academic_year_fk', $academic_session)
      ->where('a.semester_id_fk', $semester)
      ->where('a.routine_online_status', $status_code)

      // ->where(
      //   array(
      //     'MD5(CAST(a.college_id_fk AS character varying))=' => $college_id_fk
      //   )
      // )
      // ->where(
      //   array(
      //     'MD5(CAST(a.discipline_id_fk AS character varying))=' => $discipline_name
      //   )
      // )
      // ->where(
      //   array(
      //     'MD5(CAST(a.academic_year_fk AS character varying))=' => $academic_session
      //   )
      // )
      // ->where(
      //   array(
      //     'MD5(CAST(a.routine_online_status AS character varying))=' => $status_code
      //   )
      // )
      ->where('a.active_status', '1')
      ->where('a.status_code', '4')

      ->order_by('a.days_id_fk')
      ->order_by('a.period_no')
      ->group_by('a.routine_manage_id_pk,a.subject_id_fk,b.subject_description,a.room_no,a.period_type_fk,periodtype')
      ->get()->result_array();



    foreach ($sql as $key => $value) {


      $sql[$key]['teacher'] = $this->db->select('employee_id,emp.first_name,emp.midle_name,emp.last_name')
        ->from('routine_management_maping_details as a')
        ->join('poly_college_emp_basic as emp', 'a.employee_id = emp.emp_basic_id_pk', 'LEFT')
        ->where('a.routine_details_fk', $value['routine_manage_id_pk'])
        ->where('a.active_status', '1')
        ->group_by('employee_id,emp.first_name,emp.midle_name,emp.last_name')
        ->get()->result_array();

      $sql[$key]['subject'] = $this->db->select('a.subject_description as practical_sub,b.subject_id')
        ->from('poly_subject_mapping_master as b')
        ->JOIN('discipline_wise_code_master as a', 'a.subject_code=b.subject_id', 'LEFT')
        ->where('routine_details_fk', $value['routine_manage_id_pk'])
        ->where('a.subject_type_fk', '2')
        ->where('b.active_status', '1')
        ->group_by('a.subject_description,b.subject_id')
        ->get()->result_array();
      # code...
    }
    return $sql;
  }
}
