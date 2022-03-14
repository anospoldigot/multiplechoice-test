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
                                    <h3 class="card-title">List Data Perusahaan</h3>
                                    <button type="button" class="btn btn-success float-right" onclick="add_perusahaan()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Nama Perusahaan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($perusahaan as $data) : ?>
                                                <tr class="text-center">
                                                    <td><?= $i++ ?></td>
                                                    <td><strong><?= $data->nama_perusahaan ?></strong></td>
                                                    <td>
                                                        <a style="" href="<?= site_url('admin/perusahaan/list_test/' . $data->id_perusahaan) ?>" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-clipboard-list"></i><br>
                                                            Lihat test
                                                        </a>
                                                        <a style="" href="<?= site_url('admin/user/list/' . $data->id_perusahaan) ?>" class="btn btn-success btn-sm">
                                                            <i class="fas fa-users"></i><br>
                                                            Users
                                                        </a>
                                                        <button style="" type="button" class="btn btn-info btn-sm" title="Edit" onclick="edit_perusahaan('<?php echo $data->id_perusahaan ?>')">
                                                            <i class="fas fa-edit"></i><br>
                                                            Edit
                                                        </button>
                                                        <button style="" type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('<?= site_url('admin/perusahaan/delete/' . $data->id_perusahaan) ?>','<?= $data->nama_perusahaan ?>')">
                                                            <i class="fas fa-trash"></i><br>
                                                            Hapus
                                                        </button>
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

    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-tambah" action="<?= site_url('admin/perusahaan/save') ?>" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Perusahaan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_perusahaan">Nama Perusahaan</label>
                            <input type="text" required name="nama_perusahaan" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Perusahaan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="form1" action="<?php echo site_url("admin/perusahaan/update") ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="">
                        <div class="form-group">
                            <label for="helpInputTop">Nama Perusahaan</label>
                            <input type="text" required name="nama_perusahaan" class="form-control" id="helpInputTop">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function add_perusahaan() {
            save_method = 'add';
            $('#form-tambah')[0].reset(); // reset form on modals
            $('#modal-tambah').modal('show'); // show bootstrap modal
            $('.modal-title').text('Tambah Perusahaan'); // Set Title to Bootstrap modal title
        }

        function edit_perusahaan(id) {
            save_method = 'update';
            $('#form1')[0].reset(); // reset form on modals

            //Ajax Load data from ajax
            $.ajax({
                url: "<?php echo site_url('admin/perusahaan/edit') ?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id"]').val(data.id_perusahaan);
                    $('[name="nama_perusahaan"]').val(data.nama_perusahaan);
                    $('#default').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Perusahaan'); // Set title to Bootstrap modal title

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        function confirmDelete(link, nama) {
            Swal.fire({
                title: 'Apakah Anda Ingin Menghapus Perusahaan ' + nama,
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