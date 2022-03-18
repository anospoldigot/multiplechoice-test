<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('layout/head') ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php $this->load->view('layout/navbar') ?>

        <?php $this->load->view('layout/sidebar') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <!-- <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>General Form</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">General Form</li>
                            </ol>
                        </div>
                    </div> -->
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="mb-3">
                        <a href="<?= site_url('admin/form/buka_akses/'  . $this->uri->segment(4) . '?key=' . $this->input->get('key') . '&current_url=' . current_url() . '?key=' . $this->input->get('key')) ?>" class="btn btn-danger">Buka Semua Akses</a>
                        <a href="<?= site_url('admin/form/tutup_akses/'  . $this->uri->segment(4) . '?key=' . $this->input->get('key') . '&current_url=' . current_url() . '?key=' . $this->input->get('key')) ?>" class="btn btn-success">Tutup Semua Akses</a>
                    </div>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div><h3 class="card-title">List User</h3></div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped  no-footer dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Peserta</th>
                                                <th>Status Akses</th>
                                                <th>Ubah Akses</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php foreach($users as $key => $user) : ?>
                                                <tr>
                                                    <td><?= $key+1 ?></td>
                                                    <td><?= $user->nama_user ?></td>
                                                    <td><?= $user->akses > 0 ? '<span class="badge badge-success">Terbuka</span>' : '<span class="badge badge-danger">Tertutup</span>' ?></td>
                                                    <td>
                                                        <a href="<?= site_url('admin/form/change_user_akses/'  . $user->id_akses . '?key=' . $user->akses . '&current_url=' . current_url() . '?key=' . $this->input->get('key')) ?>" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i><br>
                                                            <?= $user->akses > 0 ? 'Tutup Akses' : 'Buka Akses' ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-header -->

                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <!--/.col (left) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2021 Korpora Consulting.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php $this->load->view('layout/script') ?>


</body>

</html>