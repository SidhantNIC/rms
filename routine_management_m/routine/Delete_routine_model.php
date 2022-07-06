<?php
defined('BASEPATH') OR exit('No direct script access allowed' );		
	class Delete_routine_model extends CI_Model {
		
		public function fetchRoutinetimes($college_id){
			$sql = $this->db->select('period_start_time,period_end_time,period_no_fk')
				->where('college_id_fk',$college_id)
				->where('active_status','1')
				->group_by('period_no_fk')
				->group_by('period_start_time')
				->group_by('period_end_time')
				->order_by('period_start_time')
				->get('poly_period_time_master');
		return $sql->result_array();
		}


		public function fetchAllPeriods($college_id,$period_start_time,$period_end_time){
			$sql = $this->db->select('*')
							->where('college_id_fk',$college_id)
							->where('status_code!=','4')
							->where('active_status','1')
							->where(
                                array(
                                        'MD5(CAST(period_start_time AS character varying))=' =>$period_start_time
                                    )
                                )
							->where(
                                array(
                                        'MD5(CAST(period_end_time AS character varying))=' =>$period_end_time
                                    )
                                )
							->get('routine_management_system_details');
			return $sql->result_array();

		}

		public function insertArchiveddetails($routines){
			return $this->db->insert_batch('routine_management_system_details_archived',$routines);
		}

		public function updateDetailsdata($college_id,$routines_id){
			return $this->db->set('active_status','0')
							->where('college_id_fk',$college_id)
							->where_in('routine_manage_id_pk',$routines_id)
							->update('routine_management_system_details');
		}

		public function deleteRoutinetimes($college_id,$period_start_time,$period_end_time){
			$this->db->where("college_id_fk", $college_id);
			$this->db->where(
                            array(
                                    'MD5(CAST(period_start_time AS character varying))=' =>$period_start_time
                                )
                            );;
			$this->db->where(
                            array(
                                    'MD5(CAST(period_end_time AS character varying))=' =>$period_end_time
                                )
                            );
    		$this->db->delete("poly_period_time_master");
    		return true;
		}

		public function updateRoutinemapping($routines_id){
			return $this->db->set('active_status','0')
							->where_in('routine_details_fk',$routines_id)
							->update('routine_management_maping_details');
		}

		public function checkRoutineavailbility($college_id,$period_start_time,$period_end_time){
			$sql = $this->db->select('*')
							->where('college_id_fk',$college_id)
							->where('active_status','1')
							->where(
                                array(
                                        'MD5(CAST(period_start_time AS character varying))=' =>$period_start_time
                                    )
                                )
							->where(
                                array(
                                        'MD5(CAST(period_end_time AS character varying))=' =>$period_end_time
                                    )
                                )
							->get('routine_management_system_details');
			return $sql->num_rows();
		}	
	}

?>