<?php
defined('BASEPATH') or exit('No direct script access allowed');

class College_online_routine extends NIC_Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::check_privilege(166);
        $this->load->library('user_agent');
        $this->load->helper('url');
        $this->load->helper('routine_management_helper');
        $this->load->model('routine_management_m/college_routine/College_online_routine_model');
        //$this->output->enable_profiler(TRUE);

        $this->js_foot = array(
            1 => $this->config->item('theme_uri') . 'college_routine/js/college_routine_approve_revert.js',
        );
    }

    public function index($offset = NULL)
    {
        $stake_id = $this->session->userdata('stake_id_fk');
        $stake_login_id = $this->session->userdata('stake_holder_login_id_pk');
        $college_id = $this->session->userdata('stake_details_id_fk');

        $this->load->library('pagination');
        $this->load->library('form_validation');
        $config['base_url']         = 'routine_management_c/college_routine/College_online_routine/index';
        $config['total_rows']       = $this->College_online_routine_model->get_count_routine_list()[0]['count'];
        $config['per_page']         = 10;
        $config['num_links']        = 3;
        $config['full_tag_open']    = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close']   = '</ul>';
        $config['first_link']       = '<i class="fa fa-fast-backward"></i>';
        $config['first_tag_open']   = '<li class="">';
        $config['first_tag_close']  = '</li>';
        $config['last_link']        = '<i class="fa fa-fast-forward"></i>';
        $config['last_tag_open']    = '<li class="">';
        $config['last_tag_close']   = '</li>';
        $config['first_tag_open']   = '<li>';
        $config['first_tag_close']  = '</li>';
        $config['prev_link']        = '<i class="fa fa-backward"></i>';
        $config['prev_tag_open']    = '<li class="prev">';
        $config['prev_tag_close']   = '</li>';
        $config['next_link']        = '<i class="fa fa-forward"></i>';
        $config['next_tag_open']    = '<li>';
        $config['next_tag_close']   = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tag_close']   = '</li>';
        $config['cur_tag_open']     = '<li class="active"><a href="javascript:void(0)">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $this->pagination->initialize($config);
        $data['offset']         = $offset;

        $data['all_days'] = $this->College_online_routine_model->getAlldays();
        $data['period_no'] = $this->College_online_routine_model->getAllperiodno();
        $data['period_type'] = $this->College_online_routine_model->getAllperiodtype();
        $data['year'] = $this->College_online_routine_model->getAllyear();
        $data['semester'] = $this->College_online_routine_model->getAllsemester();
        $data['discipline'] = $this->College_online_routine_model->get_all_course();
        $data['subject'] = $this->College_online_routine_model->getAllsubject();
        $data['all_emp'] = $this->College_online_routine_model->get_allemp($college_id);

        $days_name = $this->input->post('days_name');
        $discipline_type = $this->input->post('discipline_type');
        $stud_year = $this->input->post('stud_year');
        $semester = $this->input->post('semester');
        $period_no = $this->input->post('period_no');
        $date = $this->input->post('date');
        $emp_id = $this->input->post('emp_id');
        $routine_mode = $this->input->post('routine_mode');

        if ($this->input->post()) {
            $data['all_emp_list'] = $this->College_online_routine_model->get_all_routine_list($college_id, $days_name, $discipline_type, $stud_year, $semester, $period_no, $emp_id, $routine_mode);
            $data['page_links'] = "";
            $this->load->view($this->config->item('theme') . 'routine_management_v/college_routine/college_online_routine_list_view', $data);
        } else {
            $data['all_emp_list'] = $this->College_online_routine_model->get_all_routine_list_all($college_id, $config['per_page'], $offset);
            $data['page_links'] = $this->pagination->create_links();
            $this->load->view($this->config->item('theme') . 'routine_management_v/college_routine/college_online_routine_list_view', $data);
        }
    }

    public function assignRoutineonline()
    {
        $college_id = $this->session->userdata('stake_details_id_fk');
        $routine_id = $this->input->post('routine_id');

        if ($routine_id == '') {
            $this->session->set_flashdata('error', 'No Routine Selected For Assign Online');
            redirect('admin/routine_management_c/college_routine/College_online_routine');
        } else {
            $data = $this->College_online_routine_model->updateRoutineforonline($routine_id, $college_id);
            if ($data) {
                $this->session->set_flashdata('success', 'All Routine has been assign for Online');
                redirect('admin/routine_management_c/college_routine/College_online_routine');
            } else {
                $this->session->set_flashdata('error', 'Something Went Wrong,Please Try Again');
                redirect('admin/routine_management_c/college_routine/College_online_routine');
            }
        }
    }

    public function assignRourineusingid($routine_manage_id_pk = NULL)
    {

        $college_id = $this->session->userdata('stake_details_id_fk');
        $data = $this->College_online_routine_model->updateRoutineonlineusingid($routine_manage_id_pk, $college_id);
        if ($data) {
            $this->session->set_flashdata('success', 'Routine Has Been Assigned For Online');
            redirect('admin/routine_management_c/college_routine/College_online_routine');
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong,Please Try Again');
            redirect('admin/routine_management_c/college_routine/College_online_routine');
        }
    }

    public function approveOnlineroutine($routine_manage_id_pk = null)
    {
        $college_id = $this->session->userdata('stake_details_id_fk');
        $data = $this->College_online_routine_model->approveRoutineonlinenotusingid($routine_manage_id_pk, $college_id);
        if ($data) {
            $this->session->set_flashdata('success', 'Online Routine Has Benn Approved');
            redirect('admin/routine_management_c/college_routine/College_online_routine');
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong,Please Try Again');
            redirect('admin/routine_management_c/college_routine/College_online_routine');
        }
    }
}
