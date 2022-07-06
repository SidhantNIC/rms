<?php
defined('BASEPATH') OR exit('No direct script access allowed' );

class Director_routine_list extends NIC_Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::check_privilege(178);
        $this->load->library('user_agent');
        $this->load->helper('url');
        $this->load->helper('routine_management_helper');
        $this->load->model('operator/College_emp_basic_model');
        $this->load->model('routine_management_m/director_routine/Director_routine_model');
        $this->load->library('form_validation');
    }


    public function index($offset = NULL){
        $this->load->library('pagination');
        $config['base_url']         = 'routine_management_c/director_routine/Director_routine_list/index';
        $config['total_rows']       = $this->Director_routine_model->getCollgewiserout()[0]['count'];
        $config['per_page']         = 50;
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
        $data['routine_list_view'] = $this->Director_routine_model->getCollgewiseroutinelist($config['per_page'],$offset);
		
        $data['page_links'] = $this->pagination->create_links();
        $this->load->view($this->config->item('theme').'routine_management_v/director_routine/director_routine_list_view.php',$data);
    }

    public function viewRoutinelistcollegewise($college_id_fk = NULL){
        /*$this->load->library('pagination');
        $config['base_url']         = 'routine_management_c/director_routine/Director_routine_list/viewRoutinelistcollegewise/';
        $config['total_rows']       = $this->Director_routine_model->getCountroutinelistdrilldown($college_id_fk)[0]['count'];
        $config['per_page']         = 100;
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
        $data['offset']         = $offset;*/
       
        //$data['all_emp_list'] = $this->Director_routine_model->get_all_routine_list($college_id_fk,$config['per_page'],$offset);
		$data['all_emp_list'] = $this->Director_routine_model->get_all_routine_list($college_id_fk);
       // $data['page_links'] = $this->pagination->create_links();
        $data['college_id'] = $college_id_fk;
        $this->load->view($this->config->item('theme').'routine_management_v/director_routine/director_routine_list_drilldown_view.php',$data);
    }

    public function viewRoutinealldetails($routine_manage_id_pk){
        $routine_id = $routine_manage_id_pk;
        $data['routine']= $this->Director_routine_model->get_all_routine_list_using_id($routine_id);
        $data['practical_sub']= $this->Director_routine_model->get_all_practical_sub($routine_id); 
        //$data['employee']= $this->Director_routine_model->get_all_employee_lists($routine_id);
        $this->load->view($this->config->item('theme').'routine_management_v/director_routine/routine_all_view.php',$data);
        
    }
   
}