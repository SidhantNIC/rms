<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routine_add_time extends NIC_Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::check_privilege(159);
        $this->load->library('user_agent');
        $this->load->library('form_validation');
        $this->load->helper('url');
		$this->load->helper('routine_management_helper');
        $this->load->model('routine_management_m/routine/Routine_time_add_model');
    }
    
    public function index()
    {
        $college_id        = $this->session->userdata('stake_details_id_fk');
        $operator_id       = $this->session->userdata('stake_holder_login_id_pk');
        
        if ($this->input->post()) {
            $period_no         = $this->input->post('period_no');
            $period_start_time = $this->input->post('period_start_time');
            $period_end_time   = $this->input->post('period_end_time');


            $userstarttime = (explode(':', $period_start_time));
            $userendttime  = (explode(':', $period_end_time));
            
            $user_start_time_value_1 = $userendttime['0'];
            $user_start_time_value_2 = $userendttime['1'];
            $user_start_total_time   = ($user_start_time_value_1 * 3600) + ($user_start_time_value_2 * 60);
            
            $user_end_time_value_1 = $userendttime['0'];
            $user_end_time_value_2 = $userendttime['1'];
            $user_end_total_time   = ($user_end_time_value_1 * 3600) + ($user_end_time_value_2 * 60);
            
            $this->form_validation->set_rules('period_no', 'Period No', 'required');
            $this->form_validation->set_rules('period_start_time', 'Period Start Time', 'required');
            $this->form_validation->set_rules('period_end_time', 'Period End Time', 'required');
            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $data = array(
                    'period_no_fk' => $period_no,
                    'period_start_time' => $period_start_time,
                    'period_end_time' => $period_end_time,
                    'college_id_fk' => $college_id,
                    'operator_id_fk' => $operator_id,
                    'active_status' => '1'
                    
                );
                
                $check1srperiodinsertornot = $this->Routine_time_add_model->checkPeriodtimeblankornot($college_id, $operator_id);


                if ($check1srperiodinsertornot == '0' && $period_no == '1') {

                            $insertfirstperiod = $this->Routine_time_add_model->periodFirstinsert($data);
                            if ($insertfirstperiod) {
                                $this->session->set_flashdata('success', 'Routine period time is successfully inserted');
                            }
                } else {
                    
                    $checkingperiodavilable = $this->Routine_time_add_model->checkPeriodavailable($college_id,$operator_id,$period_no);
                    if($checkingperiodavilable =='0'){
                        if($period_no =='1'){

                            $secondperiodstartime =  $this->Routine_time_add_model->fetchSecondperiodstarttime($college_id,$operator_id);
                           
                            
                            $databasesecondtime = (explode(':', $secondperiodstartime[0]['period_start_time']));
                            
                            $database_start_time_sec_value_1 = $databasesecondtime['0'];
                            $database_start_time_sec_value_2 = $databasesecondtime['1'];
                            $database_start_total_sec_time   = ($database_start_time_sec_value_1 * 3600) + ($database_start_time_sec_value_2 * 60);
                            if($user_end_total_time<=$database_start_total_sec_time){
                                $insertfirstperiod = $this->Routine_time_add_model->periodFirstinsert($data);
                                $this->session->set_flashdata('success', 'Routine period time is successfully inserted');
                            }else{
                               $this->session->set_flashdata('error', 'Selected time is always less than your previous time');
                            }



                        }else{
                            $checkstarttime = $period_no + 1;
                            $checkendtime   = $period_no - 1;
                            
                            $starttime = $this->Routine_time_add_model->fetchStarttime($checkstarttime, $college_id, $operator_id);
                            $endtime   = $this->Routine_time_add_model->fetchEndtime($checkendtime, $college_id, $operator_id);
                            
                            if (sizeof($starttime) == '0') {
                                $insertfirstperiod = $this->Routine_time_add_model->periodFirstinsert($data);
                                $this->session->set_flashdata('success', 'Routine period time is successfully inserted');
                            } else if (sizeof($starttime) > 0 && sizeof($endtime) > 0) {
                                

                                $starttimetotal = (explode(':', $starttime[0]['period_start_time']));
                                $endttimetotal  = (explode(':', $endtime[0]['period_end_time']));
                                
                                $database_start_time_value_1 = $starttimetotal['0'];
                                $database_start_time_value_2 = $starttimetotal['1'];
                                $database_start_total_time   = ($database_start_time_value_1 * 3600) + ($database_start_time_value_2 * 60);
                                
                                $database_end_time_value_1 = $endttimetotal['0'];
                                $database_end_time_value_2 = $endttimetotal['1'];
                                $database_end_total_time   = ($database_end_time_value_1 * 3600) + ($database_end_time_value_2 * 60);
                                                                
                                if ($user_start_total_time >= $database_end_total_time && $database_start_total_time >= $user_end_total_time) {
                                    $insertfirstperiod = $this->Routine_time_add_model->periodFirstinsert($data);
                                    $this->session->set_flashdata('success', 'Routine period time is successfully inserted');
                                } else {
                                    $this->session->set_flashdata('error', 'Please check the before enter the new time');
                                }
                                
                                
                                
                                
                            } else {
                                $this->session->set_flashdata('error', 'You have to insert first period time,before inserting any period time');
                            }
                        }

                            
                    }else{
                        $this->session->set_flashdata('error', 'Selected Period is already available,please select another period time');
                    }  

                    
                    
                }
                
            }
            
            
            
        }
        $data['period_no'] = $this->Routine_time_add_model->getAllperiodno();
        $this->load->view($this->config->item('theme') . 'routine_management_v/routine/routine_add_time_view', $data);
    }
    
    public function viewRoutimetime()
    {
        $college_id           = $this->session->userdata('stake_details_id_fk');
        $operator_id          = $this->session->userdata('stake_holder_login_id_pk');
        $data['all_emp_list'] = $this->Routine_time_add_model->getAllperiodlist($college_id);
		
        $this->load->view($this->config->item('theme') . 'routine_management_v/routine/routine_add_time_list_view', $data);
    }
    
    
}