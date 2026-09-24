<div class="nk-ibx-head">
    <div class="nk-ibx-head-actions">
        <ul class="nk-ibx-head-tools g-1">
            <li>
                <?php
                    $time = date("H");
                    $timezone = date("e");
                    if ($time < "12") {
                        $say = "Good Morning";
                    } else if ($time >= "12" && $time < "17") {
                        $say = "Good Afternoon";
                    } else if ($time >= "17" && $time < "19") {
                        $say = "Good Evening";
                    } else if ($time >= "19") {
                        $say = "Good Night";
                    }
                ?>
                <h5>
                <b> <?= $say.", ".decrypt($InfoEmployee[0]->complete_name) ?></b>
                <br>
                </h5>
                <?= "It's ".$today = date("l, M j Y"); ?>
            </li>
        </ul>
    </div>
    <div>
        <ul class="nk-ibx-head-tools g-1">
            <li class="mr-n1 d-lg-none">
                <a href="#" class="btn btn-trigger btn-icon toggle" data-target="inbox-aside"><em class="icon ni ni-menu-alt-r"></em></a>
            </li>
        </ul>
    </div>
</div>

<div class="nk-ibx-reply nk-reply" data-simplebar>
    <div class="card card-preview responsive-table">
        <div class="tab-content">
            <table border='0' cellspacing="2" cellpadding="2" width="100%">
                <tr style="height: 200px;">
                    <td align="center">
                    <img height="175" src="<?=base_url();?>assets/images/user-1-preview.png">
                    </td>
                </tr>
                <tr style="height: 130px;">
                    <td align="center">
                    <font size="4">
                    <span class="tb-odr-id lead-primary fw-bold">
                        <?= (decrypt($InfoEmployee[0]->complete_name)); ?><br>
                    </span>
                    </font>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</div>