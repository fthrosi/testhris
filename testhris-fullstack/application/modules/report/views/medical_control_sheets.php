<style>
    .tableFixHead          { overflow: auto; height: 100px; }
    .tableFixHead thead { position: sticky; top: 0; z-index: 1;}
</style>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<div class="nk-ibx-head">
    
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>
    <br>
    <center><h5 class="title"><span class="text-soft">MEDICAL CONTROL SHEETS</span></h5></center>
    <!-- Request Reporting -->
    <div class="nk-ibx-reply-item nk-reply-item">
        <table class="table table-orders">
            <tbody class="tb-odr-body">
                <tr class="tb-odr-item">
                    <input type="hidden" id="access_employee" name="access_employee" value="<?=$this->session->userdata('access_employee')?>">
                    <input type="hidden" id="employee_nik" name="employee_nik" value="<?=$this->session->userdata('nik')?>">
                    <td class="tb-odr-info">
                      <span class="tb-odr-id text-soft">NIK</span>
                      <input type="number" class="form-control" required min="1" placeholder="Nomer Induk Kepegawaian" name="nik_mcs" id="nik_mcs">
                    </td>
                    <?php if ($this->session->userdata('access_employee') == '12' && $this->session->userdata('nik') == '00000000'){ 
                    ?>
                      <td class="tb-odr-info">
                        <span class="tb-odr-id text-soft">TAHUN</span>
                        <input type="number" class="form-control" required min="1" placeholder="Tahun" name="tahun_mcs" id="tahun_mcs">
                      </td>      
                      <td class="tb-odr-info">
                        <span class="tb-odr-id text-soft">FI Request Number</span>
                        <div class="input-group">            
                          <div class="input-group-prepend">                
                            <span class="input-group-text" id="basic-addon3">HRIS_MDCR</span>            
                          </div>            
                          <input type="number" class="form-control" required min="1" placeholder="FI Request Number" name="req_group_mcs" id="req_group_mcs">
                        </div>
                      </td>
                    <?php } else { ?>
                      <td class="tb-odr-info">
                        <span class="tb-odr-id text-soft">FI Request Number</span>
                        <div class="input-group">            
                          <div class="input-group-prepend">                
                            <span class="input-group-text" id="basic-addon3">HRIS_MDCR</span>            
                          </div>            
                          <input type="number" class="form-control" required min="1" placeholder="FI Request Number" name="req_group_mcs" id="req_group_mcs">
                        </div>
                      </td>
                    <?php } ?>
                    <td>
                      <span class="tb-odr-id text-soft"></span><br>
                      <button type="button" class="btn btn-primary search_mcs" id="search_mcs" style="float: left;">Search</button>
                    </td>
                    <!-- <td class="tb-odr-info">
                        <span class="tb-odr-id text-soft">Date Range</span>
                        <div class="input-daterange date-picker-range input-group">            
                            <input type="text" class="form-control" readonly/>            
                                <div class="input-group-addon">TO</div>  
                            <input type="text" class="form-control" readonly/> 
                        </div>          
                    </td> -->
                </tr>
            </tbody>
        </table>
        <?php
        if(empty($query)){
            $param = '';
        }else{
            $param = "?".$query;
        }
        ?>
    </div>
    <div class="nk-ibx-reply-item nk-reply-item" >
    <?php
    if((!empty($employee)) && ($employee != '00000000')){
    ?>

    <?php if ($content_query == 'not empty'){ 
    ?>
      <table class="table tableFixHead table-striped" id="tbl_exporttable_to_xls" border="1">
        <thead>
          <tr align="center" bgcolor="#BABABA">
            <th width="5.25%" >NIK</th>
            <th width="6.25%" >Complete_Name</th>
            <th width="6.25%" >Request_Number</th>
            <th width="6.25%" >FI_Request_Number</th>
            <th width="6.25%" >Function/Position</th>
            <th width="6.25%" >Department</th>
            <th width="6.25%" >Grade/Group</th>
            <th width="6.25%" >Employement_Status</th>
            <th width="6.25%" >Join_Date</th>
            <th width="6.25%" >Request_Date</th>
            <th width="6.25%" >Type_Of_Reimbursment</th>
            <th width="6.25%" >Doctor_Name</th>
            <th width="6.25%" >Kwitansi_Date</th>
            <th width="6.25%" >Nominal</th>
            <th width="6.25%" >Balance</th>
            <th width="6.25%" >Category</th>
          </tr>
        </thead>
        <?php

            foreach($employee as $la){
                $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $url_components = parse_url($url);
                parse_str($url_components['query'], $params);
                $param = $url_components['query'];
                $no_ref = $params['no_req_group'];
                if (isset($params['tahun'])) {
                  $tahun = $params['tahun'];
                } else {
                  $tahun = '';
                }
                
                // dumper($tahun);
                if(!empty($no_ref)){
                    $no_ref = $no_ref;
                }else{
                    $no_ref = '';
                }
                
                //$data_claim = $this->report_model->get_data_claim_per_employee_base_on_nik_or_noreq($la, $no_ref); 
                $data_claim = $this->report_model->get_data_fi($la, $no_ref, $tahun);
                // dumper($data_claim);

                $req_id = array();
                foreach ($data_claim as $key => $value) {
                    $req_id[$key]=$value->request_id;
                }
                foreach($req_id as $k=>$v) {
                if( ($kt=array_search($v,$req_id))!==false and $k!=$kt )
                    { unset($req_id[$kt]);}
                }
                $req_id = implode(', ', $req_id);

                $listReq_id = array();
                foreach ($data_claim as $key) {
                    $listReq_id[] = $key->request_id;
                }
                $form_request_id = join("','",$listReq_id);
                $pagu_request = $this->report_model->get_data_pagu($la, $fi_year);
                $total_claim_request = $this->report_model->get_data_fi_total($form_request_id, $fi_year);
                // dumper($total_claim_request);

                //$data_total = $this->report_model->get_data_total_claim_per_employee($req_id);
                //dumper($data_claim);
        ?>
          <tbody>
              <tr  align="center" bgcolor="#ededed">
                  <th colspan="14"><center>Beginning Balance</center></th>
                  <th><?php echo number_format($pagu_request['pagu_jalan_tahun']);?></th>
                  <th>Out-Patient</th>
              </tr>
              <?php
              foreach($data_claim as $claim){
                  if($claim->employee_id == $la){
                      if ( ($claim->tor_grandparent == 'Rawat Jalan') ){
                          $data_employee = $this->report_model->get_data_employee_current(decrypt($claim->id_hr_emp), null);
              ?>
                          <tr align="center">
                              <td><?php echo $data_employee[0]->nik;?></td>
                              <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->complete_name)));?></td>
                              <td><?php echo $claim->request_number;?></td>
                              <td><?php echo $claim->no_req_mdcr;?></td>
                              <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->position)));?></td>
                              <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->department)));?></td>
                              <td><?php 
                                  if(((decrypt($data_employee[0]->employee_group)) == 'GOL B') || ((decrypt($data_employee[0]->employee_group) == 'GOL C'))){
                                      $gol = "GOL B-C";
                                  }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL D') || ((decrypt($data_employee[0]->employee_group) == 'GOL E'))){
                                      $gol = "GOL D-E";
                                  }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL F') || ((decrypt($data_employee[0]->employee_group) == 'GOL G'))){
                                      $gol = "GOL F-G";
                                  }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL H') || ((decrypt($data_employee[0]->employee_group) == 'GOL I'))){
                                      $gol = "GOL H-I";
                                  }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL J') || ((decrypt($data_employee[0]->employee_group) == 'GOL K')) || ((decrypt($data_employee[0]->employee_group) == 'GOL L'))){
                                      $gol = "GOL J-K-L";
                                  }else if((decrypt($data_employee[0]->employee_group)) == 'GOL A') {
                                      $gol = "GOL A";
                                  }
                                  echo $gol;
                              ?></td>
                              <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->employee_subgroup)));?></td>
                              <td><?php echo (DateTime::createFromFormat('Ymd', decrypt($data_employee[0]->join_date)))->format('d.m.Y');?></td>
                              <td><?php echo (DateTime::createFromFormat('Y-m-d', $claim->create_date))->format('d.m.Y');?></td>
                              <td><?php echo $claim->tor_grandparent.' - '.$claim->tor_parent.' - '.$claim->tor_child; ?></td>
                              <td><?php echo $claim->docter;?></td>
                              <td><?php echo (DateTime::createFromFormat('Y-m-d', $claim->tanggal_kuitansi))->format('d.m.Y');?></td>
                              <td><?php echo number_format($claim->penggantian);?></td>
                              <td></td>
                              <td>Out-Patient</td>
                          </tr>
              <?php
                      }
                  }
              }
              ?> 
              <tr  align="center" bgcolor="#ededed">
                  <th colspan="13"><center>TOTAL</center></th>
                  <th><?php echo number_format($total_claim_request[0]->sum_penggantian_jalan);?></th>
                  <th><?php echo number_format($pagu_request['pagu_jalan_tahun'] - $total_claim_request[0]->sum_penggantian_jalan) ;?></th>
                  <th>Out-Patient</th>
              </tr>
              <tr  align="center" bgcolor="#ededed">
              <th colspan="14" align="center"><center>Beginning Balance</center></th>
                  <th><?php echo number_format($pagu_request['pagu_inap_tahun']);?></th>
                  <th>In-Patient</th>
              </tr>
              <?php
              foreach($data_claim as $claim){
                  if($claim->employee_id == $la){

                      if ( ($claim->tor_grandparent == 'Rawat Inap') ){
                          $data_employee = $this->report_model->get_data_employee_current(decrypt($claim->id_hr_emp), null);
              ?>
                              <tr align="center">
                                  <td><?php echo $la;?></td>
                                  <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->complete_name)));?></td>
                                  <td><?php echo $claim->request_number;?></td>
                                  <td><?php echo $claim->no_req_mdcr;?></td>
                                  <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->position)));?></td>
                                  <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->department)));?></td>
                                  <td><?php 
                                      if(((decrypt($data_employee[0]->employee_group)) == 'GOL B') || ((decrypt($data_employee[0]->employee_group) == 'GOL C'))){
                                          $gol = "GOL B-C";
                                      }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL D') || ((decrypt($data_employee[0]->employee_group) == 'GOL E'))){
                                          $gol = "GOL D-E";
                                      }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL F') || ((decrypt($data_employee[0]->employee_group) == 'GOL G'))){
                                          $gol = "GOL F-G";
                                      }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL H') || ((decrypt($data_employee[0]->employee_group) == 'GOL I'))){
                                          $gol = "GOL H-I";
                                      }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL J') || ((decrypt($data_employee[0]->employee_group) == 'GOL K')) || ((decrypt($data_employee[0]->employee_group) == 'GOL L'))){
                                          $gol = "GOL J-K-L";
                                      }else if((decrypt($data_employee[0]->employee_group)) == 'GOL A') {
                                          $gol = "GOL A";
                                      }
                                      echo $gol;
                                  ?></td>
                                  <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->employee_subgroup)));?></td>
                                  <td><?php echo (DateTime::createFromFormat('Ymd', decrypt($data_employee[0]->join_date)))->format('d.m.Y');?></td>
                                  <td><?php echo (DateTime::createFromFormat('Y-m-d', $claim->create_date))->format('d.m.Y');?></td>
                                  <td><?php echo $claim->tor_grandparent.' - '.$claim->tor_parent.' - '.$claim->tor_child; ?></td>
                                  <td><?php echo $claim->docter;?></td>
                                  <td><?php echo (DateTime::createFromFormat('Y-m-d', $claim->tanggal_kuitansi))->format('d.m.Y');?></td>
                                  <td><?php echo number_format($claim->penggantian);?></td>
                                  <td></td>
                                  <td>In-Patient</td>
                              </tr>
              <?php
                      }
                  }
              }
              ?> 
              <tr  align="center" bgcolor="#ededed">
                  <th colspan="13"><center>TOTAL</center></th>
                  <th><?php echo number_format($total_claim_request[0]->sum_penggantian_inap);?></th>
                  <th><?php echo number_format($pagu_request['pagu_inap_tahun'] - $total_claim_request[0]->sum_penggantian_inap) ;?></th>
                  <th>In-Patient</th>
              </tr>
              <tr  align="center" bgcolor="#ededed">
                  <th colspan="14" align="center"><center>Beginning Balance</center></th>
                  <th><?php echo number_format($pagu_request['pagu_optic_tahun']);?></th>
                  <th>Optic</th>
              </tr>
              <?php
              foreach($data_claim as $claim){
                  if($claim->employee_id == $la){

                      if ( ($claim->tor_grandparent == 'Kacamata') ){
                          $data_employee = $this->report_model->get_data_employee_current(decrypt($claim->id_hr_emp), null);
              ?>
                          <tr align="center">
                              <td><?php echo $la;?></td>
                              <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->complete_name)));?></td>
                              <td><?php echo $claim->request_number;?></td>
                              <td><?php echo $claim->no_req_mdcr;?></td>
                              <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->position)));?></td>
                              <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->department)));?></td>
                              <td><?php 
                                      if(((decrypt($data_employee[0]->employee_group)) == 'GOL B') || ((decrypt($data_employee[0]->employee_group) == 'GOL C'))){
                                          $gol = "GOL B-C";
                                      }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL D') || ((decrypt($data_employee[0]->employee_group) == 'GOL E'))){
                                          $gol = "GOL D-E";
                                      }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL F') || ((decrypt($data_employee[0]->employee_group) == 'GOL G'))){
                                          $gol = "GOL F-G";
                                      }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL H') || ((decrypt($data_employee[0]->employee_group) == 'GOL I'))){
                                          $gol = "GOL H-I";
                                      }else if(((decrypt($data_employee[0]->employee_group)) == 'GOL J') || ((decrypt($data_employee[0]->employee_group) == 'GOL K')) || ((decrypt($data_employee[0]->employee_group) == 'GOL L'))){
                                          $gol = "GOL J-K-L";
                                      }else if((decrypt($data_employee[0]->employee_group)) == 'GOL A') {
                                          $gol = "GOL A";
                                      }
                                      echo $gol;
                              ?></td>
                              <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->employee_subgroup)));?></td>
                              <td><?php echo (DateTime::createFromFormat('Ymd', decrypt($data_employee[0]->join_date)))->format('d.m.Y');?></td>
                              <td><?php echo (DateTime::createFromFormat('Y-m-d', $claim->create_date))->format('d.m.Y');?></td>
                              <td><?php echo $claim->tor_grandparent.' - '.$claim->tor_parent.' - '.$claim->tor_child; ?></td>
                              <td><?php echo $claim->docter;?></td>
                              <td><?php echo (DateTime::createFromFormat('Y-m-d', $claim->tanggal_kuitansi))->format('d.m.Y');?></td>
                              <td><?php echo number_format($claim->penggantian);?></td>
                              <td></td>
                              <td>Optic</td>
                          </tr> 
              <?php
                      }
                  }
              }
              ?>
              <tr  align="center" bgcolor="#ededed">
                  <th colspan="13"><center>TOTAL</center></th>
                  <th><?php echo number_format($total_claim_request[0]->sum_penggantian_kacamata);?></th>
                  <th><?php echo number_format($pagu_request['pagu_optic_tahun'] - $total_claim_request[0]->sum_penggantian_kacamata) ;?></th>
                  <th>Optic</th>
              </tr> 
          </tbody>
        <?php
            }
        ?>
      </table>
      <button class="btn btn-round btn-sm btn-success" onclick="ExportToExcel('xlsx')"><em class="icon ni ni-file-xls"></em><span>Export table to excel</span></button>  
    <?php } else { ?>
      <h2>HEHE</h2>
    <?php } ?>
    
    <?php
    }
    ?>
    </div>
</div>
<script>
function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tbl_exporttable_to_xls');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('medical_control_sheet_' + <?php echo $employee[0];?> + '.' + (type || 'xlsx')));
    }
</script>