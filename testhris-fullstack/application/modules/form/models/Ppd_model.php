<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ppd_model extends CI_Model {

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->helper('general');
          $this->email = $this->session->userdata('user_email');
          $this->date = date('Y-m-d H:i:s');
          $this->year = date('Y');
     }
    
     public function save_approval($email, $requestId, $method = '')
     {
          switch ($method) {

               case 'save':

                    // If any, then delete first
                    $check = $this->db->where('request_id', $requestId)->get('form_approval');
                    if ($check->num_rows() > 0) { $this->db->delete('form_approval', array('request_id' => $requestId)); } 

                    $i = 0;
                    $priority = 1;
                    $count = count($email);

                    for ($i=0; $i < $count; $i++) { 

                         if ($email[$i] === 'handra@ibstower.com') {
                              $alias = 'Commitee';
                         } else {
                              $alias = $email[$i];
                         }

                         if ($count === 5 && $priority === 1) {
                              $approval = array(
                                   'request_id' => $requestId,
                                   'approval_priority' => $priority,
                                   'approval_email' => $email[$i],
                                   'approval_alias' => $alias,
                                   'approval_title' => 'Requestor',
                                   'approval_status' => '',
                                   'approval_note' => '',
                                   'created_at' => date('Y-m-d H:i:s'),
                                   'created_by' => $this->email);

                         } else {
                              $approval = array(
                                   'request_id' => $requestId,
                                   'approval_priority' => $priority,
                                   'approval_email' => $email[$i],
                                   'approval_alias' => $alias,
                                   'approval_title' => '',
                                   'approval_status' => '',
                                   'approval_note' => '',
                                   'created_at' => date('Y-m-d H:i:s'),
                                   'created_by' => $this->email);
                         }

                         $layer[] = $approval;
                         $priority++;
                    }

                    if ($this->db->insert_batch('form_approval', $layer)) {
                         return true;
                    } else {
                         return false;
                    }
                    
                    break;

               case 'submit':

                    // If any, then delete first
                    $check = $this->db->where('request_id', $requestId)->get('form_approval');
                    if ($check->num_rows() > 0) { $this->db->delete('form_approval', array('request_id' => $requestId)); } 

                    $i = 0;
                    $priority = 1;
                    $count = count($email);

                    for ($i=0; $i < $count; $i++) { 

                         if ($email[$i] === 'handra@ibstower.com') {
                              $alias = 'Commitee';
                         } else {
                              $alias = $email[$i];
                         }

                         if ($priority == 1) {
                              $approval = array(
                                   'request_id' => $requestId,
                                   'approval_priority' => $priority,
                                   'approval_email' => $email[$i],
                                   'approval_alias' => $alias,
                                   'approval_status' => 'In Progress',
                                   'approval_note' => '',
                                   'created_at' => date('Y-m-d H:i:s'),
                                   'created_by' => $this->email);

                         } else {
                              $approval = array(
                                   'request_id' => $requestId,
                                   'approval_priority' => $priority,
                                   'approval_email' => $email[$i],
                                   'approval_alias' => $alias,
                                   'approval_status' => '',
                                   'approval_note' => '',
                                   'created_at' => date('Y-m-d H:i:s'),
                                   'created_by' => $this->email);
                         }
                         
                         $layer[] = $approval;
                         $priority++;
                    }

                    if ($this->db->insert_batch('form_approval', $layer)) {
                         return true;
                    } else {
                         return false;
                    }
                    
                    break;

               case 'resubmit':

                    // If any, then delete first
                    $check = $this->db->where('request_id', $requestId)->get('form_approval');
                    if ($check->num_rows() > 0) { $this->db->delete('form_approval', array('request_id' => $requestId)); } 

                    $i = 0;
                    $priority = 1;
                    $count = count($email);

                    for ($i=0; $i < $count; $i++) { 

                         if ($email[$i] === 'handra@ibstower.com') {
                              $alias = 'Commitee';
                         } else {
                              $alias = $email[$i];
                         }

                         if ($priority == 1) {
                              $approval = array(
                                   'request_id' => $requestId,
                                   'approval_priority' => $priority,
                                   'approval_email' => $email[$i],
                                   'approval_alias' => $alias,
                                   'approval_status' => 'In Progress',
                                   'approval_note' => '',
                                   'created_at' => date('Y-m-d H:i:s'),
                                   'created_by' => $this->email);

                         } else {
                              $approval = array(
                                   'request_id' => $requestId,
                                   'approval_priority' => $priority,
                                   'approval_email' => $email[$i],
                                   'approval_alias' => $alias,
                                   'approval_status' => '',
                                   'approval_note' => '',
                                   'created_at' => date('Y-m-d H:i:s'),
                                   'created_by' => $this->email);
                         }
                         
                         $layer[] = $approval;
                         $priority++;
                    }

                    if ($this->db->insert_batch('form_approval', $layer)) {
                         return true;
                    } else {
                         return false;
                    }
                    
                    break;
               
               default:
                    break;
          }
          
     }

}