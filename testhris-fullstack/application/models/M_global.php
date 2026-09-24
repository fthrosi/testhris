<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_global extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	public function get($field, $table, $where = null)
	{
		return $this->db->select($field)->where($where)->get($table)->result_array();
	}

	public function getAll($table, $where = null)
	{
		return $this->db->select("*")->where($where)->get($table)->result_array();
	}

	public function getRow($field, $table, $where = null)
	{
		return $this->db->select($field)->where($where)->get($table)->row_array();
	}

	public function find($table, $field = '', $value = '', $order_by = '', $order_type = '')
	{
		if ($field != '' && $value != '') {
            $this->db->where($field, $value);
        }

        if ($order_by != '') {
        	if ($order_type != '') {
        		$this->db->order_by($order_by, $order_type);
        	}
        	else {
        		$this->db->order_by($order_by, 'ASC');
        	}
        }

        return $this->db->get($table);
	}

	public function save($table, $data)
	{
		return $this->db->insert($table, $data);
	}

	public function update($field, $value, $table, $data)
	{
		return $this->db->where($field, $value)->update($table, $data);
	}

	public function delete($field, $value, $table)
	{
		if (is_array($value)) {
            $this->db->where_in($field, $value);
        }
        else {
            $this->db->where($field, $value);
        }

        return $this->db->delete($table);
	}

	public function getTotalData($table, $field, $value)
	{
		if ($field != '' && $value != '') {
            $this->db->where($field, $value);
        }
        
		$query = $this->db->get($table);
		return $query->num_rows();	
	}

	/* Save Log
	 * 1 = 
	 * 2 = 
	 * 3 = 
	 * 4 = 
	*/

	function log($trans_type, $trans_id, $log_type)
	{
		if ($this->input->post('supervised_id') != null) {
			$getSupervised = $this->db->get_where('employee', array('id' => $this->input->post('supervised_id')))->row_array()['employee_name'];
		}
		
		if ($log_type == 1) {
			$description =  '[ '.getSession('user_division').' ] - 
								'.getSession('user_display').' mengajukan approval penilaian kepada '.$getSupervised;
		}
		elseif ($log_type == 2) {
			$description =  '[ '.getSession('user_division').' ] - 
								'.getSession('user_display').' menyetujui penilaian '.$this->input->post('employee_name').' dan 
								meneruskan approval kepada '.$getSupervised;

		}
		elseif ($log_type == 3) {
			$description =  '[ '.getSession('user_division').' ] - 
								'.getSession('user_display').' menyetujui penilaian '.$this->input->post('employee_name');
		}
		else {
			$description =  '[ '.getSession('user_division').' ] - 
								'.getSession('user_display').' menolak penilaian dari '.$this->input->post('employee_name').', dengan alasan : 
								'.$this->input->post('description');
		}

		if ($save != TRUE) {
			return $description;
		}
		else {
			$log  = array(
			 			'log_type'			=> $log_type,
			 			'achievement_id'	=> $achievement_id,
			 			'ip_address'		=> $_SERVER['SERVER_ADDR'],
	                    'user_agent'    	=> $this->input->user_agent(),
	                    'description'		=> $description,
	                    'created_at'    	=> date('Y-m-d H:i:s'),
	                    'created_by' 		=> getSession('user_email'));

	        return $this->db->insert('log', $log);
		}

	}

	### Ajax 
	public function ajaxGet($field, $table, $where = null)
	{
		$data = $this->get($field, $table, $where);
		echo json_encode($data);
	}

}