<!DOCTYPE html>
<html lang="en">

<head>
    <?php $data['page_title'] = 'List Test'; $this->load->view('layout/head', $data) ?>
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
                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">List Test</h3>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama Test</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($list_test as $key => $value) : ?>
                                                <tr>
                                                    <td><?= $key+1 ?></td>
                                                    <td><?= $value->nama_form ?></td>
                                                    <td><?= $value->is_pretest == 0 ? '<span class="badge badge-success">Post Test</span>' : '<span class="badge badge-danger">Pre Test</span>' ?></td>
                                                    <td>
                                                        <div class="d-block d-xl-none"></div>
                                                        <a href="<?= site_url('admin/perusahaan/list_submit/' . $value->id_form  . '?key=' . $this->uri->segment(4)) ?>" class="btn btn-sm btn-success">
                                                        <i class="fas fa-file"></i><br>
                                                        Lihat submit user
                                                        </a>
                                                        <a href="<?= site_url('admin/perusahaan/test/' . $value->id_form  . '?key=' . $this->uri->segment(4)) ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-file"></i><br>
                                                        Lihat Test
                                                        </a>
                                                        <!-- <a href="<?= site_url('admin/form/change_akses/'  . $value->id_form . '?key=' . $value->akses . '&current_url=' . current_url()) ?>" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-pen"></i><br>
                                                            <?= $value->akses > 0 ? 'Buka Akses' : 'Tutup Akses' ?>  
                                                        </a> -->
                                                        <a href="<?= site_url('admin/form/user_akses/'  . $value->id_form . '?key=' . $value->id_perusahaan) ?>" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-users-cog"></i><br>
                                                            Akses Peserta
                                                        </a>
                                                        <!-- <a href="<?= site_url('admin/report/excel/'  . $value->id_form . '?key=' . $value->id_perusahaan . '&current=' . $this->uri->segment(4))  ?>" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-file-alt"></i><br>
                                                            Generate Report
                                                        </a>
                                                        <?php if($this->session->flashdata('report' . $value->id_form)): ?>
                                                            <a href="<?= base_url($this->session->flashdata('report' . $value->id_form)) ?>" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-file-alt"></i><br>
                                                                Download Report 
                                                            </a>
                                                        <?php endif; ?> -->
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
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
    <?php if($this->session->flashdata('success')) : ?>
        <script>
            Swal.fire('Berhasil', '<?= $this->session->flashdata('success') ?>', 'success');
        </script>
    <?php endif; ?>


</body>

</html>