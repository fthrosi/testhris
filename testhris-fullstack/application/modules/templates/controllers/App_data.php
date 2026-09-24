<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @version    1.0.1
 * @author     Ricky Kusriana Subagja | rickykusriana@gmail.com || Modified by : Fadli - ffadlifad@gitlab 2020
 * @copyright  (c) 2016
 */

class App_data extends Admin_Controller {

	public function __construct()
	{		
		parent::__construct();
	}

	public function validation($data)
	{
		$this->load->library('form_validation');

		$config = array(

            'form_request' => array(
                array(
                    'field' => 'user_email',
                    'label' => 'user_email',
                    'rules' => 'trim|required|valid_email'
                )
            ),

	        'user' => array(
                array(
                    'field' => 'user_display',
                    'label' => 'user_display',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'user_email',
                    'label' => 'user_email',
                    'rules' => 'trim|required|valid_email'
                ),
                array(
                    'field' => 'user_level',
                    'label' => 'user_level',
                    'rules' => 'trim|required'
                )
	        ),

            'user_level' => array(
                array(
                    'field' => 'user_level',
                    'label' => 'user_level',
                    'rules' => 'trim|required'
                )
            )

		);

		$this->form_validation->set_rules($config[$data]);
		if ($this->form_validation->run())
			return TRUE;
	}

	public function field_data($data)
	{
		$user = $this->session->userdata('email');
        $date = date('Y-m-d H:i:s');
        $year = date('Y');

        // Generate Request Number
        $this->db->select_max('id');
        $eid = $this->db->get('form_request')->row_array();
        $reqnum = $eid['id'] + 1;
        $request_number = 'EAPP-'.$year.'-'.str_pad($reqnum, 7, 0, STR_PAD_LEFT); 

		switch($data) {

           case 'form_approval' :

                $this->load->helper('string');

                if ($this->uri->segment(2) == 'update') {
                    $field = array (
                        'po_number'       => $this->input->post('po_number'),
                        'worktype_id'     => $this->input->post('worktype_id'),
                        'milestone_id'    => $this->input->post('milestone_id'),
                        'is_status'       => $this->input->post('is_status'),
                        'updated_by'      => $user,
                        'vendor_submit_date' => $date,
                        'updated_at'      => $date);
                }
                else {
                    $field = array(
                        'request_number'  => $request_number,
                        'po_number'       => $this->input->post('po_number'),
                        'po_created_date' => $this->input->post('po_created_date'),
                        'vendor_id'       => $this->input->post('vendor_id'),
                        'vendor_name'     => $this->input->post('vendor_name'),
                        'vendor_title'    => $this->input->post('vendor_title'),
                        'vendor_email'    => $this->input->post('vendor_email'),
                        'worktype_id'     => $this->input->post('worktype_id'),
                        'milestone_id'    => $this->input->post('milestone_id'),
                        'is_status'       => $this->input->post('is_status'),
                        'sap_id'          => $this->input->post('sap_id'),
                        'app_flag'        => 0,
                        'created_by'      => $user,
                        'created_at'      => $date);
                }
                
                return $field;
                break;

            // Master
            case 'tm_tax_type' :
                $field = array(
                        'tax_name'          => ucwords($this->input->post('tax_name')),
                        'tax_percentage'    => $this->input->post('tax_percentage'),
                        'modified_by'       => $user,
                        $this->uri->segment(3) == 'update' ? 'updated_at' : 'created_at' => $date);

                if ($this->uri->segment(3) != 'update') {
                    $field['tax_group_id'] = $this->input->post('tax_group_id');
                }

                return $field;
                break;

            case 'user':

                $field['user_display']  = $this->input->post('user_display');
                $field['user_email']    = $this->input->post('user_email');
                $field['vendor_code']   = $this->input->post('vendor_code');
                $field['user_level']    = $this->input->post('user_level');
                $field['is_active']     = $this->input->post('is_active');
                $field['modified_by']   = $user;

                if ($this->uri->segment(3) == 'update') {
                    $field['updated_at'] = $date;
                }
                else {
                    $field['created_at'] = $date;
                }

                return $field;
                break;

            case 'user_level':
                return array(
                    'user_level'    => $this->input->post('user_level'),
                    'description'   => $this->input->post('description'),
                    'modified_by'   => $user,
                    $this->uri->segment(3) == 'update' ? 'updated_at' : 'created_at' => $date);
                break;

            case 'register':
                return array(
                    'user_email'   => $this->input->post('user_email'),
                    'user_display' => $this->input->post('user_display'),
                    'vendor_code'  => $this->input->post('vendor_code'),
                    'user_level'   => $this->input->post('user_level'),
                    'created_at'   => $date,
                    'modified_by'  => $user);
                break;
        }
	}

}

/* End of file Templates.php */
/* Location: ./application/modules/templates/controllers/Templates.php */