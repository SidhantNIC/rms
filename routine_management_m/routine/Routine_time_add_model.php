<?php
defined('BASEPATH') OR exit('No direct script access allowed' );
class Routine_time_add_model extends CI_Model {

	// fetch all period no
    public function getAllperiodno(){
       $query = $this->db->select('*')
                            ->from('poly_period_no_master')
                            ->where(
                                    array('active_status' =>'1')
                                )
                            ->order_by('id')
                            ->get();
            return $query->result_array();
    }

    //public function getAllperiodlist($college_id,$operator_id){
	//$data = $this->db->select('*')
                    //->select('period_no.description as period_no_desc')
                    //->where('college_id_fk',$college_id)
                    //->where('operator_id_fk',$operator_id)
                    //->where('a.active_status','1')
                    //->from('poly_period_time_master as a')
                    //->join('poly_period_no_master as period_no','period_no.id = a.period_no_fk','LEFT')
                    //->order_by('a.period_no_fk')
                    //->get();
    //return $data->result_array();
  //}
  
  public function getAllperiodlist($college_id){
	$data = $this->db->select('period_no_fk,period_start_time,period_end_time')
                    ->where('college_id_fk',$college_id)
                    ->where('active_status','1')
					->group_by('period_no_fk')
					->group_by('period_start_time')
					->group_by('period_end_time')
                    ->from('poly_period_time_master')
                    ->order_by('period_no_fk')
                    ->get();
    return $data->result_array();
  }

  public function checkPeriodtimeblankornot($college_id,$operator_id){
  	$sql = $this->db->select('period_time_id_pk')
  					->where('college_id_fk',$college_id)
  					->where('operator_id_fk',$operator_id)
  					->where('active_status','1')
  					->get('poly_period_time_master');
  	return $sql->num_rows();
  }

  public function periodFirstinsert($data){
  	return $this->db->insert('poly_period_time_master',$data);
  }

  public function fetchStarttime($checkstarttime,$college_id,$operator_id){
  	$sql = $this->db->select('period_start_time')
  					->where('college_id_fk',$college_id)
  					//->where('operator_id_fk',$operator_id)
  					->where('period_no_fk',$checkstarttime)
  					->where('active_status','1')
  					->get('poly_period_time_master');
  	return $sql->result_array();


  }
  public function fetchEndtime($checkendtime,$college_id,$operator_id){
  	$sql = $this->db->select('period_end_time')
  					->where('college_id_fk',$college_id)
  					//->where('operator_id_fk',$operator_id)
  					->where('period_no_fk',$checkendtime)
  					->where('active_status','1')
  					->get('poly_period_time_master');
  	return $sql->result_array();
  }

  public function checkPeriodavailable($college_id, $operator_id,$period_no){
  	$sql = $this->db->select('period_time_id_pk')
  					->where('college_id_fk',$college_id)
  					//->where('operator_id_fk',$operator_id)
  					->where('period_no_fk',$period_no)
  					->where('active_status','1')
  					->get('poly_period_time_master');
  	return $sql->num_rows();
  }
  
  public function fetchSecondperiodstarttime($college_id, $operator_id){
   $sql = $this->db->select('period_start_time')
            ->where('college_id_fk',$college_id)
            //->where('operator_id_fk',$operator_id)
            ->where('period_no_fk','2')
            ->where('active_status','1')
            ->get('poly_period_time_master');
    return $sql->result_array();
  }


}