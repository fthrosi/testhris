<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/spout-master/src/Spout/Autoloader/autoload.php';

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;  

class CrontabUpsert extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index(){
        echo "Crontrab Index Page";
        echo "<br>";
        $date = date('Ymd H:i:s'); 
        print_r($date);
    }

    function start() {

        try {

            $date = date('Ymd'); 
            
            $result = TRUE;
            $datapo = array();
            $dataimport = array();
            $dataDocument = array();
            $now = date('Y-m-d H:i:s');
            // $filepath = './app/source/PO_Data-'.$date.'.csv'; // Daily
            // $filepath = './app/source/manual.csv'; // Manual
            $filepath = './app/source/PO_Data-20190411-req2.csv'; // Manual

            $reader = ReaderFactory::create(Type::CSV);
            $reader->setShouldFormatDates(true); 	

            $reader->open($filepath);

            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    $dataDocument[] = $row;
                }
            }
            $reader->close();

            $countData = count($dataDocument)-1;

            for ($i = 0; $i < $countData ; $i++) {  

                if ($dataDocument[$i][0] == null ) break;
                $datapo[$i]['po_number']                = $dataDocument[$i][0];
                $datapo[$i]['company_code']             = $dataDocument[$i][1];
                $datapo[$i]['po_created_date']          = $dataDocument[$i][2];
                $datapo[$i]['vendor_code']              = $dataDocument[$i][3];
                $datapo[$i]['document_date']            = $dataDocument[$i][4];
                $datapo[$i]['po_line_item']             = $dataDocument[$i][5];
                $datapo[$i]['deletion_flag']            = $dataDocument[$i][6];
                $datapo[$i]['po_changed_date']          = $dataDocument[$i][7];
                $datapo[$i]['short_text_item']          = $dataDocument[$i][8];
                $datapo[$i]['material_code']            = $dataDocument[$i][9];
                $datapo[$i]['po_quantity']              = $dataDocument[$i][10];
                $datapo[$i]['others_column']            = $dataDocument[$i][11]; // lompat 1 kolom
                $datapo[$i]['order_unit']               = $dataDocument[$i][12];  
                $datapo[$i]['per']                      = $dataDocument[$i][13];
                $datapo[$i]['net_value']                = $dataDocument[$i][14];
                $datapo[$i]['gross_value']              = $dataDocument[$i][15];
                $datapo[$i]['vendor_name']              = $dataDocument[$i][16];
                $datapo[$i]['wbs_element']              = $dataDocument[$i][17];
                $datapo[$i]['material_desc']            = $dataDocument[$i][18];
                $datapo[$i]['amount_ir']                = $dataDocument[$i][19];
                $datapo[$i]['header_text']              = $dataDocument[$i][20];
                $datapo[$i]['header_note']              = isset($dataDocument[$i][21]) ? $dataDocument[$i][21] : '';
                $datapo[$i]['delivery_complete_flag']   = isset($dataDocument[$i][22]) ? $dataDocument[$i][22] : '';
                $datapo[$i]['final_invoice_flag']       = isset($dataDocument[$i][23]) ? $dataDocument[$i][23] : '';
                $datapo[$i]['created_on']               = $now;
            }
            
            $this->db->trans_start();
            
            for ($i = 0; $i <= count($datapo); $i++) {
                $dataimport[$i] = array(
                    'po_number'                => $datapo[$i]['po_number'],
                    'company_code'             => $datapo[$i]['company_code'],
                    'po_created_date'          => $datapo[$i]['po_created_date'],
                    'vendor_code'              => $datapo[$i]['vendor_code'],
                    'document_date'            => $datapo[$i]['document_date'],
                    'po_line_item'             => $datapo[$i]['po_line_item'],
                    'deletion_flag'            => $datapo[$i]['deletion_flag'],
                    'po_changed_date'          => $datapo[$i]['po_changed_date'],
                    'short_text_item'          => $datapo[$i]['short_text_item'],
                    'material_code'            => $datapo[$i]['material_code'],
                    'po_quantity'              => $datapo[$i]['po_quantity'],
                    'order_unit'               => $datapo[$i]['order_unit'],
                    'per'                      => $datapo[$i]['per'],
                    'net_value'                => $datapo[$i]['net_value'],
                    'gross_value'              => $datapo[$i]['gross_value'],
                    'vendor_name'              => $datapo[$i]['vendor_name'],
                    'wbs_element'              => $datapo[$i]['wbs_element'],
                    'material_desc'            => $datapo[$i]['material_desc'],
                    'amount_ir'                => $datapo[$i]['amount_ir'],
                    'header_text'              => $datapo[$i]['header_text'],
                    'header_note'              => $datapo[$i]['header_note'],
                    'delivery_complete_flag'   => $datapo[$i]['delivery_complete_flag'],
                    'final_invoice_flag'       => $datapo[$i]['final_invoice_flag'],
                    'created_on'               => $datapo[$i]['created_on'],
                );

                $where = array(
                        'po_number'     => $dataimport[$i]['po_number'], 
                        'po_line_item'  => $dataimport[$i]['po_line_item'], 
                        'wbs_element'   => $dataimport[$i]['wbs_element']
                        );
                
                $this->db->set($dataimport[$i]);
                $this->db->where($where);
                $this->db->update("tm_sap");

                if ($this->db->affected_rows() === 0) {
                    if ($dataimport[$i]['po_number'] == null ) {
                        break;
                    } else {
                        $this->db->insert("tm_sap", $dataimport[$i]);
                    }
                } 
            }

            

            if ($this->db->trans_status() === FALSE) {
                echo 'Failed - '.date('Y-m-d H:i:s');
            }
            else {
                $this->db->trans_complete();
                echo 'Successfully imported at '.date('Y-m-d H:i:s');
            }


        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

}
?>
