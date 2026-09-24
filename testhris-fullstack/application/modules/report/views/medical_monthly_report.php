<style>
    .tableFixHead          { overflow: auto; height: 100px; }
    .tableFixHead thead { position: sticky; top: 0; z-index: 1;}
</style>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<div class="nk-ibx-head">
    
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>
    <br>
    <center><h5 class="title"><span class="text-soft">MEDICAL MONTHLY REPORT</span></h5></center>
    <!-- Request Reporting -->
    <div class="nk-ibx-reply-item nk-reply-item">
      <div class="col-lg-6">
        <table class="table table-orders">
            <tbody class="tb-odr-body">
                <tr class="tb-odr-item">
                    <input type="hidden" id="access_employee" name="access_employee" value="<?=$this->session->userdata('access_employee')?>">
                    <input type="hidden" id="employee_nik" name="employee_nik" value="<?=$this->session->userdata('nik')?>">
                    <td class="tb-odr-info">
                      <span class="tb-odr-id text-soft">BULAN</span>
                      <input type="month" class="form-control" required name="bulan_mmr" id="bulan_mmr">    
                    </td>
                    <td>
                      <span class="tb-odr-id text-soft"></span><br>
                      <button type="button" class="btn btn-primary search_mcs" id="search_mmr" style="float: left;">Search</button>
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
      </div>
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
    if($this->session->userdata('nik') == '00000000'){
    ?>


    <?php if ($content_query == 'not empty'){ 
    ?>
      <table class="table tableFixHead table-striped" id="tbl_exporttable_to_xls" border="1">
        <thead>
          <tr align="center" bgcolor="#BABABA">
            <th width="5.25%" >NIK</th>
            <th width="6.25%" >Complete_Name</th>
            <th width="6.25%" >Cost Center</th>
            <th width="6.25%" >Jenis Penggantian</th>
            <th width="6.25%" >Sub Penggantian</th>
            <th width="6.25%" >Detail Penggantian</th>
            <th width="6.25%" >Diagnosa</th>
            <th width="6.25%" >Status Peserta</th>
            <th width="6.25%" >Nominal Kuitansi</th>
          </tr>
        </thead>
          <tbody>
              <tr  align="center" bgcolor="#ededed">
                <th colspan="9">Klasifikasi Rawat Jalan</th>
              </tr>
              <?php
              foreach($report_monthly as $report){
                if (($report->grandparent == 'Rawat Jalan') ){
                  $data_employee = $this->report_model->get_data_employee_current(null, $report->employee_id);
              ?>
                <tr align="center">
                  <td><?php echo $data_employee[0]->nik;?></td>
                  <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->complete_name)));?></td>
                  <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->cost_center)));?></td>
                  <td><?php echo $report->grandparent;?></td>
                  <td><?php echo $report->parent;?></td>
                  <td><?php echo $report->child;?></td>
                  <td><?php echo $report->diagnosa;?></td>
                  <td><?php echo $report->keterangan;?></td>
                  <td><?php echo number_format($report->penggantian);?></td>
                </tr>
              <?php
                }
              }
              ?>
              <tr  align="center" bgcolor="#ededed">
                <th colspan="9">Klasifikasi Rawat Inap</th>
              </tr>
              <?php
              foreach($report_monthly as $report){
                if (($report->grandparent == 'Rawat Inap') ){
                  $data_employee = $this->report_model->get_data_employee_current(null, $report->employee_id);
              ?>
                <tr align="center">
                  <td><?php echo $data_employee[0]->nik;?></td>
                  <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->complete_name)));?></td>
                  <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->cost_center)));?></td>
                  <td><?php echo $report->grandparent;?></td>
                  <td><?php echo $report->parent;?></td>
                  <td><?php echo $report->child;?></td>
                  <td><?php echo $report->diagnosa;?></td>
                  <td><?php echo $report->keterangan;?></td>
                  <td><?php echo number_format($report->penggantian);?></td>
                </tr>
              <?php
                }
              }
              ?> 
              <tr  align="center" bgcolor="#ededed">
                <th colspan="9">Klasifikasi Kacamata</th>
              </tr>
              <?php
              foreach($report_monthly as $report){
                if (($report->grandparent == 'Kacamata') ){
                  $data_employee = $this->report_model->get_data_employee_current(null, $report->employee_id);
              ?>
                <tr align="center">
                  <td><?php echo $data_employee[0]->nik;?></td>
                  <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->complete_name)));?></td>
                  <td><?php echo ucwords(strtolower(decrypt($data_employee[0]->cost_center)));?></td>
                  <td><?php echo $report->grandparent;?></td>
                  <td><?php echo $report->parent;?></td>
                  <td><?php echo $report->child;?></td>
                  <td><?php echo $report->diagnosa;?></td>
                  <td><?php echo $report->keterangan;?></td>
                  <td><?php echo number_format($report->penggantian);?></td>
                </tr> 
              <?php
                }
              }
              ?>
          </tbody>
      </table>
      <button class="btn btn-round btn-sm btn-success" onclick="ExportToExcel('xlsx')"><em class="icon ni ni-file-xls"></em><span>Export table to excel</span></button>  
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
         XLSX.writeFile(wb, fn || ('medical_monthly_report.'+ (type || 'xlsx')));
    }
</script>