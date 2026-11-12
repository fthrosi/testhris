<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/tcpdf/tcpdf.php');
require_once(dirname(__FILE__).'/tcpdf/tcpdf_barcodes_2d.php');

class my_pdf extends TCPDF
{
   protected $headerType = 'default';

    function __construct()
    {
        parent::__construct();
    }

    public function setHeaderType($type)
    {
        $this->headerType = $type;
    }

    public function Header()
    {
        switch ($this->headerType) {
            case 'exit_interview':
                $this->headerExitInterview();
                break;

            case 'exit_clearance':
                $this->headerExitClearance();
                break;

            case 'exit_handover':
                $this->headerExitHandover();
                break;

            default:
                break;
        }
    }

    private function headerExitInterview()
    {
        $html = '
            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;" bgcolor="#002060">
                <tr>
                    <!-- Kolom Logo (Kiri) -->
                    <td width="25%" align="left">
                        &nbsp;&nbsp;<img src="' . FCPATH . 'assets/images/logo-circle-bg.png" width="40">
                    </td>
                    <td width="50%" align="center" vertical-align="middle">
                        <div style="font-size: 12px; font-weight: bold; line-height: 1.3; color: #ffffff;">
                            PT. INFRASTRUKTUR BISNIS SEJAHTERA<br>
                            EXIT INTERVIEWS FORM
                        </div>
                    </td>
                    <!-- Kolom Judul Form (Tengah/Kanan) -->
                    <td width="25%" align="right" vertical-align="middle">
                        <div style="color: #ffffff;">CONFIDENTAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    </td>
                </tr>
            </table>
        ';

        $this->writeHTMLCell(0, 0, 10, 8, $html, 0, 0);
    }

    private function headerExitClearance()
    {
        $html = '
           <table border="0" cellpadding="1" cellspacing="0" style="width: 100%;" bgcolor="#002060">
                <tr>
                    <!-- Kolom Logo (Kiri) -->
                    <td width="25%" align="left">
                        &nbsp;&nbsp;<img src="' . FCPATH . 'assets/images/logo-circle-bg.png" width="40">
                    </td>
                    <td width="50%" align="center" vertical-align="middle">
                        <div style="font-size: 12px; font-weight: bold; line-height: 1.3; color: #ffffff;">
                            EXIT CLEARANCE FORM
                        </div>
                    </td>
                    <!-- Kolom Judul Form (Tengah/Kanan) -->
                    <td width="25%" align="right" vertical-align="middle">
                        <div style="text-align: right; font-size: 8px; font-weight: bold; color: #ffffff;">FM-IBSW-HRG-001&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    </td>
                </tr>
            </table>
        ';

        $this->writeHTMLCell(0, 0, 10, 8, $html, 0, 0);
    }
    private function headerExitHandover()
    {
        $html = '
           <table border="0" cellpadding="1" cellspacing="0" style="width: 100%;" bgcolor="#002060">
                <tr>
                    <!-- Kolom Logo (Kiri) -->
                    <td width="25%" align="left">
                        &nbsp;&nbsp;<img src="' . FCPATH . 'assets/images/logo-circle-bg.png" width="40">
                    </td>
                    <td width="50%" align="center" vertical-align="middle">
                        <div style="font-size: 12px; font-weight: bold; line-height: 1.3; color: #ffffff;">
                            FORMULIR SERAH TERIMA PEKERJAAN
                        </div>
                    </td>
                    <!-- Kolom Judul Form (Tengah/Kanan) -->
                    <td width="25%" align="right" vertical-align="middle">
                        <div style="text-align: right; font-size: 8px; font-weight: bold; color: #ffffff;">FM-IBSW-HRG-002&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    </td>
                </tr>
            </table>
        ';

        $this->writeHTMLCell(0, 0, 10, 8, $html, 0, 0);
    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */