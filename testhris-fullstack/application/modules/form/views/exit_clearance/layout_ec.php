<div class="ec-layout">

    <!-- Sub Navbar -->
    <nav class="ec-sub-navbar">
        <?php $this->load->view('sidebar_EC', ['current_step' => $current_step]); ?>
    </nav>


    <!-- Content -->
    <main class="sub-content">
        <?= $this->load->view($main); ?>
    </main>

</div>