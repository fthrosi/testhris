<?php

$current_step = isset($current_step) ? (int) $current_step : 1;
$id = encode_url($header['id_form_request']);
$steps = [
    [
        'title' => 'Submit Resignation Letter',
        'icon'  => '<path d="M3 6l9 6 9-6"/><rect x="3" y="5" width="18" height="14" rx="1.5"/><path d="M14 15l4 4M18 15v4h-4"/>',
        'url'   => base_url("form/detail/EC/{$id}")
    ],
    [
        'title' => 'Approval Resignation Letter',
        'icon'  => '<path d="M14 3H7a1.5 1.5 0 0 0-1.5 1.5v15A1.5 1.5 0 0 0 7 21h10a1.5 1.5 0 0 0 1.5-1.5V8.5L14 3z"/><path d="M14 3v5.5h4.5"/><path d="M9 14.5l2 2 4-4.5"/>',
        'url'   => base_url("inbox/detail_req_resignation_letter/{$id}")
    ],
    [
        'title' => 'Submit Exit Clearance',
        'icon'  => '<path d="M6 3h9l4 4v14a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M15 3v4h4"/><path d="M12 12v6M9 15l3-3 3 3"/>',
        'url'   => base_url("form/home_exit_clearance/{$id}")
    ],
    [
        'title' => 'Approval and Verification of Exit Clearance',
        'icon'  => '<circle cx="10.5" cy="10.5" r="6.5"/><path d="M15.5 15.5L21 21"/><path d="M8 10.5l1.6 1.6L13.5 8"/>',
        'url'   => base_url("inbox/detail/approval_mdcr/{$id}")
    ],
    [
        'title' => 'Reference Letter',
        'icon'  => '<rect x="3" y="4" width="18" height="13" rx="1.5"/><path d="M6 8h12M6 11.5h8"/><circle cx="9" cy="19.5" r="2"/><path d="M7.5 20.8L6.5 23l2.5-1 2.5 1-1-2.2"/>',
        'url'   => base_url("form/detail/EC/{$id}")
    ],
];

$total_steps = count($steps);

$complete_name = $employee['complete_name'];

$words = preg_split('/\s+/', trim($complete_name));

$initial = strtoupper(
        substr($words[0], 0, 1) .
        substr($words[count($words) - 1], 0, 1)
);

?>

<div class="ec-step-navbar">

    <div class="resignation-timeline">

        <!-- Background Line -->
        <div class="timeline-line"></div>

        <!-- Progress Line -->
        <div
            class="timeline-line-progress"
            style="width: <?= (($current_step - 1) / ($total_steps - 1)) * 100 ?>%;"
        ></div>


        <?php foreach ($steps as $index => $step): ?>

            <?php
                $step_number = $index + 1;

                $completed = $step_number <= $current_step;
                $current   = $step_number === $current_step;
                $next      = $step_number > $current_step;

                $side = $step_number % 2 === 1
                    ? 'top'
                    : 'bottom';

                $class = "timeline-item {$side}";

                if ($completed) {
                    $class .= ' completed';
                }

                if ($current) {
                    $class .= ' current';
                }
                if( $next) {
                    $class .= ' disabled';
                }
            ?>



            <a href="<?= $step['url'] ?>" class="<?= $class ?>">

                <!-- TEXT -->
                <div class="timeline-content">

                    <div class="timeline-step">
                        Step <?= sprintf('%02d', $step_number) ?>
                    </div>

                    <div class="timeline-title">
                        <?= $step['title'] ?>
                    </div>

                </div>


                <!-- ICON -->
                <div class="timeline-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <?= $step['icon'] ?>
                    </svg>
                </div>

            </a>

        <?php endforeach; ?>

    </div>
    <div class="ec-user-resign">
        <div class="title-resign-wrap">
            <h5 class="title-resign">
                    Exit Clearance Process
            </h5>
            <p class="number-request-resign">
                    Req. No: <?= $form_request['request_number'] ?>
            </p>
        </div>
        <div class="user-resign-content">
                <div class="initial-resign-user">
                        <?= $initial ?>
                </div>
                <div class="user-resign-details">
                <h4 class="user-resign-name"><?= $complete_name ?></h4>  
                <div class="user-resign-information">
                        <div class="wrap-information">
                                <i class="icon ni ni-user-c icon-description"></i>
                                <div class="wrap-description">
                                        <p class="label-description">Employee ID</p>
                                        <p class="value-description"><?= $employee['nik'] ?></p>
                                </div>
                        </div>
                        <div class="wrap-information">
                                <i class="icon ni ni-user icon-description"></i>
                                <div class="wrap-description">
                                        <p class="label-description">Position</p>
                                        <p class="value-description"><?= $employee['position'] ?></p>
                                </div>
                        </div>
                        <div class="wrap-information">
                                <i class="icon ni ni-mail icon-description"></i>
                                <div class="wrap-description">
                                        <p class="label-description">Email</p>
                                        <p class="value-description"><?= $employee['email'] ?></p>
                                </div>
                        </div>

                </div>
                </div>
        </div>
    </div>

</div>