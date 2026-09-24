<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('email_name')) {
    function email_name($address)
    {
        $str    = substr($address, strpos($address, "@") + 1);
        $str    = str_replace('@' . $str, '', $address);
        $str    = str_replace('.', ' ', $str);

        if ($str == 'fadli fadli') {
            $str = 'Super Admin';
        } else {
            $str = ucwords($str);
        }

        return $str;
    }
}

if (!function_exists('range_grade')) {
    function range_grade($type)
    {
        if ($type == 'GOL A') {
            $status = ' A';

        } else if ($type == 'GOL B' || $type == 'GOL C' || $type == 'GOL D' || $type == 'GOL E') {
            $status = ' B-C-D-E';

        } else if ($type == 'GOL F' || $type == 'GOL G') {
            $status = ' F-G';

        } else if ($type == 'GOL H' || $type == 'GOL I' || $type == 'GOL J' || $type == 'GOL K' || $type == 'GOL L') {
            $status = ' H-I-J-K-L';
        }
        
        return $status;
    }
}

if (!function_exists('status_color')) {
    function status_color($type)
    {
        if ($type == 0) {
            $status = ' Draft';
            $color = 'gray';

        } else if ($type == 1) {
            $status = ' Waiting Approval';
            $color = 'primary';

        } elseif ($type == 7) {
            $status = ' Canceled';
            $color = 'danger';
        
        } elseif ($type == 2) {
            $status = ' Revised';
            $color = 'warning';
        
        } elseif ($type == 3) {
            $status = ' Full Approved';
            $color = 'success';
        
        } elseif ($type == 4) {
            $status = ' Rejected';
            $color = 'danger';
        
        } elseif ($type == 5) {
            $status = ' Hold';
            $color = 'default';

        } elseif ($type == 6) {
            $status = ' Review';
            $color = 'info';
        }
        return '<span class="badge badge-pill badge-sm badge-' . $color . '"> ' . $status . '</span>';
    }
}

if (!function_exists('status_text')) {
    function status_text($type)
    {
        if ($type == 0) {
            $status = ' Draft';
            $color = 'gray';

        } else if ($type == 1) {
            $status = ' Waiting Approval';
            $color = 'primary';

        } elseif ($type == 7) {
            $status = ' Canceled';
            $color = 'danger';
        
        } elseif ($type == 2) {
            $status = ' Revised';
            $color = 'warning';
        
        } elseif ($type == 3) {
            $status = ' Full Approved';
            $color = 'success';
        
        } elseif ($type == 4) {
            $status = ' Rejected';
            $color = 'danger';
        
        } elseif ($type == 5) {
            $status = ' Hold';
            $color = 'default';

        } elseif ($type == 6) {
            $status = ' Review';
            $color = 'info';
        }
        return '<span class="badge badge-' . $color . '"> ' . $status . '</span>';
    }
}

if (!function_exists('approval_status')) {
    function approval_status($type)
    {
        if ($type == "In Progress") {
            $icon = 'fa fa-spinner';
            $color = 'success';
        } elseif ($type == "Canceled") {
            $icon = 'fa fa-backward';
            $color = 'danger';
        } elseif ($type == "Revised") {
            $icon = 'fa fa-pencil-square-o';
            $color = 'warning';
        } elseif ($type == "Approved") {
            $icon = 'fa fa-check';
            $color = 'primary';
        } elseif ($type == "Rejected") {
            $icon = 'fa fa-remove';
            $color = 'danger';
        } elseif ($type == "Hold") {
            $icon = 'fa fa-stop';
            $color = 'default';
        } else {
            $icon = 'fa fa-search';
            $color = 'info';
        }
        return '<div class="badge badge-' . $color . '">' . $type . '</div>';
    }
}

if (!function_exists('grade_pa')) {
    function grade_pa($type)
    {
        if ($type >= '9.1') {
            $status = ' A';
            $color = 'soft';

        } else if ($type >= '8.1' && $type < '9.1') {
            $status = ' B';
            $color = 'soft';

        } else if ($type >= '6.9' && $type < '8.1') {
            $status = ' C';
            $color = 'soft';
        
        } else if ($type >= '5.6' && $type < '6.9') {
            $status = ' D';
            $color = 'soft';
        
        } else if ($type >= '0.0' && $type < '5.6') {
            $status = ' E';
            $color = 'soft';
        
        } 
        // return '<span class="badge badge-pill badge-sm badge-' . $color . '"> ' . $status . '</span>';
        return '<b>'.$status.'</b>';
    }
}

if (!function_exists('status_division')) {
    function status_division($type)
    {
        if ($type == 0) {
            $status = ' DRAFT';
            $color = 'danger';

        } else if ($type == 1) {
            $status = ' SUBMITTED';
            $color = 'primary';

        } elseif ($type == 3) {
            $status = ' HR CONFIRMED';
            $color = 'success';
        
        } elseif ($type == 2) {
            $status = ' REVISED';
            $color = 'warning';

        }  else {
            $status = ' Undefined';
            $color = 'danger';
        } 

        return '<span class="badge badge-pill badge-sm badge-' . $color . '"> ' . $status . '</span>';
    }
}

if (!function_exists('status_division_text')) {
    function status_division_text($type)
    {
        if ($type == 0) {
            $status = ' DRAFT';
            $color = 'danger';

        } else if ($type == 1) {
            $status = ' SUBMITTED';
            $color = 'primary';

        } elseif ($type == 3) {
            $status = ' HR CONFIRMED';
            $color = 'success';
        
        } elseif ($type == 2) {
            $status = ' REVISED';
            $color = 'warning';

        }  else {
            $status = ' Undefined';
            $color = 'danger';
        } 
        return '<span class="badge badge-' . $color . '"> ' . $status . '</span>';
    }
}

if (!function_exists('status_division_icon')) {
    function status_division_icon($type)
    {
        if ($type == 0) {
            $icon = 'ni-loader';

        } else if ($type == 1) {
            $icon = 'ni-check-circle';

        } elseif ($type == 3) {
            $icon = 'ni-check-round-fill';

        } elseif ($type == 2) {
            $icon = 'ni-na';

        }  else {
            $icon = ' ni-help';
        } 
        return '<em class="icon ni '.$icon.'"></em>';
    }
}


if ( ! function_exists('getSession'))
{
    function getSession($sess_name) 
    {
        $CI =& get_instance();
        return $CI->session->userdata($sess_name);
    }
}

if ( ! function_exists('get_date_interval'))
{
    function get_date_interval($start, $end)
    {
        $awal = date_create($start);
        date_add($awal, date_interval_create_from_date_string($end));
        $akhir = date_format($awal, 'Y-m-d');
        
        return $akhir;
    }
}

if ( ! function_exists('get_year_interval'))
{
    function get_year_interval($start, $end)
    {
        $awal   = new DateTime($start);
        $akhir  = new DateTime($end);        
        $interval = $akhir->diff($awal);
        return $interval->format('%y tahun, %m bulan');
    }
}

if ( ! function_exists('array_date'))
{
    function array_date($start, $end)
    {
       $range = array();    
       if (is_string($start) === true) $start = strtotime($start);
       if (is_string($end) === true ) $end = strtotime($end);      
       if ($start > $end) return array_date($end, $start);     
       do {
          $range[] = date('Y-m-d', $start);
          $start = strtotime("+ 1 day", $start);
       }
       while($start <= $end);      
       return $range;
    }
}

if ( ! function_exists('rupiah'))
{
    function rupiah($value)
    {
        if($value < 0) {
             return 'Rp. '.number_format(abs($value), 0, '', '.');
        }
        else {
             return 'Rp. '.number_format($value, 0, '', '.');
        }
    }
}

if ( ! function_exists('report_rupiah'))
{
    function report_rupiah($value)
    {
        if($value < 0) {
             return ''.number_format(abs($value), 0, '', '.');
        }
        else {
             return ' '.number_format($value, 0, '', '.');
        }
    }
}

if ( ! function_exists('encode_url'))
{
    function encode_url($key = '')
    {
        $CI =& get_instance();
        $CI->load->library('encryption');
        $str = $CI->encryption->encrypt($key);
        $str = str_replace(array('+', '/', '='), array('-', '_', '~'), $str);
        return $str;
    }
}

if ( ! function_exists('decode_url'))
{
    function decode_url($key = '')
    {
        $CI =& get_instance();
        $CI->load->library('encryption');
        $key = str_replace(array('-', '_', '~'), array('+', '/', '='), $key);
        $str = $CI->encryption->decrypt($key);
        return $str;
    }
}

if ( ! function_exists('alert'))
{
    function alert($type, $content)
    {
        $alert = '';

        if ($type == 'error')
        {
            $alert .= '<div class="alert alert-danger alert-dismissable">';
            $alert .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $alert .= '<h4><i class="fa fa-ban"></i> Terjadi kesalahan</h4>';
            $alert .= $content;
            $alert .= '</div>';
        }
        elseif ($type == 'success')
        {
            $alert .= '<div class="alert alert-success alert-dismissable">';
            $alert .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $alert .= '<h4><i class="fa fa-check"></i> Sukses</h4>';
            $alert .= $content;
            $alert .= '</div>';
        }
        elseif ($type == 'warning')
        {
            $alert .= '<div class="alert alert-warning alert-dismissable">';
            $alert .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $alert .= '<h4><i class="fa fa-warning"></i> Peringatan</h4>';
            $alert .= $content;
            $alert .= '</div>';
        }
        elseif ($type == 'info')
        {
            $alert .= '<div class="alert alert-info alert-dismissable">';
            $alert .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $alert .= '<h4><i class="fa fa-info"></i> Informasi</h4>';
            $alert .= $content;
            $alert .= '</div>';
        }

        return $alert;
    }
}

if ( ! function_exists('indo_date'))
{
    function indo_date($date)
    {
        $convert = strtotime($date);
        $convertDate = date('Y-m-d H:i:s', $convert);

        $pecah  = explode("-", substr($convertDate, 0, 10));
        $year   = $pecah[0];
        $monthh = $pecah[1];
        $day    = $pecah[2];
        
        $bulan  = ''; 
        switch($monthh)
        {
            case '01':
                 $bulan = 'Jan';
                 break;
            case '02':
                 $bulan = 'Feb';
                 break;
            case '03':
                 $bulan = 'Mar';
                 break;
            case '04':
                 $bulan = 'Apr';
                 break;
            case '05':
                 $bulan = 'Mei';
                 break;
            case '06':
                 $bulan = 'Jun';
                 break;
            case '07':
                 $bulan = 'Jul';
                 break;
            case '08':
                 $bulan = 'Agu';
                 break;
            case '09':
                 $bulan = 'Sep';
                 break;
            case '10':
                 $bulan = 'Okt';
                 break;
            case '11':
                 $bulan = 'Nov';
                 break;
            case '12':
                 $bulan = 'Des';
                 break;
         }    
         
         $result = $day.' '.$bulan.' '.$year;
         return $result;
    }
}

if ( ! function_exists('bulan'))
{
    function bulan()
    {
        return array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );
    }
}

if ( ! function_exists('get_bulan'))
{
    function get_bulan($key)
    {        
        $bulan = ''; 
        switch($key)
        {
            case '01':
                 $bulan = 'Januari';
                 break;
            case '02':
                 $bulan = 'Februari';
                 break;
            case '03':
                 $bulan = 'Maret';
                 break;
            case '04':
                 $bulan = 'April';
                 break;
            case '05':
                 $bulan = 'Mei';
                 break;
            case '06':
                 $bulan = 'Juni';
                 break;
            case '07':
                 $bulan = 'Juli';
                 break;
            case '08':
                 $bulan = 'Agustus';
                 break;
            case '09':
                 $bulan = 'September';
                 break;
            case '10':
                 $bulan = 'Oktober';
                 break;
            case '11':
                 $bulan = 'November';
                 break;
            case '12':
                 $bulan = 'Desember';
                 break;
         }    
         
         return $bulan;
    }
}

if ( ! function_exists('icon'))
{
    function icon($icon = '', $button = TRUE, $labels = FALSE)
    {
        if ($icon == '')
        {
            return '';
        }
        else
        {
            $class = '';
            $label  = '';

            switch($icon)
            {
                case 'plus' : $class = '<i class="fa fa-plus icon-only"></i>';
                           $label  = '<b>New</b> Data';
                           break;
                case 'list' : $class = '<i class="fa fa-list icon-only"></i>';
                           $label  = 'List';
                           break;
                case 'edit' : $class = '<i class="fa fa-edit icon-only"></i>';
                           $label  = '<b>Update</b> Data';
                           break;
                case 'trash' : $class = '<i class="fa fa-trash icon-only"></i>';
                           $label  = '<b>Delete</b> Data';  
                           break;
                case 'save' : $class = '<i class="fa fa-save icon-only"></i>';
                           $label  = 'Save';
                           break;
                case 'undo' : $class = '<i class="fa fa-undo icon-only"></i>';
                           $label  = 'Cancel';
                           break;
                case 'show' : $class = '<i class="fa fa-search-plus icon-only"></i>';
                           $label  = '<b>Data</b> Detail';
                           break;
                case 'print' : $class = '<i class="glyphicon glyphicon-print icon-only"></i>';
                           $label  = 'Print';
                           break;
                case 'user' : $class = '<i class="fa fa-user icon-only"></i>';
                           $label  = 'Pengguna';
                           break;
                case 'quotes' : $class = '<i class="fa fa-quote-left icon-only"></i>';
                           $label  = 'Quotes';
                           break;
                case 'tag' : $class = '<i class="fa fa-tag icon-only"></i>';
                           $label  = 'Tags';
                           break;
                case 'wrench' : $class = '<i class="fa fa-wrench icon-only"></i>';
                           $label  = 'Pengaturan';
                           break;
                case 'cogs' : $class = '<i class="fa fa-cogs icon-only"></i>';
                           $label  = 'Setting';
                           break;
                case 'picture' : $class = '<i class="fa fa-picture-o icon-only"></i>';
                           $label  = 'Gallery Photo';
                           break;
                case 'video' : $class = '<i class="glyphicon glyphicon-facetime-video icon-only"></i>';
                           $label  = 'Gallery Video';
                           break;
                case 'files' : $class = '<i class="fa fa-files-o icon-only"></i>';
                           $label  = 'Pages';
                           break;
                case 'sort' : $class = '<i class="fa fa-sort-alpha-asc icon-only"></i>';
                           $label  = 'Struktur';
                           break;
                case 'link' : $class = '<i class="fa fa-external-link icon-only"></i>';
                           $label  = 'Link';
                           break;
            }

            if ($labels == FALSE) {
                $data = $class;
            }
            elseif ($button == FALSE) {
                // $exp = explode(' ', $label);
                // $data = '<b>'.$exp[0].'</b> ' .$exp[1];
                $data = $label;
            }
            else {
                $data = $class . ' ' . $label;   
            }

            return $data;
        }
    }
}

if ( ! function_exists('status'))
{
    function status($key = '')
    {
        $message = '';

        switch ($key)
        {
            case 'created':
                 $message = '<span>Saved</span>';
                 break;
            case 'not_created':
                 $message = '<span>Not saved</span>';
                 break;
            case 'updated':
                 $message = '<span>Successfully updated</span>';
                 break;
            case '404':
                 $message = '<span>Not found</span>';
                 break;
            case 'deleted':
                 $message = '<span>Successfully deleted</span>';
                 break;
            case 'not_deleted':
                 $message = '<span>Not deleted</span>';
                 break;
            case 'not_selected':
                 $message = '<span>No data selected</span>';
                 break;
            case 'activated':
                 $message = '<span>Data berhasil diaktifkan</span>';
                 break;
            case 'not_activated':
                 $message = '<span>Data tidak bisa diaktifkan</span>';
                 break;
            case 'existed':
                 $message = '<span>Already exists</span>';
                 break;
            case 'is_used':
                 $message = '<span>Data tidak bisa dihapus karena sudah digunakan pada tabel lain</span>';
                 break;
        }

        return $message;
    }
}

if ( ! function_exists('valid_url'))
{
    function valid_url($str)
    {
        $pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
        
        if ( ! preg_match($pattern, $str))
        {
            return FALSE;
        }

        return TRUE;
    }
}

if ( ! function_exists('email_name'))
{
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
}

if ( ! function_exists('getBulan'))
{
    function getTanggalBulan($datetime)
    {
        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $date = explode(" ", $datetime)[0];
        $tanggal = explode("-", $date)[2];
        $bulan = explode("-", $date)[1];

        return $tanggal . " " . $bulanIndo[abs($bulan)];
    }
}

if (!function_exists('getTime')) {
    function getTime($datetime)
    {
        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $time = explode(" ", $datetime)[1];

        return $time;
    }
}