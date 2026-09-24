
<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <a onclick = "readyForPAGA(<?= $year ?>)" id = "submitKurvaGA" style = "display:<?= $show_hide; ?>;">
                    <em class="icon ni ni-send"></em>
                    Update GA Kurva
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="nk-ibx-reply nk-reply" data-simplebar>
    <div class="card card-preview">
        <div class="card-inner">
            <h3 class="title">GA Kurva <?= $year ?></h3>
                <br><br>
                        <table>
                            <tr>
                                <td width = "80">Department</td>
                                <td>:</td>
                                <td>General Affairs</td>
                            </tr>
                            <tr>
                                <td>Total Team</b></td>
                                <td>:</td>
                                <td><input type = "number" id = "hr_total_team" value = "<?=$total_team_ga;?>" disabled></td>
                            </tr>
                        </table>
                    <div class="nk-tb-list is-loose traffic-channel-table">
                        <form action = "#" id = "formKurvaGA" method = "post" enctype="multipart/form-data">
                                <input type = "hidden" name = "year" id = "year" value = "<?= $year; ?>">
                                <div class="nk-tb-item nk-tb-head">
                                    
                                    <div class="nk-tb-col"><span class="tb-lead">Score</span></div> 
                                    <div class="nk-tb-col"><span class="tb-lead">Basic Line</span></div>
                                    <!-- <div class="nk-tb-col"><span class="tb-lead">Min Basic Line</span></div>
                                    <div class="nk-tb-col"><span class="tb-lead">Max Basic Line</span></div>
                                    <div class="nk-tb-col"><span class="tb-lead">Percentage</span></div> -->
                                </div>
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col"><span class="tb-lead">A</span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_a">
                                        <input type = "number" id = "ga_basic_line_a_field" name = "basic_line[a]" value = "<?= $ga_basic_line_a ?>" onkeypress="return isNumeric(event)" onkeyup = "gaBasicLine('<?=$total_team_ga;?>')"></span>
                                    </div>
                                    <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_a"></span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_a"></span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_a">5%</span></div> -->
                                </div>
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col"><span class="tb-lead">B</span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_b">
                                        <input type = "number" id = "ga_basic_line_b_field" name = "basic_line[b]" value = "<?= $ga_basic_line_b ?>" onkeypress="return isNumeric(event)" onkeyup = "gaBasicLine('<?=$total_team_ga;?>')"></span>
                                    </div>
                                    <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_b"></span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_b"></span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_b">32%</span></div> -->
                                </div>
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col"><span class="tb-lead">C</span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_c">
                                        <input type = "number" id = "ga_basic_line_c_field" name = "basic_line[c]" value = "<?= $ga_basic_line_c ?>" onkeypress="return isNumeric(event)" onkeyup = "gaBasicLine('<?=$total_team_ga;?>')"></span>
                                    </div>
                                    <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_c"></span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_c"></span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_c">43%</span></div> -->
                                </div>
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col"><span class="tb-lead">D</span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_d">
                                        <input type = "number" id = "ga_basic_line_d_field" name = "basic_line[d]" value = "<?= $ga_basic_line_d ?>" onkeypress="return isNumeric(event)" onkeyup = "gaBasicLine('<?=$total_team_ga;?>')"></span>
                                    </div>
                                    <!-- <div class="nk-tb-col"><span class="tb-lead" id = "hr_min_line_d"></span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_max_line_d"></span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_percentage_d">15%</span></div> -->
                                </div>
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col"><span class="tb-lead">E</span></div>
                                    <div class="nk-tb-col"><span class="tb-lead" id = "hr_basic_line_e">
                                        <input type = "number" id = "ga_basic_line_e_field" name = "basic_line[e]" value = "<?= $ga_basic_line_e ?>" onkeypress="return isNumeric(event)" onkeyup = "gaBasicLine('<?=$total_team_ga;?>')"></span>
                                </div>
                        </form>
                    </div>
        </div>
    </div>
</div>


