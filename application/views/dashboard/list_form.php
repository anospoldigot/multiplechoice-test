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
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>List Form</h1>
                        </div>
                        <!-- <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">General Form</li>
                            </ol>
                        </div> -->
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php var_dump($form); ?>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <?php if ($this->session->flashdata('msg') != null) { ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('error') != null) { ?>
                                <div class="alert alert-warning" role="alert">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php } ?>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">List Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Form</th>
                                                <th>Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($form as $data) : ?>
                                                <tr class="text-center">
                                                    <td><?= $i++ ?></td>
                                                    <td><?= $data->nama_form ?></td>
                                                    <?php if ($data->isi == null) { ?>
                                                        <td><span class="badge badge-warning">Belum Diisi</span></td>
                                                    <?php } else { ?>
                                                        <td><span class="badge badge-success">Telah Diisi</span></td>
                                                    <?php } ?>
                                                    <td>
                                                        <?php if ($data->isi == null) { ?>
                                                            <a data-toggle="tooltip" data-placement="top" title="Isi Form" href="<?= site_url('dashboard/view_form/' . $data->id_form) ?>" class="form btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                            <button data-toggle="tooltip" type="button" class="btn btn-warning" title="Reset Form" onclick="confirmReset ('<?= site_url('dashboard/reset_form/' . $data->id_form) ?>','<?= $data->nama_form ?>')" disabled>
                                                                <i class="fas fa-redo-alt"></i>
                                                            </button>
                                                        <?php } else { ?>
                                                            <a data-toggle="tooltip" data-placement="top" title="Lihat Form" href="<?= site_url('dashboard/view_form/' . $data->id_form) ?>" class="form btn btn-primary"><i class="fas fa-eye"></i></a>
                                                            <button data-toggle="tooltip" type="button" class="btn btn-warning" title="Reset Form" onclick="confirmReset ('<?= site_url('dashboard/reset_form/' . $data->id_form) ?>','<?= $data->nama_form ?>')">
                                                                <i class="fas fa-redo-alt"></i>
                                                            </button>
                                                        <?php } ?>
                                                        <a data-toggle="tooltip" data-placement="top" title="Download Form Kosong" href="<?= site_url('dashboard/download_form/' . $data->id_form) ?>" class="form btn btn-danger"><i class="fas fa-file-pdf"></i></a>
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
    <script>
        function confirmReset(link, nama) {
            Swal.fire({
                title: 'Apakah anda ingin reset form ' + nama,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace(link)
                }
            })
        }
    </script>
</body>

</html>