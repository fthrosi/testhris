<?php
	if(!empty($_POST['id'])){
		$id 		= $_POST['id'];
	}
	if(!empty($_POST['periode'])){
		$periode 	= $_POST['periode'];
	}
	if(!empty($_POST['grade'])){
		$grade 		= $_POST['grade'];
	}
	if(!empty($_POST['pagu_tahun'])){
		$pagu_tahun	= $_POST['pagu_tahun'];
	}
	
?>
<div class="modal fade edit_rawat_jalan data_edit_rawat_jalan" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close"> <em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title">Edit Pagu Rawat Jalan</h5>
                <form action="#" class="pt-2 form-validate is-alter">
                    <div class="row gy-3 gx-gs">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Periode</label>
                                <input type="text" class="form-control" required min="1" placeholder="Periode" name="periode_tambah_rawat_jalan" id="periode_tambah_rawat_jalan" value="<?php echo $periode;?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="grade-objective">Grade</label>   
                                <div class="form-control-wrap">        
                                    <select class="form-control" name="grade_tambah_rawat_jalan" id="grade_tambah_rawat_jalan">
                                    <option value="<?php echo $grade;?>"><?php echo $grade;?></option>    
                                    <option value="Gol-A">Gol-A</option>
                                    <option value="Gol-B">Gol-B</option>
                                    <option value="Gol-C">Gol-C</option>
                                    <option value="Gol-D">Gol-D</option>
                                    <option value="Gol-E">Gol-E</option>
                                    <option value="Gol-F">Gol-F</option>
                                    <option value="Gol-G">Gol-G</option>
                                    <option value="Gol-H">Gol-H</option>
                                    <option value="Gol-I">Gol-I</option>
                                    <option value="Gol-J">Gol-J</option>
                                    <option value="Gol-K">Gol-K</option>
                                    <option value="Gol-L">Gol-L</option>
                                    </select>    
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Jumlah Maksimal Per Tahun</label>
                                <input type="number" class="form-control" required min="1" placeholder="Jumlah Maksimal Per Tahun" name="pagu_tahun_tambah_rawat_jalan" id="pagu_tahun_tambah_rawat_jalan" value="<?php echo $pagu_tahun;?>">
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="form-group">
                                <a href="#" class="btn btn-danger" data-dismiss="modal"> Cancel</a>
                                <button data-dismiss="modal" type="button" class="btn btn-primary tambah_pagu_rawat_jalan" id="tambah_pagu_rawat_jalan">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>