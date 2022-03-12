<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <a href="#" class="brand-link">
        <div class="shadow-none p-3 mb-5 bg-light rounded">
            <img width="300px" class="img-fluid" src="<?= site_url('assets/') ?>dist/img/korpora.png" alt="Logo">
            <!-- <span class="brand-text font-weight-light">Program Form</span> -->
        </div>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">


        <?php if ($this->session->userdata('status') == 'admin') : ?>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="<?= site_url('admin/dashboard') ?>" class="nav-link <?php if ($this->uri->segment(2) == 'dashboard') : ?> active <?php endif ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/perusahaan') ?>" class="nav-link <?php if ($this->uri->segment(2) == 'perusahaan') : ?> active <?php endif ?>">
                            <i class="nav-icon fas fa-building"></i>
                            <p>
                                List Perusahaan
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/form') ?>" class="nav-link <?php if ($this->uri->segment(2) == 'form' && $this->uri->segment(3) == '') : ?> active <?php endif ?>">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                List Test
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/form/create') ?>" class="nav-link <?php if ($this->uri->segment(3) == 'create' && $this->uri->segment(2) == 'form') : ?> active <?php endif ?>">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Create Test
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('logout') ?>" class="nav-link">
                            <i class="nav-icon fas fa-door-open"></i>
                            <p>
                                logout
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        <?php elseif ($this->session->userdata('status') == 'user') : ?>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="<?= site_url('dashboard/list_form') ?>" class="nav-link <?php if ($this->uri->segment(2) == 'list_form') : ?> active <?php endif ?>">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                List Form
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('/test/pretest') ?>" class="nav-link <?php if ($this->uri->segment(2) == 'pre') : ?> active <?php endif ?>">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Pre Test
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('dashboard/test/pre-test') ?>" class="nav-link <?php if ($this->uri->segment(2) == 'post') : ?> active <?php endif ?>">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Post Test
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= site_url('logout') ?>" class="nav-link">
                            <i class="nav-icon fas fa-door-open"></i>
                            <p>
                                logout
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        <?php endif ?>
    </div>
    <!-- /.sidebar -->
</aside>