<?php
defined('BASEPATH') OR exit('No direct script access allowed' );

class Routine_management_helper_model extends CI_Model{

 // get all academic session name
	public function academic_session_name($academicid = NULL)
	{
		$query = $this->db->select('
									academic_year_id_pk,
									academic_year_description									
									')
						->from('routine_academic_session_year_master')
						->where(
                            array('academic_year_id_pk' => $academicid)
                        )	
						->get();
		return $query->result_array();		
	}

}