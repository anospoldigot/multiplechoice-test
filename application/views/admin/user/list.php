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
                                    <h3 class="card-title">List Data User</h3>
                                    <button type="button" class="btn btn-primary mx-3 float-right" data-toggle="modal" data-target="#csvModal">
                                        <i class="fas fa-plus"></i> CSV
                                    </button>
                                    <button type="button" class="btn btn-success float-right" onclick="add_user()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama User</th>
                                                <th>Email User</th>
                                                <th>Perusahaan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($user as $data) : ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= $data->nama_user ?></td>
                                                    <td><?= $data->email_user ?></td>
                                                    <td><?= $data->nama_perusahaan ?></td>
                                                    <td class="text-center">
                                                        <a style="" href="<?= site_url('admin/user/list_form/' . $data->id_user) ?>" class="btn btn-sm btn-success">
                                                            <i class="fas fa-table"></i><br>
                                                            Form Terisi
                                                        </a>
                                                        <button style="" type="button" class="btn btn-sm btn-info" title="Edit" onclick="edit_user('<?php echo $data->id_user ?>')">
                                                            <i class="fas fa-edit"></i><br>
                                                            Edit
                                                        </button>
                                                        <button style="" type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= site_url('admin/User/delete/' . $data->id_user) ?>','<?= $data->nama_user ?>')">
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
                <form id="form-tambah" action="<?= site_url('admin/user/save') ?>" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_perusahaan" value="<?= $this->uri->segment(4); ?>">

                        <div class="form-group">
                            <label for="nama_user">Nama User</label>
                            <input type="text" required name="nama_user" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email_user">email User</label>
                            <input type="email" required name="email_user" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password_user">Password User</label>
                            <input type="password" required name="password_user" class="form-control">
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
                                            
    <div class="modal fade" id="edit_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="form1" action="<?php echo site_url("admin/user/update") ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id_user" value="">
                        <input type="hidden" name="password_lama">
                        <input type="hidden" name="id_perusahaan">
                        <div class="form-group">
                            <label for="nama_user">Nama User</label>
                            <input type="text" required name="nama_user" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email_user">email User</label>
                            <input type="email" required name="email_user" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password_user">Password User</label>
                            <input type="password" name="password_user" class="form-control">
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
    <div class="modal fade" id="csvModal" tabindex="-1" aria-labelledby="csvModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= site_url('admin/test/generate_user_csv') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah User Dengan CSV file</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_perusahaan" value="<?= $this->uri->segment(4) ?>">
                        <div class="form-group">
                            <label for="batch">Batch Ke</label>
                            <input type="number" class="form-control" name="batch" id="batch" min="0" value="<?= $batch+1 ?>">
                        </div>
                        <div class="form-group">
                            <label for="csv">File CSV</label>
                            <input type="file" class="form-control-file" name="csv" id="csv">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function add_user() {
            save_method = 'add';
            $('#form-tambah')[0].reset(); // reset form on modals
            $('#modal-tambah').modal('show'); // show bootstrap modal
            $('.modal-title').text('Tambah User'); // Set Title to Bootstrap modal title
        }

        function edit_user(id) {
            save_method = 'update';
            $('#form1')[0].reset(); // reset form on modals

            //Ajax Load data from ajax
            $.ajax({
                url: "<?php echo site_url('admin/user/edit') ?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    $('[name="id_user"]').val(data.id_user);
                    $('[name="nama_user"]').val(data.nama_user);
                    $('[name="email_user"]').val(data.email_user);
                    $('[name="password_lama"]').val(data.password_user);
                    $('[name="id_perusahaan"]').val(data.id_perusahaan);
                    $('#edit_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit User'); // Set title to Bootstrap modal title

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        function confirmDelete(link, nama) {
            Swal.fire({
                title: 'Apakah Anda Ingin Menghapus User ' + nama,
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