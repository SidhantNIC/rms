<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sem_wise_routine_details extends NIC_Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::check_privilege(166);
        $this->load->library('user_agent');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->helper('routine_management_helper');
        $this->load->model('routine_management_m/college_routine/College_mis_routine_model');
        //$this->output->enable_profiler(TRUE);
    }

  public function index()
    {
        $data['discipline_name'] =  $this->College_mis_routine_model->getDisciplinenames();
        $data['academic_session'] =  $this->College_mis_routine_model->getAcademicname();
        if ($this->input->post()) {

            $discipline_name = $this->input->post('discipline_name');
            $academic_session = $this->input->post('academic_session');
            $data['semester_result'] = $this->College_mis_routine_model->fetchallSemesterwiseroutiedetailsserasch($discipline_name, $academic_session);
        }
        $this->load->view($this->config->item('theme') . 'routine_management_v/college_routine/college_sem_wise_routine_details', $data);
    }
}
