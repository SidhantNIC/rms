<?php
defined('BASEPATH') or exit('No direct script access allowed');

class College_download_routine extends NIC_Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::check_privilege(166);
        $this->load->library('user_agent');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->helper('routine_management_helper');
        $this->load->model('routine_management_m/college_routine/College_routine_download_model');
        //$this->output->enable_profiler(TRUE);

        
    }

    public function index()
    {


        $data = array();
        $period_time = array();
        $data['year'] = $this->College_routine_download_model->getAllyear();
        $data['semester'] = $this->College_routine_download_model->getAllsemester();
        $data['discipline'] = $this->College_routine_download_model->get_all_course();
        $data['result'] = array();

        if ($this->input->post()) {

            $academic_session = $this->input->post('academic_year');
            $discipline_name = $this->input->post('discipline_type');
            $stud_year = $this->input->post('stud_year');
            $semester = $this->input->post('semester');
            $status_code = $this->input->post('routine_mode');
            $college_id_fk = $this->session->userdata('stake_details_id_fk');
            $data['forwardlist'] = $this->input->post();

            $this->form_validation->set_rules('academic_year', 'Academic Session', 'required');
            $this->form_validation->set_rules('discipline_type', 'Discipline Type', 'required');
            $this->form_validation->set_rules('stud_year', 'Year', 'required');
            $this->form_validation->set_rules('semester', 'Semester', 'required');
            $this->form_validation->set_rules('routine_mode', 'Routine Mode', 'required');

            if ($this->form_validation->run() == FALSE) {
            } else {
                $data['period_time'] = $this->College_routine_download_model->getPeriodtime($college_id_fk);
                $data['routine_details'] = $routine_details = $this->College_routine_download_model->getAllroutinesdetails($college_id_fk, $discipline_name, $academic_session, $semester, $status_code);
                
            }
        }
        $this->load->view($this->config->item('theme') . 'routine_management_v/college_routine/college_routine_download_view', $data);
    }

    public function downloadRoutineaspdf()
    {
        $data = array();
        $academic_session = $this->input->post('academic_year');
        $discipline_name = $this->input->post('discipline_type');
        $stud_year = $this->input->post('stud_year');
        $semester = $this->input->post('semester');
        $status_code = $this->input->post('routine_mode');
        $college_id_fk = $this->session->userdata('stake_details_id_fk');
        $data['forwardlist'] = $this->input->post();

        $data['period_time'] = $this->College_routine_download_model->getPeriodtime($college_id_fk);
        $data['routine_details'] = $routine_details = $this->College_routine_download_model->getAllroutinesdetails($college_id_fk, $discipline_name, $academic_session, $semester, $status_code);

        $html = $this->load->view($this->config->item('theme') . 'routine_management_v/college_routine/college_routine_online_offline_pdf_download_view', $data, true);
        $pdfFilePath = "Routine.pdf";
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->AddPage('L');
        $this->m_pdf->pdf->WriteHTML($html, 2);
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
}
