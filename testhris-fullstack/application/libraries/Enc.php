<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Enc {

    private $CI;
    //class variable utk menentukan "apa" diganti dengan "apa".. you know what i mean lah...
    var $needle = array('/', '\\', '+', '=');
    var $replacing_str = array('ss11', 'bs12', 'ps13', 'eq14');

    public function __construct()
    {
        $this->CI =& get_instance();
        // $this->CI->load->library('encrypt');
    }

    function fogit($the_message) 
    {
        $CI =& get_instance();

    	$text = $CI->encrypt->encode($the_message);
        $the_fog = $text;

        for($i=0; $i<4; $i++)
        {
            $the_fog = str_replace($this->needle[$i], $this->replacing_str[$i], $the_fog);
        }

    	return $the_fog;
    }

    function defog($the_fog)
    {
        $CI =& get_instance();

        for($i=0; $i<4; $i++)
        {
            $the_fog = str_replace($this->replacing_str[$i], $this->needle[$i], $the_fog);
        }

        $the_message = $CI->encrypt->decode($the_fog);

    	return $the_message;
    }
    
    public function restrict()
    {
        if ($this->CI->session->userdata('verification_status') == 0) {
            redirect('register');
        }
    }

    public function check_session()
    {
        if ($this->CI->session->userdata('user_email') == '') {
            $url = base_url();
            redirect($url);
            exit();
        } else {
            return TRUE;
        }
    }

    public function access_user()
    {
        $user_role = $this->CI->session->userdata('user_role');
        if ($user_role == '1' || $user_role == '99') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function logout()
    {
        $this->CI->session->sess_destroy();
        $url = base_url();
        redirect($url);
    }


}