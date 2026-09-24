<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @version    1.0.1
 * @author     Ricky Kusriana Subagja | rickykusriana@gmail.com || Modified by : Fadli - ffadlifad@gitlab 2020
 * @copyright  (c) 2016
 */

class Templates extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Parameter yang dikirim ke view
	 *
	 * @param	string	$controller Nama controller
	 * @param	array	$replace 	Apabila value parameter ada perubahan   
	 * @return 	array
	 */
	public function attribute($controller, $replace = null)
	{
		// dumper($controller);
		switch ($controller) {

			case 'archive':
				$attr 	= array(
					'nav_archive'	=> 'active',
					'breadcumb'		=> true
				);
				break;

			case 'master':
				$attr 	= array(
					'nav_master'	=> 'active',
					'breadcumb'		=> true
				);
				break;

			case 'dashboard':
				$attr 	= array(
					'nav_dashboard'	=> 'active',
					'breadcumb'		=> true
				);
				break;

			case 'inbox':
				$attr 	= array(
					'nav_inbox'	=> 'active',
					'breadcumb'		=> true
				);
				break;

			case 'form':
				$attr 	= array(
					'nav_form'	=> 'active',
					'breadcumb'		=> true
				);
				break;

			case 'request':
				$attr 	= array(
					'nav_request'	=> 'active',
					'breadcumb'		=> true
				);
				break;

			case 'approval':
				$attr 	= array(
					'nav_approval'	=> 'active',
					'breadcumb'		=> true
				);
				break;

			case 'review':
				$attr 	= array(
					'nav_review'	=> 'active',
					'breadcumb'		=> true
				);
				break;

			case 'create':
				$attr 	= array(
					'nav_request'	=> 'active',
					'breadcumb'		=> true
				);
				break;

			case 'ebast':
				$attr 	= array(
					'nav_ebast'	=> 'active',
					'breadcumb'		=> true
				);
				break;

			default:
				$attr 	= '';
		}
		
		if (is_array($replace)) {
			$data = array_replace($attr, $replace);
		} else {
			$data = $attr;
		}

		return $data;
	}

	/**
	 * Save into database
	 *
	 * @param	string	$method Metode insert atau update
	 * @param	string	$table 	Nama table database
	 * @param 	array	$where 	Primary key dan value untuk update
	 * @return 	bool
	 */
	public function save($method, $table, $where = null)
	{
		// Load module app_data
		$this->load->module('templates/app_data', 'app_data');

		if ($this->input->post()) {

			// Akses module app_data
			$validation = $this->app_data->validation($table);
			$field_data = $this->app_data->field_data($table);

			if ($validation) {

				if ($method == 'create') {

					if ($this->m_global->save($table, $field_data)) 
						return TRUE;
				}
				else {

					if ($this->m_global->update($where[0], $where[1], $table, $field_data))
						return TRUE;
				}
			}
			else {
				echo json_encode(array('status' => false, 'error' => validation_errors()));
				die;
			}
		}
	}

	/**
	 * Display on view
	 *
	 * @param	string	$method  Form/interface yang akan ditampilkan
	 * @param	string	$view 	 Lokasi module view
	 * @param 	array	$default Data yang akan ditampilkan
	 * @return 	html
	 */
	public function show($method, $view, $default = null)
	{
		// Penambahan atribut yg akan ditampilkan
		// dumper($method);
		$data 				= $default;
		$data['action']		= site_url(uri_string());

		if ($method == 'create') {
			$data['query']	= false;
			$data['button']	= 'Save';
			$data['alert']	= status('created');
		}
		elseif ($method == 'update') {
			$data['button']	= 'Update';
			$data['alert']	= status('updated');
		}
		elseif ($method == 'detail') {
			
		}
		else {
			if ( ! in_array($default, array('attr'))) {
				if ($method == 'index') {
					$data['attr'] = $this->attribute($this->router->fetch_class());
				}
				else { // menu/order
					$data['attr'] = $this->attribute($method.'/'.$this->router->fetch_class());
				}
			}
		}

		return $this->load->view($view, $data);
	}

	/**
	 * Generate serverside datatable
	 *
	 * @param	array	$sendData  	Data untuk m_datatable yang dikirim dari controller
	 * @param	string	$field 	 	Nama field tabel yg akan ditampilkan
	 * @param 	array	$button 	Dikirim dari controller untuk function btnAction()
	 * @param 	bool	$checkbox 	Checkbox ditampilakan pada table
	 * @return 	json
	 */
	public function datatable($sendData, $field, $button, $checkbox = true)
	{
		// Load model m_datatable
		$this->load->model('m_datatable');

		// Variable datatables
		$data 	= array();
		$no 	= $this->input->post('start');
		$list 	= $this->m_datatable->get_datatables($sendData);

		foreach ($list as $key) {
			$no++;
			$row   = array();

			if ($checkbox == true) {
				$row[] = '<input type="checkbox" class="tc" id="checkbox" name="checked[]" value="'.$key->id.'"><span class="labels"></span>';
			}

			$row[] = $no;

			// Pecah $field dari controller
			foreach ($field as $field_data) {

				// Cek apakah ada kondisi yang akan ditampilkan, ditandai dengan array pada data 
				if (is_array($field_data)) {
					
					$label = $field_data[0];
					$value = $field_data[1];

					if ($label == 'is_active') {
						$row[] = $key->$label == 'N' ? '<label class="label label-danger">Nonaktif</label>&nbsp;&nbsp;'.$key->$value : $key->$value;
					}
					elseif ($label == 'is_status') {

						if ($key->$label == 1) {
							$status = 'Draft';
							$color = 'label-primary';
						}
						elseif ($key->$label == 2) {
							$status = 'In Progress';
							$color = 'label-info';
						}
						elseif ($key->$label == 3) {
							$status = 'Received';
							$color = 'label-success';
						}
						elseif ($key->$label == 4) {
							$status = 'Revise';
							$color = 'label-warning';
						}
						else {
							$status = 'Reject';
							$color = 'label-danger';
						}

						$row[] = $status != '' ? '<label class="label '.$color.'">'.$status.'</label>&nbsp;&nbsp;'.$key->$value : $key->$value;
					}
					elseif ($label == 'filter_url') {
						$row[] = filter_var($key->$value, FILTER_VALIDATE_URL) ? '<a href="'.$key->$value.'" target="_blank">'.substr($key->$value, 0, 100).'</a>' : substr($key->$value, 0, 100);
					}
					elseif ($label == 'rupiah') {
						$row[] = '<span class="pull-right">'.rupiah($key->$value).'</span>';
					}
					else {
						$row[] = $key->$label .' / '.$key->$value;
					}
				}
				else {
					$row[] = $key->$field_data;
				}

			}

			// Akses function btnAction() untuk menampilkan button
			$row[] = $this->btnAction($button, $key->id);
		
			$data[] = $row;
		}

		// Variable datatables
		$output = array(
					'draw' 				=> $this->input->post('draw'),
					'recordsTotal' 		=> $this->m_datatable->count_all($sendData),
					'recordsFiltered' 	=> $this->m_datatable->count_filtered($sendData),
					'data' 				=> $data);

		echo json_encode($output);
	}

}

/* End of file Templates.php */
/* Location: ./application/modules/templates/controllers/Templates.php */