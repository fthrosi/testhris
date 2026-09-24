<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  require '/var/www/html/application/vendor/phpmailer/phpmailer/src/Exception.php';
  require '/var/www/html/application/vendor/phpmailer/phpmailer/src/PHPMailer.php';
  require '/var/www/html/application/vendor/phpmailer/phpmailer/src/SMTP.php';
  // require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/Exception.php';
	// require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/PHPMailer.php';
	// require $_SERVER['DOCUMENT_ROOT'] . '/hris_ibsw/application/vendor/phpmailer/phpmailer/src/SMTP.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
class Login extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('login_model', 'login_m', TRUE);
    $this->load->library('enc');
    $this->load->model('login/login_model');
    $this->email = $this->session->userdata('user_email');
    $this->date = date('Y-m-d H:i:s');
    $this->year = date('Y');
    $this->load->library('curl');
    $this->load->library('enc');

    $this->status_apps = $_ENV['CI_ENVIRONMENT'];
  }


  public function index()
  {
    if(($this->session->userdata('nik')!='') && ($this->session->userdata('nik')!=' ')){
        redirect('dashboard');
    }else{
        $this->load->view('login/index');
    }
  }

  public function forgot_password()
  {
    $kind = $this->input->get('kind');

    $data['kind'] = $kind;

    $response = $this->load->view('login/forgot_password', $data, TRUE);
    header('Content-type: application/json');
    echo json_encode($response);
  }

  public function reset_password()
  {
    $email = $this->input->post('email');
    $cek_email = $this->login_model->checkEmail($email);

    if((!empty($cek_email[0]->nik))){

      $nik = $cek_email[0]->nik;
      $sql = "SELECT * FROM users WHERE employee_id='$nik'";
      $query = $this->db->query($sql);
      $res = $query->result();

      if (!empty($res[0]->id_user)) {
        $emp_id = $res[0]->employee_id;
        $update_password = $this->login_model->updatePassword($emp_id);
        
        $sql = "SELECT * FROM users WHERE employee_id='$emp_id'";
        $query = $this->db->query($sql);
        $res = $query->result();        

        $new_reset_password = decrypt($res[0]->password);
        $this->sendEmail('reset_password_email', $res[0]->full_name, $res[0]->user_email, $new_reset_password);

        $data['kind'] = 'reset_password';
        $data['content'] = $this->load->view('login/forgot_password', $data, TRUE);
        $response = array('status' => 1, 'message' => 'Success', 'data' => $data);
      } else {
        $response = array('status' => 0, 'message' => '<b>user has not been created!</b>');
      }
    } else{
      $response = array('status' => 0, 'message' => '<b>Email not registered!</b>');
    }
      header('Content-type: application/json');
      echo json_encode($response);

  }

  public function sendEmail($type, $fullname, $email_to, $new_password)
  {

    $data['email'] = $email_to;
    $data['fullname'] = $fullname;
    $data['new_password'] = $new_password;
    $html = $this->load->view('services/email/reset_password_email', $data, TRUE);
    $email_subject = 'Reset Password Email';


    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host       = 'mail.ibsmulti.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'no.reply@ibsmulti.com'; // ubah dengan alamat email Anda
    $mail->Password   = '1214#$C1k1n1.2026'; // ubah dengan password email Anda
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('no.reply@ibsmulti.com', 'HRIS - Notification System'); // ubah dengan alamat email Anda
    $mail->addAddress($email_to);

    // Isi Email
    $mail->isHTML(true);
    $mail->Subject = $email_subject;
    $mail->Body    = $html;

    $mail->send();
  }

  public function proses_login_from_intranet()
  {
    // proses_login();
   
    $email = base64_decode($this->input->get('email'));
    $nik = base64_decode($this->input->get('nik'));
    // dumper($nik);

    $data = $this->login_model->get_user_login($email, $nik);

  
    if($this->status_apps == "development") {
      $is_status = "Maintenance";
    } else if ($this->status_apps == "staging") {
      $is_status = "Maintenance";
    } else if ($this->status_apps == "production") {
      $is_status = "Live";
    }
    // $is_status = "Live";

    if((!empty($data[0]))){

      $sess_array = array(     
          'user_email' => decrypt($data[0]->email),   
          'user_role' => $data[0]->user_role,    
          'access_level' => $data[0]->access_level, 
          'verification_status' => $data[0]->verification_status, 
          'employee_id' => $data[0]->employee_id,
          'join_date' => $data[0]->join_date,
          'action' => $data[0]->action,
          'employee_subgroup' => $data[0]->employee_subgroup, 
          'employee_group' => $data[0]->employee_group, 
          'name' => decrypt($data[0]->complete_name), 
          'cost_center' => decrypt($data[0]->cost_center), 
          'nik' => $data[0]->employee_id,
          'division' => $data[0]->division,
          'gender' => $data[0]->gender,
          'access_employee' => $data[0]->user_role,
          'access_level' => $data[0]->access_level,
          'id_hr_emp' => $data[0]->id_employee,
          'company_code' => decrypt($data[0]->company_code),
          'marital_status' => $data[0]->marital_status,
          'personnel_area' => $data[0]->personnel_area,
          'directorate' => $data[0]->directorate,
          'department' => $data[0]->department,
          'second_division' => $data[0]->second_division,
          'depthead' => $data[0]->usrid_long2,
          'divhead' => $data[0]->usrid_long3,
          'director' => $data[0]->usrid_long4,
          'employee_grade' => $data[0]->employee_group,
          'division_root' => $data[0]->division_root
      );


          $this->session->set_userdata($sess_array);
          $data_ses = $this->session->userdata();
          if($is_status == "Maintenance" && $email != "hr.support@ibsmulti.com" && $email != "abimas.dewangga@ibsmulti.com" && $email != "palupi.utami@ibsmulti.com" && $email != "gilang.cahyo@ibsmulti.com" && $email != "ditha.damayanti@ibsmulti.com" && $email != "luffi.utomo@ibsmulti.com"){
              $this->session->sess_destroy();
              $this->load->view('login/maintenance_503');
          }else{
            redirect('dashboard');
          }
    }else{
      $this->session->sess_destroy();
      redirect('login');
    }
  }
  
  public function proses_login()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    // $password = encrypt($password);

    $data = $this->login_model->getUsers($email, $password);
    if($this->status_apps == "development") {
      $is_status = "Maintenance";
    } else if ($this->status_apps == "staging") {
      $is_status = "Staging";
    } else if ($this->status_apps == "production") {
      $is_status = "Live";
    }

        if((!empty($data[0]->nik))){
          $nik_superior = decrypt($data[0]->superior);
          $email_superior = $this->db->get_where('hris_employee',array('nik'=>$nik_superior))->row_array()['email'];

          $sess_array = array(     
            'user_email' => decrypt($data[0]->email),   
            'user_role' => $data[0]->user_role,    
            'access_level' => $data[0]->access_level, 
            'verification_status' => $data[0]->verification_status, 
            'employee_id' => $data[0]->employee_id,
            'join_date' => $data[0]->join_date,
            'action' => $data[0]->action,
            'employee_subgroup' => $data[0]->employee_subgroup, 
            'employee_group' => $data[0]->employee_group, 
            'name' => decrypt($data[0]->complete_name), 
            'cost_center' => decrypt($data[0]->cost_center), 
            'nik' => $data[0]->employee_id,
            'division' => $data[0]->division,
            'gender' => $data[0]->gender,
            'access_employee' => $data[0]->user_role,
            'access_level' => $data[0]->access_level,
            'id_hr_emp' => $data[0]->id_employee,
            'company_code' => decrypt($data[0]->company_code),
            'marital_status' => $data[0]->marital_status,
            'personnel_area' => $data[0]->personnel_area,
            'directorate' => $data[0]->directorate,
            'department' => $data[0]->department,
            'second_division' => $data[0]->second_division,
            'depthead' => $data[0]->usrid_long2,
            'divhead' => $data[0]->usrid_long3,
            'director' => $data[0]->usrid_long4,
            'employee_grade' => $data[0]->employee_group,
            'division_root' => $data[0]->division_root,
            'exit_clearance_roles' => $data[0]->exit_clearance_roles
          );

          $this->session->set_userdata($sess_array);
          $data_ses = $this->session->userdata();
          if($is_status == "Maintenance" && $email != "hr.support@ibsmulti.com" && $email != "abimas.dewangga@ibsmulti.com" && $email != "palupi.utami@ibsmulti.com" && $email != "gilang.cahyo@ibsmulti.com" && $email != "ditha.damayanti@ibsmulti.com" && $email != "luffi.utomo@ibsmulti.com" && $email != "GUNAWAN.TANUDY@IBSMULTI.COM" && $email != "sudarman@ibsmulti.com" && $email != "anni.suwardi@ibsmulti.com"){
              $this->session->sess_destroy();
              $this->load->view('login/maintenance_503');
          }else{

            if ($this->session->userdata('redirect_url')) {
                $target_url = $this->session->userdata('redirect_url');
                
                // Hapus session redirect agar tidak tersimpan terus
                $this->session->unset_userdata('redirect_url');
                
                // Redirect otomatis ke link awal yang diklik user
                redirect($target_url);
            }else{
                redirect('dashboard');
            }
            
          }
        }else{
          $this->session->sess_destroy();
          redirect('login');
        }
    
  }
  
  public function do_logout()
  {
    $this->session->sess_destroy();
    $url = base_url();
    redirect($url);
    exit();
  }

  function email_name($address)
  {
    $str    = substr($address, strpos($address, "@") + 1);
    $str    = str_replace('@'.$str, '', $address);
    $str    = str_replace('.', ' ', $str);

    if ($str == 'fadli fadli') {
      $str = 'Super Admin';
    }
    else {
      $str = ucwords($str);
    }

    return $str;
  }

  public function logs($type, $formType, $id, $activity = '', $description = '')
  {
    $log['request_id'] = $id;
    $log['form_type'] = $formType;
    $log['created_by'] = ($type == 'system') ? 'system' : $this->email;
    $log['created_at'] = $this->date;

    switch ($type) {
      case 'system':
        $log['activity'] = $activity;
        $log['description'] = $description;
        $this->db->insert('logs', $log);
        break;
      case 'approved':
        $log['activity'] = 'Approved';
        $log['description'] = 'Success';
        $this->db->insert('logs', $log);
        break;
      default:
        break;
    }
  }

}
?>