 <?php
defined('BASEPATH') OR exit('No direct script access allowed' );

class Deleteroutine_time extends NIC_Controller
{
    public function __construct()
    {
		parent::__construct();
		parent::check_privilege(159);
		$this->load->library('user_agent');
		$this->load->helper('url');
        $this->load->helper('routine_management_helper');
		$this->load->model('routine_management_m/routine/Delete_routine_model');
		//$this->output->enable_profiler(TRUE);
		
        
	}

	public function index(){
		$college_id = $this->session->userdata('stake_details_id_fk');
        $data['routine_time_period'] = $this->Delete_routine_model->fetchRoutinetimes($college_id);
		$this->load->view($this->config->item('theme').'routine_management_v/routine/delete_routine_period_time_view',$data);
	}

	public function deletePeriodtimeroutine($period_start_time=NULL,$period_end_time=NULL){
		$college_id = $this->session->userdata('stake_details_id_fk');
		$data['all_period'] = $this->Delete_routine_model->fetchAllPeriods($college_id,$period_start_time,$period_end_time);
		
			if(sizeof($data['all_period'])==''){
				   $this->session->set_flashdata('error','No Routines Found On This Period Times');
				   redirect('admin/routine_management_c/routine/Deleteroutine_time');
			}else{
				$i=1;
			foreach($data['all_period'] as  $v){
				 $routineid[$i]["routine_manage_id_pk"]      = $v['routine_manage_id_pk'];
				 $i++;
			}
			$routines_id =array();
			$routines_id = @array_column($routineid,'routine_manage_id_pk');
			$i=1;
			foreach($data['all_period'] as  $v){
				 $routines[$i]["college_id_fk"]      		= $v['college_id_fk'];
				 $routines[$i]["operator_id_fk"]      		= $v['operator_id_fk'];
				 $routines[$i]["days_id_fk"]      			= $v['days_id_fk'];
				 $routines[$i]["period_no"]      			= $v['period_no'];
				 $routines[$i]["period_start_time"]   		= $v['period_start_time'];
				 $routines[$i]["period_end_time"]     		= $v['period_end_time'];
				 $routines[$i]["period_type_fk"]      		= $v['period_type_fk'];
				 $routines[$i]["room_no"]      				= $v['room_no'];
				 $routines[$i]["discipline_id_fk"]    		= $v['discipline_id_fk'];
				 $routines[$i]["year_id_fk"]      			= $v['year_id_fk'];
				 $routines[$i]["semester_id_fk"]      		= $v['semester_id_fk'];
				 $routines[$i]["status_code"]      			= $v['status_code'];
				 $routines[$i]["revert_reason"]      		= $v['revert_reason'];
				 $routines[$i]["entry_time"]      			= $v['entry_time'];
				 $routines[$i]["updated_time"]      		= $v['updated_time'];
				 $routines[$i]["entry_ip"]      			= $v['entry_ip'];
				 $routines[$i]["updated_ip"]      			= $v['updated_ip'];
				 $routines[$i]["active_status"]      		= $v['active_status'];
				 $routines[$i]["academic_year_fk"]      	= $v['academic_year_fk'];
				 $routines[$i]["routine_revart_time"]      	= $v['routine_revart_time'];
				 $routines[$i]["routine_revart_ip"]      	= $v['routine_revart_ip'];
				 $routines[$i]["routine_revart_by"]      	= $v['routine_revart_by'];
				 $routines[$i]["routine_unique_id"]      	= $v['routine_unique_id'];
				 $routines[$i]["routine_manage_id_fk"]      = $v['routine_manage_id_pk'];
				 $routines[$i]["acrhived_id_entry_time"]    = date('Y-m-d H:i:s');
				 $routines[$i]["acrhived_id_entry_ip"]      = $this->input->ip_address();
				 $routines[$i]["who_archived"]      		= $this->session->userdata('stake_holder_login_id_pk');
				 $i++;
			}
			
				$this->db->trans_begin();
	  			$insertarchived =  $this->Delete_routine_model->insertArchiveddetails($routines);
	  			$updatedetailstable  =  $this->Delete_routine_model->updateDetailsdata($college_id,$routines_id);
	  			$deleteroutine  =  $this->Delete_routine_model->deleteRoutinetimes($college_id,$period_start_time,$period_end_time);
	  			$updatemapingtable  =  $this->Delete_routine_model->updateRoutinemapping($routines_id);
				if($this->db->trans_status() === FALSE || !isset($insertarchived) || !isset($updatedetailstable) || !isset($deleteroutine) || !isset($updatemapingtable)){
				   $this->db->trans_rollback();
				   $this->session->set_flashdata('error','Something Went Wrong,Please Try After Sometime');
				   redirect('admin/routine_management_c/routine/Deleteroutine_time');
				}else{
				   $this->db->trans_commit();
				   $this->session->set_flashdata('success','Period time and routine has been successfully deleted');
				   redirect('admin/routine_management_c/routine/Deleteroutine_time');
				}
			}
		}


		public function deleteOnlytimes($period_start_time=NULL,$period_end_time=NULL){
			$college_id = $this->session->userdata('stake_details_id_fk');
			$checkroutine = $this->Delete_routine_model->checkRoutineavailbility($college_id,$period_start_time,$period_end_time);

			if($checkroutine>0){
				$this->session->set_flashdata('error','Period time can not be deleted, already routine created on this selected period time');
				  redirect('admin/routine_management_c/routine/Deleteroutine_time');
			}else{
				$deleteroutine  =  $this->Delete_routine_model->deleteRoutinetimes($college_id,$period_start_time,$period_end_time);
				if($deleteroutine){
					   $this->session->set_flashdata('success','Period Time has been successfully deleted');
					   redirect('admin/routine_management_c/routine/Deleteroutine_time');
				}else{
					  $this->session->set_flashdata('error','Something Went Wrong,Please Try After Sometime');
					  redirect('admin/routine_management_c/routine/Deleteroutine_time');
				}
			}
			
		}
		
		



}