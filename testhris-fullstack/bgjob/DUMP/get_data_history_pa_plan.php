
<?php
require 'phpmailer/PHPMailerAutoload.php';
class KeyValuePair
{
    public $Key;
    public $Value;
}

function compare($first, $second) {
	return strcmp($first->Value, $second->Value);
}

function GetShiftIndexes($key)
{
	$keyLength = strlen($key);
	$indexes = array();
	$sortedKey = array();
	$i;

	for ($i = 0; $i < $keyLength; ++$i) {
		$pair = new KeyValuePair();
		$pair->Key = $i;
		$pair->Value = $key[$i];
		$sortedKey[] = $pair;
	}

	usort($sortedKey, "compare");
	$i = 0;

	for ($i = 0; $i < $keyLength; ++$i)
		$indexes[$sortedKey[$i]->Key] = $i;

	return $indexes;
}

function encrypt($str) {
	$offset = chr(53);
    $encrypted_text = "";
    $offset = $offset % 26;
    if($offset < 0) {
        $offset += 26;
    }
    
    $offset2 = $offset % 10;
    if($offset2 < 0) {
        $offset2 += 10;
    }
    
    $i = 0;
    while($i < strlen($str)) {
        $c = $str[$i]; 
        if(($c >= "A") && ($c <= "Z")) {
            if((ord($c) + $offset) > ord("Z")) {
                $encrypted_text .= chr(ord($c) + $offset - 26);
            } else {
                $encrypted_text .= chr(ord($c) + $offset);
            }
      } elseif(($c >= "a") && ($c <= "z")) {
            if((ord($c) + $offset) > ord("z")) {
                $encrypted_text .= chr(ord($c) + $offset - 26);
            } else {
                $encrypted_text .= chr(ord($c) + $offset);
            }
      } elseif(($c >= "0") && ($c <= "9")) {
				if((ord($c) + $offset2) > ord("9")) {
					$encrypted_text .= chr(ord($c) + $offset2 - 10);
			} else {
				$encrypted_text .= chr(ord($c) + $offset2);
			}
	  } else {
            $encrypted_text .= $c;
      }
      $i++;
    }
    
	
	$padChar = "#";
	$input 	= $encrypted_text;
	$key 	= "ibswhris";
	$output = "";
	$totalChars = strlen($input);
	$keyLength = strlen($key);
	$input = ($totalChars % $keyLength == 0) ? $input : str_pad($input, $totalChars - ($totalChars % $keyLength) + $keyLength, $padChar, STR_PAD_RIGHT);
	$totalChars = strlen($input);
	$totalColumns = $keyLength;
	$totalRows = ceil($totalChars / $totalColumns);
	$rowChars = array(array());
	$colChars = array(array());
	$sortedColChars = array(array());
	$currentRow = 0; $currentColumn = 0; $i = 0; $j = 0;
	$shiftIndexes = GetShiftIndexes($key);

	for ($i = 0; $i < $totalChars; ++$i)
	{
		$currentRow = $i / $totalColumns;
		$currentColumn = $i % $totalColumns;
		$rowChars[$currentRow][$currentColumn] = $input[$i];
	}

	for ($i = 0; $i < $totalRows; ++$i)
		for ($j = 0; $j < $totalColumns; ++$j)
			$colChars[$j][$i] = $rowChars[$i][$j];

	for ($i = 0; $i < $totalColumns; ++$i)
		for ($j = 0; $j < $totalRows; ++$j)
			$sortedColChars[$shiftIndexes[$i]][$j] = $colChars[$i][$j];

	for ($i = 0; $i < $totalChars; ++$i)
	{
		$currentRow = $i / $totalRows;
		$currentColumn = $i % $totalRows;
		$output .= $sortedColChars[$currentRow][$currentColumn];
	}
	
	
	$offset = chr(51);
    $encrypted = "";
    $offset = $offset % 26;
    if($offset < 0) {
        $offset += 26;
    }
    
    $offset2 = $offset % 10;
    if($offset2 < 0) {
        $offset2 += 10;
    }
    
    $i = 0;
    while($i < strlen($output)) {
        $c = $output[$i]; 
        if(($c >= "A") && ($c <= "Z")) {
            if((ord($c) + $offset) > ord("Z")) {
                $encrypted .= chr(ord($c) + $offset - 26);
            } else {
                $encrypted .= chr(ord($c) + $offset);
            }
      } elseif(($c >= "a") && ($c <= "z")) {
            if((ord($c) + $offset) > ord("z")) {
                $encrypted .= chr(ord($c) + $offset - 26);
            } else {
                $encrypted .= chr(ord($c) + $offset);
            }
      } elseif(($c >= "0") && ($c <= "9")) {
				if((ord($c) + $offset2) > ord("9")) {
					$encrypted .= chr(ord($c) + $offset2 - 10);
			} else {
				$encrypted .= chr(ord($c) + $offset2);
			}
	  } else {
            $encrypted .= $c;
      }
      $i++;
    }
	
	return $encrypted;
    }


    ////////////////////////////////////////////////////////$$$//////////////////////////////////////////////////


    $localhost = "localhost"; 
    $username = "cikini"; 
    $password = "@C1k1n1#2022"; 
    $dbname = "db_hris1"; 
     
    // create connection 
    $conn = new mysqli($localhost, $username, $password, $dbname); 
     
    // check connection 
    if($conn->connect_error) {
        die("connection failed : " . $con->connect_error);
    } else {
        echo "Successfully Connected<br>";
    }

    // $file_pa = "performance_appraisal.csv";
    // $file_pa = "MIGRASI_i_performance_appraisal.csv";
    // $file_pa = "MIGRASI_ii_performance_appraisal.csv";
    $file_pa = "MIGRASI_vi_performance_appraisal.csv";

    if(file_exists("/var/www/html/bgjob/temp_hris/$file_pa")){
        echo "File PA ada";
        echo "<br><br>";
    }else{
        echo "File PA tidak ada";
        echo "<br><br>";
        die;
    }
    //Data Employee
    $handle= fopen("/var/www/html/bgjob/temp_hris/$file_pa","r"); 
    $flag = true;
    while(($data=fgetcsv($handle,0,';',","))!== FALSE){ 
        // $num = count($data);
        // var_dump($num);die;
                if($flag) { $flag = false; continue; }
                $id                     = $data[0];
                $request_number         = str_replace("'","||", $data[1]);
                $full_approved_date     = '2022-12-12'; //$data[2];
                $is_status              = 3; //$data[3];
                $employee_name          = encrypt(str_replace("'","||", $data[4]));
                $employee_nik           = $data[5];
                $position               = encrypt($data[6]);
                $department             = encrypt($data[7]);
                $division               = encrypt($data[8]);
                $direct_namager         = encrypt(str_replace("'","||", $data[9]));
                $office_location        = encrypt($data[10]);
                $join_date              = $data[11];
                $employment_status      = encrypt($data[12]);
                $sub_total_kpi          = encrypt($data[13]);
                $sub_total_qualitative  = encrypt($data[14]);
                $sub_total_weight       = encrypt($data[15]);
                $pre_final_score        = encrypt($data[16]);
                $final_score            = encrypt($data[17]);
                $area_improvement       = encrypt($data[18]);
                $development_plan       = encrypt($data[19]);
                $comment_employee       = encrypt($data[20]);
                $comment_head_1         = encrypt($data[21]);
                $comment_head_2         = encrypt($data[22]);
                $evaluation_period_start= '2022-01-01';//$data[23];
                $evaluation_period_end  = '2022-12-31';//$data[24];
                $created_by             = encrypt($data[25]);
                $created_at             = '2022-12-12'; //$data[26];
                $updated_by             = encrypt($data[27]);
                $updated_at             = '2022-12-12'; //$data[28];
                $deleted_by             = encrypt($data[29]);
                $deleted_at             = '2022-12-12'; //$data[30];
                $grand_total_kpi        = encrypt($data[31]);
                $grand_total_qualitative= encrypt($data[32]);
                $plan_total_weight      = encrypt($data[33]);
                $work_efficiency        = encrypt($data[34]);
                $work_efficiency_result = encrypt($data[35]);
                $work_quality           = encrypt($data[36]);
                $work_quality_result    = encrypt($data[37]);
                $communication          = encrypt($data[38]);
                $communication_result   = encrypt($data[39]);
                $planing                = encrypt($data[40]);
                $planing_result         = encrypt($data[41]);
                $problem_solving        = encrypt($data[42]);
                $problem_solving_result = encrypt($data[43]);
                $team_work              = encrypt($data[44]);
                $team_work_result       = encrypt($data[45]);
                $potential              = encrypt($data[46]);
                $potential_result       = encrypt($data[47]);
                $initiative             = encrypt($data[48]);
                $initiative_result      = encrypt($data[49]);
                $leadership             = encrypt($data[50]);
                $leadership_result      = encrypt($data[51]);
                $employee_id            = $data[52];
                $performance_plan_flag  = $data[53];
                $result_document        = $data[54];
                $count_print            = $data[55];
                $count_row_kpi          = $data[56];
                $count_plan_financial   = $data[57];
                $count_plan_customer    = $data[58];
                $count_plan_learning    = $data[59];
                $count_plan_internal    = $data[59];
                $new_employee_flag      = $data[61];
                $division_root          = 0; //$data[62];
                $count_training         = $data[63];
                $nine_box_performance   = $data[64];
                $nine_box_potential     = $data[65];
                $nine_box_note          = $data[66];
                $final_score_dummy      = $data[67];
                $is_leaving             = $data[68];
                $employee_grade         = $data[69];

                $sql = "SELECT * FROM performance_appraisal WHERE employee_nik='".$employee_nik."' AND evaluation_period_start='".$evaluation_period_start."' AND evaluation_period_end='".$evaluation_period_end."'";
                
                $result = $conn->query($sql);
                        if($result === false) {
                            print_r('error1');die;
                        }else{
                            echo '<br>';
                            print_r('Success Reading Data');
                            echo '<br>';
                        }
                $row = mysqli_fetch_array($result);
                        
                if (empty($row[0])){
                    $sql ="INSERT INTO performance_appraisal (id, request_number, full_approved_date, is_status, employee_name, employee_nik, position, departement, division, direct_manager, office_location, join_date, employment_status, sub_total_kpi, sub_total_qualitative, sub_total_weight, pre_final_score, final_score, area_improvement, development_plan, comment_employee, comment_head_1, comment_head_2, evaluation_period_start, evaluation_period_end, created_by, created_at, updated_by, updated_at, deleted_by, deleted_at, grand_total_kpi, grand_total_qualitative, plan_total_weight, work_efficiency, work_efficiency_result, work_quality, work_quality_result, communication, communication_result, planing, planing_result, problem_solving, problem_solving_result, team_work, team_work_result, potential, potential_result, initiative, initiative_result, leadership, leadership_result, employee_id, performance_plan_flag, result_document, count_print, count_row_kpi, count_plan_financial, count_plan_customer, count_plan_learning, count_plan_internal, new_employee_flag, division_root, count_training, nine_box_performance, nine_box_potential, nine_box_note, final_score_dummy, is_leaving, employee_grade) VALUES ('$id', '$request_number', '$full_approved_date', '$is_status', '$employee_name', '$employee_nik', '$position', '$departement', '$division', '$direct_manager', '$office_location', '$join_date', '$employment_status', '$sub_total_kpi', '$sub_total_qualitative', '$sub_total_weight', '$pre_final_score', '$final_score', '$area_improvement', '$development_plan', '$comment_employee', '$comment_head_1', '$comment_head_2', '$evaluation_period_start', '$evaluation_period_end', '$created_by', '$created_at', '$updated_by', '$updated_at', '$deleted_by', '$deleted_at', '$grand_total_kpi', '$grand_total_qualitative', '$plan_total_weight', '$work_efficiency', '$work_efficiency_result', '$work_quality', '$work_quality_result', '$communication', '$communication_result', '$planing', '$planing_result', '$problem_solving', '$problem_solving_result', '$team_work', '$team_work_result', '$potential', '$potential_result', '$initiative', '$initiative_result', '$leadership', '$leadership_result', '$employee_id', '$performance_plan_flag', '$result_document', '$count_print', '$count_row_kpi', '$count_plan_financial', '$count_plan_customer', '$count_plan_learning', '$count_plan_internal', '$new_employee_flag', '$division_root', '$count_training', '$nine_box_performance', '$nine_box_potential', '$nine_box_note', '$final_score_dummy', '$is_leaving', '$employee_grade')";
                    $stmt = $conn->query($sql);
                    if( $stmt === false ) {
                        die( print_r( mysqli_errors(), true));
                    }else{
                        echo '<br>';
                        print_r('Success Input Data '.$employee_nik);
                        echo '<br>';
                    }

                }else{
                    echo '<br>';
                    print_r('Already Exist '.$employee_nik);
                    echo '<br>';
                }
            }
?>
