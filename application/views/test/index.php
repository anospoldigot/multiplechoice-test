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
                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">List Form</h3>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama Form</th>
                                                <th>Submit</th>
                                                <th>Action</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($form as $key => $data) : ?>
                                                <tr class="text-center">
                                                    <td><?= $key+1 ?></td>
                                                    <td><?= $data->nama_form ?></td>
                                                    <td><?= $data->total_submit ?>/2</td>
                                                    <td>
                                                        <div class="d-block d-lg-none"></div>
                                                        <?php if($data->akses == 0) : ?>
                                                            <a href="" class="disabled btn btn-warning">Tidak dapat akses</a>
                                                        <?php elseif($data->status == 0): ?>
                                                            <a href="<?= site_url('test/show/' . $data->id_form) ?>" class="btn btn-primary">Kerjakan</a>          
                                                        <?php elseif($data->status == 2): ?>         
                                                            <a href="<?= site_url('test/show/' . $data->id_form) ?>" class="btn btn-success disabled">Lulus</a>
                                                        <?php else: ?>
                                                            <a href="<?= site_url('test/show/' . $data->id_form . '?' . 'repeat=true') ?>" class="btn btn-danger">Kerjakan Lagi</a>
                                                        <?php endif; ?>
                                                        <a href="<?= site_url('test/history/' . $data->id_form . '?key=' . $data->nama_form) ?>" class="btn btn-info">History</a>
                                                    </td>
                                                    <td>
                                                        <?php if($data->status == 0): ?>
                                                            <span class="text-danger">Belum Mulai</span>
                                                        <?php elseif($data->status == 1): ?>
                                                            <span class="text-warning">Belum Lulus</span>
                                                        <?php else: ?>
                                                            <span class="text-success">Lulus</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
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


</body>

</html>