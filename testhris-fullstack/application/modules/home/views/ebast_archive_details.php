<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Detail Request - <strong class="text-primary small"><?= $detail['request_number']; ?></strong></h3>
                            <div class="nk-block-des text-soft">
                                <ul class="list-inline">
                                    <li>Vendor Name : <span class="text-base"><?= $vendor['vendor_name']; ?></span></li>
                                    <li>Submited At: <span class="text-base"><?= $detail['created_at']; ?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <!-- <a href="<?= base_url('home/archive'); ?>" class="btn btn-outline-light bg-primary d-none d-sm-inline-flex"><em class="icon ni ni-reload"></em><span>Rollback Request</span></a> -->

                          <!--   <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalRollback"> <em class="icon ni ni-reload"></em><span>Rollback Request</span></button>  -->

                            <a href="<?= base_url('home/archive'); ?>" class="btn btn-outline-light bg-light d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back to Archive List</span></a>
                            <a href="<?= base_url('home/archive'); ?>" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="row gy-5">
                        <div class="col-lg-5">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h5 class="nk-block-title title">Application Info</h5>
                                    <p>Submission date, approve date, status etc.</p>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="card card-bordered">
                                <ul class="data-list is-compact">
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Submitted By</div>
                                            <div class="data-value"><?= $detail['created_by']; ?></div>
                                        </div>
                                    </li>
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Submitted At</div>
                                            <div class="data-value">
                                                <div class="user-card">
                                                    <div class="user-name">
                                                        <span class="tb-lead"><?= $detail['created_at']; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Status</div>
                                            <div class="data-value"><span class="badge badge-dim badge-sm badge-outline-success"><?= ebast_status($detail['is_status']); ?></span></div>
                                        </div>
                                    </li>
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Full Approved Date</div>
                                            <div class="data-value">
                                                <div class="user-card">
                                                    <div class="user-name">
                                                        <span class="tb-lead"><?= $detail['full_approved_date']; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">PO Number</div>
                                            <div class="data-value"><?= $detail['po_number']; ?></div>
                                        </div>
                                    </li>
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">WBS ID</div>
                                            <div class="data-value"><?= $detail['wbs_id']; ?></div>
                                        </div>
                                    </li>
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Site ID - Site Name</div>
                                            <div class="data-value"><?= $detail['site_id'] .' - '. $detail['site_name']; ?></div>
                                        </div>
                                    </li>
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Wokrtype</div>
                                            <div class="data-value"><?= $worktype['category_name']; ?></div>
                                        </div>
                                    </li>
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Milestone</div>
                                            <div class="data-value"><?= $milestone['name']; ?></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h5 class="nk-block-title title">Uploaded Documents</h5>
                                    <p>Here is user uploaded documents.</p>
                                </div>
                            </div>
                            
                            <div class="card card-bordered">
                                <ul class="data-list is-compact">

                                	<?php if ($worktype['category_name'] == 'SITAC' && $milestone['name'] == 'IW') { ?>
                                    
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Scanned IW</div>
                                            <div class="data-value">
                                                 <?php if ($scanned_iw['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$scanned_iw['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                	<?php } elseif (($worktype['category_name'] == 'CME' && $milestone['name'] == 'BAST 1') || ($worktype['category_name'] == 'COLO/RESELLER/MCP/STRENGTHENING' && $milestone['name'] == 'BAST 1') || ($worktype['category_name'] == 'FIBER OPTIC' && $milestone['name'] == 'BAST 1') || ($worktype['category_name'] == 'CME' && $milestone['name'] == 'RFI+BAST1')) { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Copy of CME (if any)</div>
                                            <div class="data-value">
                                                 <?php if ($copy_of_cme['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$copy_of_cme['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Original BPUJL (if PLN Scope included)</div>
                                            <div class="data-value">
                                                 <?php if ($original_bpujl['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$original_bpujl['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BAMT (Berita Acara Material Terpasang)</div>
                                            <div class="data-value">
                                                 <?php if ($bamt['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$bamt['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif (($worktype['category_name'] == 'CME' && $milestone['name'] == 'PLN') || ($worktype['category_name'] == 'COLO/RESELLER/MCP/STRENGTHENING' && $milestone['name'] == 'PLN')) { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Copy of CME PO (if any)</div>
                                            <div class="data-value">
                                                 <?php if ($copy_of_cme['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$copy_of_cme['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Original BPUJL (if PLN Scope included)</div>
                                            <div class="data-value">
                                                 <?php if ($original_bpujl['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$original_bpujl['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'CME' && $milestone['name'] == 'Opname CME') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BOQ Final Documents</div>
                                            <div class="data-value">
                                                 <?php if ($boq_final['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$boq_final['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">CME Opname Photos</div>
                                            <div class="data-value">
                                                 <?php if ($cme_opname_photos['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$cme_opname_photos['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'CME' && $milestone['name'] == 'Add CME') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BOQ Final Documents</div>
                                            <div class="data-value">
                                                 <?php if ($boq_final['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$boq_final['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'COLO/RESELLER/MCP/STRENGTHENING' && $milestone['name'] == 'Add CME') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BOQ Final Documents</div>
                                            <div class="data-value">
                                                 <?php if ($boq_final['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$boq_final['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'COLO/RESELLER/MCP/STRENGTHENING' && $milestone['name'] == 'Biaya Koordinasi') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Photo</div>
                                            <div class="data-value">
                                                <?php if ($foto_biaya_koordinasi['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$foto_biaya_koordinasi['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">KTP dan Kwitansi (1 pdf)</div>
                                            <div class="data-value">
                                                <?php if ($ktp_kwitansi['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$ktp_kwitansi['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'COLO/RESELLER/MCP/STRENGTHENING' && $milestone['name'] == 'Opname CME') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BOQ Final Documents</div>
                                            <div class="data-value">
                                                <?php if ($boq_final['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$boq_final['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">CME Opname Photos</div>
                                            <div class="data-value">
                                                 <?php if ($cme_opname_photos['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$cme_opname_photos['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif (($worktype['category_name'] == 'SITE CLEARANCE' && $milestone['name'] == 'Jasa Pengurusan') || ($worktype['category_name'] == 'SITE CLEARANCE' && $milestone['name'] == 'Site Clearance')) { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Copy of Final Documents</div>
                                            <div class="data-value">
                                                <?php if ($copy_of_document_final['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$copy_of_document_final['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'FIBER OPTIC' && $milestone['name'] == 'Add FO') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BOQ Final Documents</div>
                                            <div class="data-value">
                                                <?php if ($boq_final['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$boq_final['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'FIBER OPTIC' && $milestone['name'] == 'Opname FO') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BOQ Final Documents</div>
                                            <div class="data-value">
                                                <?php if ($boq_final['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$boq_final['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Opname Photos</div>
                                            <div class="data-value">
                                                <?php if ($fo_opname_photos['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$fo_opname_photos['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'FIBER OPTIC' && $milestone['name'] == 'Progress 70%') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Opname Photos</div>
                                            <div class="data-value">
                                                 <?php if ($fo_progress_photos['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$fo_progress_photos['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'SITE CLEARANCE' && $milestone['name'] == 'Retribusi') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Bukti Bayar</div>
                                            <div class="data-value">
                                                <?php if ($bukti_bayar['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$bukti_bayar['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Copy of Document Final</div>
                                            <div class="data-value">
                                                <?php if ($copy_of_document_final['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$copy_of_document_final['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'SITE CLEARANCE' && $milestone['name'] == 'Opname SC') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Copy Documents (Sesuai Progress)</div>
                                            <div class="data-value">
                                                <?php if ($progress_document['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$progress_document['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'SITE CLEARANCE' && $milestone['name'] == 'Add SC') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Copy of Final Documents</div>
                                            <div class="data-value">
                                                <?php if ($copy_of_document_final['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$copy_of_document_final['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'SITAC' && $milestone['name'] == 'Add Sitac') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Copy/Scanned RFC</div>
                                            <div class="data-value">
                                                <?php if ($add_sitac['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$add_sitac['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'INVENTORY' && $milestone['name'] == 'Opname') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BA Stock Opname ( @warehouse )</div>
                                            <div class="data-value">
                                                <?php if ($ba_stock_opname['file_path'] != '') { ?>
                                                    <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$ba_stock_opname['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } elseif ($worktype['category_name'] == 'GENERAL') { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">General Photo</div>
                                            <div class="data-value">
                                                <?php if ($foto_general['file_path'] != '') { ?>
                                            	   <a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$foto_general['file_path']; ?>">View File</a>
                                                <?php } else { ?>
                                                    File not Uploaded.
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } ?>


                                    <?php if ($others['file_path'] != '') { ?>
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Additional Documents</div>
                                            <div class="data-value">
                                            	<a target="_blank" href="https://fad.ibstower.com/ilink4/vendor/<?=$others['file_path']; ?>">View File</a>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h5 class="nk-block-title title">Result Document</h5>
                                    <p>You can print the result document if E-BAST status is Full Approved.</p>
                                </div>
                            </div>
                            <div class="card card-bordered">
                                <ul class="data-list is-compact">

                                <?php if ($detail['is_status'] == '3'): ?>
                                    

                                	<?php if ($form['bast_form']) { ?>
                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BAST</div>
                                            <div class="data-value">

                                            	<?php if ($worktype['category_name'] == 'INVENTORY' && $milestone['name'] == 'Opname') { ?>
                                            		<a href="https://fad.ibstower.com/ilink4/result/generate/result_document/bast_inventory_opname/<?= $this->uri->segment(4) . '/' . $detail['request_number']; ?>" target="_blank" class="btn btn-sm btn-info btn-rounded pull-left"> <i class="fa fa-print"></i> Generate </a>
                                            	<?php } else { ?>
                                            		<a href="https://fad.ibstower.com/ilink4/result/generate/result_document/bast/<?= $this->uri->segment(4) . '/' . $detail['request_number']; ?>" target="_blank" class="btn btn-sm btn-info btn-rounded pull-left"> <i class="fa fa-print"></i> Generate </a>
                                            	<?php } ?>

                                            </div>
                                        </div>
                                    </li>

                                    <?php } if ($form['ttd_form']) { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">Receipt</div>
                                            <div class="data-value">
                                            	<a href="https://fad.ibstower.com/ilink4/result/generate/result_document/ttd/<?= $this->uri->segment(4) . '/' . $detail['request_number']; ?>" target="_blank" class="btn btn-sm btn-info btn-rounded pull-left"> <i class="fa fa-print"></i> Generate </a>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } if ($form['rfi_form']) { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">RFI-RFE Certificate</div>
                                            <div class="data-value">
                                            	<a href="https://fad.ibstower.com/ilink4/result/generate/result_document/rfi/<?= $this->uri->segment(4) . '/' . $detail['request_number']; ?>" target="_blank" class="btn btn-sm btn-info btn-rounded pull-left"> <i class="fa fa-print"></i> Generate </a>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } if ($form['wtcr_form']) { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">WTCR</div>
                                            <div class="data-value text-soft">
                                            	<a href="https://fad.ibstower.com/ilink4/result/generate/result_document/wtcr/<?= $this->uri->segment(4) . '/' . $detail['request_number']; ?>" target="_blank" class="btn btn-sm btn-info btn-rounded pull-left"> <i class="fa fa-print"></i> Generate </a>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } if ($form['boq_final']) { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BOQ Final</div>
                                            <div class="data-value">
                                                <a href="https://fad.ibstower.com/ilink4/result/generate/result_boq_final/<?= $this->uri->segment(4) . '/' . $detail['request_number']; ?>" target="_blank" class="btn btn-sm btn-info btn-rounded pull-left"> <i class="fa fa-print"></i> Generate </a>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } if ($form['bast2_form']) { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BAST II</div>
                                            <div class="data-value">
                                            	<a href="https://fad.ibstower.com/ilink4/result/generate/result_document/bast2/<?= $this->uri->segment(4) . '/' . $detail['request_number']; ?>" target="_blank" class="btn btn-sm btn-info btn-rounded pull-left"> <i class="fa fa-print"></i> Generate </a>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } if ($form['ba_progress_form']) { ?>

                                    <li class="data-item">
                                        <div class="data-col">
                                            <div class="data-label">BA Progress</div>
                                            <div class="data-value">
                                            	<a href="https://fad.ibstower.com/ilink4/result/generate/result_document/ba_progress/<?= $this->uri->segment(4) . '/' . $detail['request_number']; ?>" target="_blank" class="btn btn-sm btn-info btn-rounded pull-left"> <i class="fa fa-print"></i> Generate </a>
                                            </div>
                                        </div>
                                    </li>

                                    <?php } ?>

                                <?php endif ?>


                                </ul>
                            </div>
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="modalRollback">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <main role="main" class="container">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-center"><b>Rollback Request</b></h5>
                        </div>
                    </div>
                    <hr>
                </main>
            </div>
            <div class="modal-footer bg-light">
                <span class="sub-text"></span>
            </div>
        </div>
    </div>
</div>