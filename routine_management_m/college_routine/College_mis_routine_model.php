<?php
defined('BASEPATH') or exit('No direct script access allowed');
class College_mis_routine_model extends CI_Model
{

    public function getDisciplinenames()
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
            ->where_in('college_id_fk', $college_id)
            ->order_by('course_id_pk', 'ASC')
            ->group_by('a.course_id_pk')
            ->get();

        return $query->result_array();
    }

    public function getAcademicname()
    {
        $sql = $this->db->select('academic_year_id_pk,academic_year_description')
            ->where('active_status', '1')
            ->order_by('academic_year_id_pk')
            ->get('routine_academic_session_year_master');
        return $sql->result_array();
    }

    public function fetchallSemesterwiseroutiedetails()
    {
        $college_id_fk = $this->session->userdata('stake_details_id_fk');
        $sql = $this->db->select('a.discipline_id_fk,b.course_name,a.status_code,a.college_id_fk,a.academic_year_fk,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 1 )) as semester1,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 2 )) as semester2,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 3 )) as semester3,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 4 )) as semester4,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 5 )) as semester5,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 6 )) as semester6')
            ->from('routine_management_system_details as a')
            ->JOIN('poly_course_master as b', 'a.discipline_id_fk= b.course_id_pk', 'LEFT')
            ->where('college_id_fk', $college_id_fk)
            ->where('academic_year_fk', '3')
            ->group_by('a.discipline_id_fk,b.course_name,a.status_code,a.college_id_fk,a.academic_year_fk')
            ->get();
        return $sql->result_array();
    }

    public function fetchallSemesterwiseroutiedetailsserasch($discipline_name = NULL, $academic_session = NULL)
    {
        $college_id_fk = $this->session->userdata('stake_details_id_fk');
        $sql = $this->db->select('a.discipline_id_fk,b.course_name,a.status_code,a.college_id_fk,a.academic_year_fk,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 1 )) as semester1,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 2 )) as semester2,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 3 )) as semester3,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 4 )) as semester4,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 5 )) as semester5,
      count(a.routine_manage_id_pk) FILTER (WHERE (a.semester_id_fk = 6 )) as semester6')
            ->from('routine_management_system_details as a')
            ->JOIN('poly_course_master as b', 'a.discipline_id_fk= b.course_id_pk', 'LEFT')
            ->where('college_id_fk', $college_id_fk)
            //->where('academic_year_fk', '3')
            ->group_by('a.discipline_id_fk,b.course_name,a.status_code,a.college_id_fk,a.academic_year_fk');

        if ($discipline_name) {
            $sql = $sql->where('a.discipline_id_fk', $discipline_name);
        }
        if ($academic_session) {
            $sql = $sql->where('a.academic_year_fk', $academic_session);
        }
        $sql = $sql->get();
        return $sql->result_array();
    }
}
