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
                            <?php if($this->session->flashdata('success')) : ?>
                                <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                            <?php endif; ?>
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
                                            <?php foreach($tests as $key => $test) : ?>
                                                <tr>
                                                    <td><?= $key+1 ?></td>
                                                    <td><?= $test->nama_form ?></td>
                                                    <td>
                                                        <?= $test->is_pretest > 0 ? '<span class="badge badge-danger">Pre test</span>' : '<span class="badge badge-success">Post Test</span>' ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?= site_url('/admin/test/destroy/' . $test->id_form) ?>" class="btn btn-danger btn-sm" title="Hapus Test">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                            Beri test ke perusahaan
                                                        </button> -->


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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Set Akses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= site_url('admin/test/set_akses') ?>">
                    <div class="modal-body">
                        <select name="id_perusahaan" id="id_perusahaan">
                            
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Set</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php $this->load->view('layout/script') ?>
    <?php if($this->session->flashdata('success')) : ?>
        <script>
            Swal.fire('Berhasil', '<?= $this->session->flashdata('success') ?>', 'success');
        </script>
    <?php endif; ?>


</body>

</html>